<?php
session_start();
include "db_conn.php";
if ($data = $_GET['data']){

    $offline = "Offline";
    $ECid = $_SESSION['Admin_ID'];
    $ECpass = $_SESSION['Admin_Password'];

    $stmt = $conn->prepare("UPDATE admindetails SET Ec_Availability = ? WHERE Admin_ID = ? AND Admin_Password = ?");
    $stmt->bind_param("sss", $offline, $ECid, $ECpass);
    $stmt->execute();

    //Insert Activity Logs for Admin
    $adminid = $_SESSION['Admin_ID'];
    $activity_log = "Admin LogOut";
    $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    $currentDateTime = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
    if ($stmt->execute()) {
        header("Location: AdminLogin.php");
        exit; // Stop further execution
    } else {
      echo '';
    }
    
    }

session_unset();
session_destroy();

