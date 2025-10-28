<?php
session_start();
include('db_conn.php');
include('scripts.php');

//Update Polling Agent Message 
if (isset($_POST['generalmsgbtn'])) {
    $textmsg = $_POST['textmsg'];
    $msgno = "1";
    $currentDateTime = date("Y-m-d H:i:s");


    $stmt = $conn->prepare("UPDATE polling_agent SET Message_No = ?, Messages = ?, Message_Time = ?");
    $stmt->bind_param("sss",$msgno, $textmsg, $currentDateTime);

  
    

    if ($stmt->execute()) {
        $_SESSION['status'] = "Messages Sent to All Polling Agents";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $sid ." Polling Agent Messages";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        header('Location: managepollingAgents.php');
        exit; // Stop further execution

        
  
    }else {
        $_SESSION['status'] = "Message Not Sent";
        $_SESSION['status_code'] = "error";
        header('Location: managepollingAgents.php');
        exit; // Stop further execution
    }
}


?>