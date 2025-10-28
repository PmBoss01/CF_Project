<?php
session_start();
include('db_conn.php');
include('scripts.php');

if (isset($_POST['yesPublish'])) {
    $Estatus = "Published";


    $stmt = $conn->prepare("UPDATE election_details SET Election_Status	= ?");
    $stmt->bind_param("s", $Estatus);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Election Results Uploaded Successfully";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Election Results Uploaded";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: adminviewresult.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Election Results Not Uploaded";
        $_SESSION['status_code'] = "error";
        header('Location: adminviewresult.php');
        exit; // Stop further execution
    }
}

if (isset($_POST['removeresult'])) {
    $Estatus = "Not Published";


    $stmt = $conn->prepare("UPDATE election_details SET Election_Status	= ?");
    $stmt->bind_param("s", $Estatus);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Election Results have been removed";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Election Results Removed";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: adminviewresult.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Election Results Not Uploaded";
        $_SESSION['status_code'] = "error";
        header('Location: adminviewresult.php');
        exit; // Stop further execution
    }
}

?>