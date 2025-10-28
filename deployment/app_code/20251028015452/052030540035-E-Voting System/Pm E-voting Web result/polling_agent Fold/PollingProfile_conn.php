<?php
session_start();
include('db_conn.php');
include('scripts.php');

// Update Admin Profile

if (isset($_POST['updateaspprofile'])) {
    $aid = $_POST['aaid'];
    $pass = $_POST['rpass'];
    $cpass = $_POST['ccpass'];

    if ($pass !== $cpass) {
        $_SESSION['status'] = "Password does not match";
        $_SESSION['status_code'] = "warning";
        header('Location: polling_profile.php');
        exit; // Stop further execution
    }

    $imageData = null; // Initialize imageData variable

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($photo);
    }

    $stmt = null; // Prepare statement variable

    if ($imageData !== null) {
        $stmt = $conn->prepare("UPDATE polling_agent SET Photo = ?, Agent_Password = ? WHERE Agent_ID = ?");
        $stmt->bind_param("sss", $imageData, $pass, $aid);
    } else {
        $stmt = $conn->prepare("UPDATE polling_agent SET Agent_Password = ? WHERE Agent_ID = ?");
        $stmt->bind_param("ss", $pass, $aid);
    }

    if ($stmt->execute()) {
        $_SESSION['status'] = "Polling Agent details have been updated. Log in again 😏.";
        $_SESSION['status_code'] = "success";


        header('Location: ../polling_agent.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Polling Agent data not updated";
        $_SESSION['status_code'] = "error";
        header('Location: polling_profile.php');
        exit; // Stop further execution
    }
}
?>
