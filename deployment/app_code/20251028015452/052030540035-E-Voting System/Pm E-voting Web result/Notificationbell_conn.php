<?php
session_start();
include "db_conn.php";

$id = $_GET['id'];
$notify = "0";

$query = "UPDATE voters_verifications SET Notifications = $notify";
$query_run = mysqli_query($conn, $query);

if ($query_run) {

  //Insert Activity Logs for Admin
  $adminid = $_SESSION['Admin_ID'];
  $activity_log = "View Notifications";
  $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
  $currentDateTime = date('Y-m-d H:i:s');

  $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
  if ($stmt->execute()) {
    echo 'Data inserted successfully.';
  } else {
    echo 'Error inserting data: ' . $stmt->error;
  }


  ////////////////////////////////////
  header('Location: https://docs.google.com/spreadsheets/d/12o7xQuDQW26pv0qtGexmBjEu6HcJElrHuY5F2x9jMu4/edit#gid=0');
  exit();
}
?>