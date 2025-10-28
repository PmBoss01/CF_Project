<?php
session_start();
include('db_conn.php');
include('scripts.php');


if (isset($_POST['save'])) {
    $aid = $_POST['aid'];
    $photo = $_FILES['photo']['tmp_name'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $avail = "Offline";


    $imageData = file_get_contents($photo);

    if ($pass !== $cpass) {
        $_SESSION['status'] = "Password does not match";
        $_SESSION['status_code'] = "warning";
        header('Location: Add_adminDash.php');
        exit; // Stop further execution
    }

    try {
        $stmt = $conn->prepare("INSERT INTO admindetails (Admin_ID, Admin_Image, Admin_Password, Ec_Availability) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $aid, $imageData, $pass, $avail);
        $stmt->execute();

        $_SESSION['status'] = "EC details have been added successfully";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "New EC Added";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: Add_adminDash.php');
        exit; // Stop further execution
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            $_SESSION['status'] = "EC have been already added successfully";
            $_SESSION['status_code'] = "error";
        } else {
            $_SESSION['status'] = "Error inserting data: " . $e->getMessage();
            $_SESSION['status_code'] = "error";
        }
        header('Location: Add_adminDash.php');
        exit; // Stop further execution
    }
}


// Delete Admin details
if (isset($_POST['Admindelete'])) {
    $aid = $_POST['deleteadmin'];

    $query = "DELETE FROM admindetails WHERE Admin_ID = '$aid'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['status'] = "EC Info Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $aid." Info Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }

        header('Location: Add_adminDash.php');

    }else{
        $_SESSION['status'] = "EC Info Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: Add_adminDash.php');
    }
}

?>