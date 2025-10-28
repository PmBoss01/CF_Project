<?php
session_start();
include('db_conn.php');
include('scripts.php');


// Delete Candidate details
if (isset($_POST['pollingdeletebtn'])) {
    $sid = $_POST['deletesid'];
    $aid = $_POST['agentid'];

    $query = "DELETE FROM polling_agent WHERE Student_ID = '$sid'";
    $query_run = mysqli_query($conn, $query);

    
    if ($query_run) {
        $_SESSION['status'] = "Polling Agent Info Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $aid ." Polling Agent Deleted";
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

    }else{
        $_SESSION['status'] = "Polling Agent Info Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: managepollingAgents.php');
    }
}

?>