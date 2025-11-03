<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $pin = trim($_POST['pin']);

    $stmt = $conn->prepare("SELECT id, pin, has_voted FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pin, $row['pin'])) {
            if ($row['has_voted']) {
                $message = "You have already voted.";
            } else {
                $_SESSION['student_id'] = $row['id'];
                header("Location: vote.php");
                exit();
            }
        } else {
            $message = "Incorrect PIN.";
        }
    } else {
        $message = "Invalid Student ID.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>

<body>

    <div class="all">
        <div class="all_box">


            <h2>Student Login</h2>
            <div class="forms">
                <p style="color:red"><?= $message ?></p>
            </div>
            <form method="POST">
                <div class="forms">
                    <label>Student ID:</label>
                    <input type="text" name="student_id" placeholder="Student ID" required>
                </div>
                <div class="forms">
                          <label>PIN:</label>
                <input type="password" name="pin" placeholder="Voting PIN" required>
                </div>
         <div class="forms">
                   <button type="submit">Login</button>
         </div>

         <!-- <div class="forms">
            <p>
                <a href="view_results.php">View Voting Results</a>
            </p>
         </div> -->
            </form>

        </div>
    </div>
</body>

</html>