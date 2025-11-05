<?php

include 'db.php';

// Get all positions
$positions = $conn->query("SELECT * FROM positions ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Voting Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
    <style>
    
      
        .position {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .position h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .total-votes {
            font-weight: bold;
            margin-bottom: 20px;
            color: #444;
        }
        .contestant {
            display: flex;
            flex-direction: column;
            /* align-items: center; */
            margin-bottom: 15px;
        }
        .contestant img {
            width: 150px;
            height: 150px;
      
            object-fit: contain;
            margin-right: 15px;
        
        }
        .contestant-details {
            flex: 1;
        }
        .name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .progress-bar {
            background: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
            height: 20px;
            margin-top: 5px;
        }
        .progress {
            height: 100%;
            background: #28a745;
            text-align: right;
            color: #fff;
            padding-right: 8px;
            font-size: 12px;
            line-height: 20px;
        }
    </style>
</head>
<body>
      <?php include 'sidebar.php'; ?>
<div class="all">
    <div class="all_box">

 


<?php foreach ($positions as $position): ?>
    <div class="position">
        <div class="forms">
            <h1>Election Results</h1>
        </div>
    <div class="forms">
            <h2><?= htmlspecialchars($position['position_name']) ?></h2>
    </div>

        <?php
        // Fetch total votes for this position
        $stmtTotal = $conn->prepare("SELECT COUNT(*) AS total_votes FROM votes WHERE position_id = ?");
        $stmtTotal->bind_param("i", $position['id']);
        $stmtTotal->execute();
        $totalResult = $stmtTotal->get_result()->fetch_assoc();
        $totalVotes = $totalResult['total_votes'];
        $stmtTotal->close();
        ?>

        <div class="total-votes">Total Votes: <?= $totalVotes ?></div>

        <?php
        // Fetch contestants and their vote counts
        $stmt = $conn->prepare("
            SELECT c.id, c.name, c.profile_image, 
                   COUNT(v.id) AS votes_count
            FROM contestants c
            LEFT JOIN votes v ON c.id = v.contestant_id AND v.position_id = ?
            WHERE c.position_id = ?
            GROUP BY c.id, c.name, c.profile_image
            ORDER BY votes_count DESC, c.name ASC
        ");
        $stmt->bind_param("ii", $position['id'], $position['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $votes = $row['votes_count'];
                $percentage = $totalVotes > 0 ? round(($votes / $totalVotes) * 100, 2) : 0;

                $image = basename(trim($row['profile_image']));
                $relativePath = "../admin/uploads/contestants/" . $image;
                $absolutePath = realpath(__DIR__ . "/../admin/uploads/contestants/" . $image);
                $imageToShow = (!empty($image) && $absolutePath && file_exists($absolutePath)) ? $relativePath : "../assets/default-profile.png";
        ?>
                <div class="contestant">
                    <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile Image">
                    <div class="contestant-details">
                        <div class="name forms"><?= htmlspecialchars($row['name']) ?> - <?= $votes ?> votes (<?= $percentage ?>%)</div>
                        <br>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?= $percentage ?>%;"><?= $percentage ?>%</div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <hr>
                </div>
        <?php
            endwhile;
        else:
            echo "<p>No contestants found for this position.</p>";
        endif;
        $stmt->close();
        ?>
    </div>
<?php endforeach; ?>
   </div>
</div>
</body>
</html>
