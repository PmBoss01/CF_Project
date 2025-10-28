<?php
session_start();
include "db_conn.php";
include "scripts.php";

if ($data = $_GET['data']){

    //Insert Activity Logs for Admin
    $adminid = $_SESSION['Admin_ID'];
    $activity_log = "Admin Dashboard";
    $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    $currentDateTime = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
    if ($stmt->execute()) {
        header('Location: Admin Dashboard.php');
        exit; // Stop further execution
    } else {
      echo '';
    }
    
    }


?>