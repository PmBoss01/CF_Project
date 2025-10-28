<?php
include "db_conn.php";
$sql = "UPDATE voters_verifications SET Notifications = Notifications + 1";
$query_run = mysqli_query($conn, $sql);

if ($query_run) {
  // Database update was successful
  http_response_code(200); // Send a successful HTTP response code
} else {
  // Database update failed
  http_response_code(500); // Send an error HTTP response code
}

?>




