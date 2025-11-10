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
</head>

<body>
    <h2>Student Login</h2>
    <form method="POST">
        <input type="text" name="student_id" placeholder="Student ID" required><br>
        <input type="password" name="pin" placeholder="Voting PIN" required><br>
        <button type="submit">Login</button>
    </form>
    <p style="color:red"><?= $message ?></p>
</body>

</html>