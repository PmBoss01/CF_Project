<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Please log in first'); window.location='login.php';</script>";
    exit();
}

$admin_name = $_SESSION['admin_name'];
include 'db.php';

$message = "";
$positions = [];

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM positions WHERE id = $id");
    header("Location: create_position.php");
    exit();
}

// Handle update request
if (isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $new_name = trim($_POST['new_position_name']);

    $check_stmt = $conn->prepare("SELECT id FROM positions WHERE position_name = ? AND id != ?");
    $check_stmt->bind_param("si", $new_name, $update_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $message = "Another position with this name already exists!";
    } else {
        $stmt = $conn->prepare("UPDATE positions SET position_name = ? WHERE id = ?");
        $stmt->bind_param("si", $new_name, $update_id);
        if ($stmt->execute()) {
            header("Location: create_position.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $check_stmt->close();
}

// Handle new position creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update_id'])) {
    $position_name = trim($_POST['position_name']);

    if (!empty($position_name)) {
        $check_stmt = $conn->prepare("SELECT id FROM positions WHERE position_name = ?");
        $check_stmt->bind_param("s", $position_name);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "Position already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO positions (position_name) VALUES (?)");
            $stmt->bind_param("s", $position_name);
            if ($stmt->execute()) {
                $message = "Position added successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $check_stmt->close();
    } else {
        $message = "Position name is required.";
    }
}

// Fetch all positions
$result = $conn->query("SELECT * FROM positions ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    $positions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Positions</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .icon-actions i {
            font-size: 1.2em;
            margin-right: 10px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .icon-actions {
            color: #007bff;
        }

        .fa-trash-alt {
            color: #dc3545;
        }

        .form-message {
            margin-top: 10px;
            color: green;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="all">
        <div class="all_box">
            <h1>Create Student Positions</h1>

            <?php if ($message): ?>
                <p class="form-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="forms">
                    <label for="position_name">Position Name:</label>
                    <input type="text" placeholder="Enter position name" id="position_name" name="position_name" required>
                </div>
                <div class="forms">
                    <button type="submit">Add Position</button>
                </div>
            </form>

            <div class="forms">
                <h2>Existing Positions</h2>
            </div>
            <div class="forms">
                <input type="text" id="searchInput" onkeyup="filterPositions()" placeholder="Search position name...">
            </div>
            <table id="positionsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Position Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($positions) > 0): ?>
                        <?php foreach ($positions as $index => $position): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td>
                                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $position['id']): ?>
                                        <form method="POST" action="">
                                            <div class="forms">
                                                <input type="hidden" name="update_id" value="<?php echo $position['id']; ?>">
                                                <input type="text" name="new_position_name" value="<?php echo htmlspecialchars($position['position_name']); ?>" required>
                                            </div>
                                            <div class="forms">
                                                <button type="submit">Save</button>
                                            </div>
                                            <div class="forms">
                                                <a href="create_position.php">
                                                    <button type="button">Cancel</button>
                                                </a>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($position['position_name']); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="icon-actions">
                                    <?php if (!isset($_GET['edit']) || $_GET['edit'] != $position['id']): ?>
                                        <a href="?edit=<?php echo $position['id']; ?>" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $position['id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this position?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No positions added yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterPositions() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("positionsTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }
    </script>
</body>

</html>