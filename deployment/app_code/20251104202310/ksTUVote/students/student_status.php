<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student info
$stmt = $conn->prepare("SELECT full_name, has_voted FROM students WHERE id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Student not found.";
    exit();
}

$full_name = htmlspecialchars($student['full_name']);
$has_voted = $student['has_voted'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Students Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background-color: #f4f4f4; text-align: center; }
        .container { background: white; padding: 30px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
        .btn { padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 6px; }
        .btn:hover { background-color: #0056b3; }
        .message { font-size: 18px; color: green; margin-top: 20px; }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container">
    <h2>Welcome, <?= $full_name ?></h2>

    <?php if ($has_voted == 0): ?>
        <p>You have not voted yet.</p>
        <a href="vote.php" class="btn">Click to Vote</a>
    <?php else: ?>
        <p class="message">✅ You have already voted. Thank you!</p>
    <?php endif; ?>
    <a href="view_results.php">
        View Results
    </a>
</div>

</body>
</html>
