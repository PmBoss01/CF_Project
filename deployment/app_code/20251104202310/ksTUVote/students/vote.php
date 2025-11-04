<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch positions
$positionsQuery = $conn->query("SELECT * FROM positions ORDER BY id ASC");
$positions = $positionsQuery ? $positionsQuery->fetch_all(MYSQLI_ASSOC) : [];

// Fetch contestants grouped by position
$contestants = [];
foreach ($positions as $position) {
    $stmt = $conn->prepare("SELECT * FROM contestants WHERE position_id = ?");
    $stmt->bind_param("i", $position['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $contestants[$position['id']] = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vote for Contestants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
    <style>
        .card_grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding-block: 20px;
        }

        .card {
            border: 2px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 300px;
            object-fit: contain;
        }

        .hidden {
            display: none;
        }

        .forms button {
            height: 45px;
            width: 100%;
            border: none;
            background-color: #0C46A5;
            color: #fff;

        }

        .vote-button {
            display: inline-block;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 45px;
            width: 100%;

            background-color: #0C46A5;
            /* Default red background */
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .vote-button.voted {
            background-color: green;
            /* Green when voted */
            color: white;
        }

        .vote-button i {
            margin-right: 6px;
        }

        @media only screen and (max-width: 1110px) {
                .card_grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding-block: 20px;
        } 


        }

   @media only screen and (max-width: 710px) {
                .card_grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            padding-block: 20px;
        } 
        }
</style>
</head>

<body>

    <div class="alls">
        <div class="all_box">
            <h2>Vote for Contestants</h2>
            <form id="voteForm" method="POST" action="submit_vote.php">
                <?php foreach ($positions as $index => $position): ?>
                    <div class="position-block <?= $index > 0 ? 'hidden' : '' ?>" id="position-block-<?= $index ?>">
                        <h3><?= htmlspecialchars($position['position_name']) ?></h3>
                        <div class="card_grid">
                            <?php if (!empty($contestants[$position['id']])): ?>
                                <?php foreach ($contestants[$position['id']] as $cont): ?>
                                    <?php
                                    $image = basename(trim($cont['profile_image']));
                                    $relativePath = "../admin/uploads/contestants/" . $image;
                                    $absolutePath = realpath(__DIR__ . "/../admin/uploads/contestants/" . $image);
                                    $imageToShow = (!empty($image) && $absolutePath && file_exists($absolutePath)) ? $relativePath : "../assets/default-profile.png";
                                    ?>
                                    <label class="card">
                                        <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile Image">
                                        <div class="forms"><strong><?= htmlspecialchars($cont['name']) ?></strong></div>
                                        <input type="radio" name="vote[<?= intval($position['id']) ?>]" id="vote-<?= $cont['id'] ?>" value="<?= intval($cont['id']) ?>" required hidden>
                                        <div class="forms">
                                            <button type="button" class="vote-button">
                                                <label for="vote-<?= $cont['id'] ?>" class="vote-button" data-button-id="<?= $cont['id'] ?>">VOTE</label>
                                            </button>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No contestants available for this position.</p>
                            <?php endif; ?>
                        </div>

                        <div class="nav-buttons">
                            <?php if ($index > 0): ?>
                                <div class="forms">
                                    <button type="button" onclick="prevPosition(<?= $index ?>)">Back</button>
                                </div>
                            <?php endif; ?>
                            <?php if ($index + 1 < count($positions)): ?>
                                <div class="forms">
                                    <button type="button" onclick="nextPosition(<?= $index ?>)">Next</button>
                                </div>
                            <?php else: ?>
                                <div class="forms">
                                    <button type="button" onclick="showVoteSummary()">Review My Votes</button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="margin-top:15px; font-style: italic; color: #555;">
                            <?php if ($index + 1 < count($positions)): ?>
                                Next up: <strong><?= htmlspecialchars($positions[$index + 1]['position_name']) ?></strong>
                            <?php else: ?>
                                This is the <strong>last</strong> position.
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div id="voteSummary" class="hidden" style="margin-top: 20px;">
                    <h3>Summary of Your Votes</h3>
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px; text-align: left;">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Contestant</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTableBody"></tbody>
                    </table>
                    <div class="forms" style="margin-top: 15px;">
                        <button type="submit">Confirm and Submit Votes</button>
                    </div>
                    <div class="forms" style="margin-top: 10px;">
                        <button type="button" onclick="goBackToLastPosition()">Back</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function nextPosition(currentIndex) {
            const currentBlock = document.getElementById('position-block-' + currentIndex);
            const radios = currentBlock.querySelectorAll('input[type="radio"]');
            const selected = Array.from(radios).some(radio => radio.checked);

            if (!selected) {
                alert("Please select a contestant before continuing.");
                return;
            }

            currentBlock.classList.add('hidden');
            const nextBlock = document.getElementById('position-block-' + (currentIndex + 1));
            if (nextBlock) nextBlock.classList.remove('hidden');
        }

        function prevPosition(currentIndex) {
            const currentBlock = document.getElementById('position-block-' + currentIndex);
            currentBlock.classList.add('hidden');
            const prevBlock = document.getElementById('position-block-' + (currentIndex - 1));
            if (prevBlock) prevBlock.classList.remove('hidden');
        }

        function showVoteSummary() {
            const voteSummary = document.getElementById('voteSummary');
            const summaryTableBody = document.getElementById('summaryTableBody');
            summaryTableBody.innerHTML = '';

            <?php foreach ($positions as $position): ?>
                const selectedRadio_<?= $position['id'] ?> = document.querySelector('input[name="vote[<?= $position['id'] ?>]"]:checked');
                if (selectedRadio_<?= $position['id'] ?>) {
                    const contestantCard = selectedRadio_<?= $position['id'] ?>.closest('.card');
                    const contestantName = contestantCard.querySelector('strong').innerText;
                    const positionName = "<?= addslashes($position['position_name']) ?>";

                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${positionName}</td><td>${contestantName}</td>`;
                    summaryTableBody.appendChild(row);
                }
            <?php endforeach; ?>

            document.querySelectorAll('.position-block').forEach(el => el.classList.add('hidden'));
            voteSummary.classList.remove('hidden');
        }

        function goBackToLastPosition() {
            document.getElementById('voteSummary').classList.add('hidden');
            const lastIndex = <?= count($positions) - 1 ?>;
            document.getElementById('position-block-' + lastIndex).classList.remove('hidden');
        }

        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const name = this.name;

                // Reset all labels in the same group
                document.querySelectorAll(`input[name="${name}"]`).forEach(input => {
                    const label = document.querySelector(`label.vote-button[for="${input.id}"]`);
                    if (label) {
                        label.textContent = 'VOTE';
                        label.classList.remove('voted');
                    }
                });

                // Mark selected as VOTED
                const selectedLabel = document.querySelector(`label.vote-button[for="${this.id}"]`);
                if (selectedLabel) {
                    selectedLabel.innerHTML = '<i class="fas fa-check-circle"></i> VOTED';
                    selectedLabel.classList.add('voted');
                }
            });
        });
    </script>
</body>

</html>