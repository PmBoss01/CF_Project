<?php
session_start();
include('db_conn.php');
include('alert.php');

// Delete Admin details
if (isset($_POST['eventdeletebtn'])) {
    $eid = $_POST['deleteid'];

    $query = "DELETE FROM registerevent WHERE Event_ID = '$eid'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['status'] = "Event Info Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";        

        header('Location: Eventsinfo.php');

    }else{
        $_SESSION['status'] = "Event Info Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: Eventsinfo.php');
    }
}
?>