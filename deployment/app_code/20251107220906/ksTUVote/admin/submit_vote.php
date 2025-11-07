<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$votes = $_POST['vote'] ?? [];

if (empty($votes)) {
    echo "<script>alert('No votes submitted. Please vote before submitting.'); window.history.back();</script>";
    exit();
}

// Insert votes
foreach ($votes as $position_id => $contestant_id) {
    $check = $conn->prepare("SELECT id FROM votes WHERE student_id = ? AND position_id = ?");
    $check->bind_param("si", $student_id, $position_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $insert = $conn->prepare("INSERT INTO votes (student_id, position_id, contestant_id) VALUES (?, ?, ?)");
        $insert->bind_param("sii", $student_id, $position_id, $contestant_id);
        $insert->execute();
        $insert->close();
    }

    $check->close();
}

// ✅ Update has_voted
$update = $conn->prepare("UPDATE students SET has_voted = 1 WHERE id = ?");
$update->bind_param("s", $student_id);
$update->execute();
$update->close();

echo "<script>alert('Your votes have been submitted successfully.'); window.location='thank_you.php';</script>";
exit();
?>
