<?php
session_start();
include('db_conn.php');
include('scripts.php');


// Portfolio
if (isset($_POST['saveportfolio'])) {
    $Portfolio_Name = $_POST['Portfolio_Name'];
    $Gender = $_POST['gender'];

    try {
        // Check if Portfolio_Name already exists in the database
        $check_stmt = $conn->prepare("SELECT Portfolio_Name FROM portfolio WHERE Portfolio_Name = ?");
        $check_stmt->bind_param("s", $Portfolio_Name);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Portfolio_Name already exists
            $_SESSION['status'] = "Portfolio Already Registered";
            $_SESSION['status_code'] = "error";
            header('Location: portfolio.php');
            exit; // Stop further execution
        } else {
            // Portfolio_Name does not exist, so insert into the database
            $insert_stmt = $conn->prepare("INSERT INTO portfolio (Portfolio_Name, Gender) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $Portfolio_Name, $Gender);
            $insert_stmt->execute();

            $_SESSION['status'] = "Portfolio Registered Successful";
            $_SESSION['status_code'] = "success";

            //Insert Activity Logs for Admin
          $adminid = $_SESSION['Admin_ID'];
          $activity_log = "Portfolio Registered";
          $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
          $currentDateTime = date('Y-m-d H:i:s');

          $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
          if ($stmt->execute()) {
            echo '';
          } else {
            echo '';
          }
            header('Location: portfolio.php');
            exit; // Stop further execution
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['status'] = "Portfolio Not Registered";
        $_SESSION['status_code'] = "error";
        header('Location: portfolio.php');
    }
}

// Delete Portfolio Info
if (isset($_POST['positiondeletebtn'])) {
    $sn = $_POST['deleteposition'];
    $port = $_POST['portfolio'];

    $query = "DELETE FROM portfolio WHERE Sn = '$sn'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {

      $stmt = $conn->prepare("DELETE FROM candidate_details WHERE Position = ?");
      $stmt->bind_param("s", $port);
      $stmt->execute();

      $stmt = $conn->prepare("DELETE FROM candidate_result WHERE Position = ?");
      $stmt->bind_param("s", $port);
      $stmt->execute();

        $_SESSION['status'] = "Portfolio Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Portfolio Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        header('Location: portfolio.php'); 
        exist();
    }else{
        $_SESSION['status'] = "Portfolio Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: portfolio.php');
        exist();
    }
}

// Department
if (isset($_POST['savedepartment'])) {
    $departmentname = $_POST['departmentname'];
    $totalstudents = $_POST['totalstudents'];

    try {
        // Check if Portfolio_Name already exists in the database
        $check_stmt = $conn->prepare("SELECT Department_Name FROM department WHERE Department_Name = ?");
        $check_stmt->bind_param("s", $departmentname);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Portfolio_Name already exists
            $_SESSION['status'] = "Department Already Registered";
            $_SESSION['status_code'] = "error";
            header('Location: department.php');
            exit; // Stop further execution
        } else {
            // Portfolio_Name does not exist, so insert into the database
            $insert_stmt = $conn->prepare("INSERT INTO department (Department_Name, Total_Students) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $departmentname, $totalstudents);
            $insert_stmt->execute();

            $_SESSION['status'] = "Department Registered Successful";
            $_SESSION['status_code'] = "success";

            //Insert Activity Logs for Admin
          $adminid = $_SESSION['Admin_ID'];
          $activity_log = "Department Registered";
          $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
          $currentDateTime = date('Y-m-d H:i:s');

          $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
          if ($stmt->execute()) {
            echo '';
          } else {
            echo '';
          }
            header('Location: department.php');
            exit; // Stop further execution
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['status'] = "Department Not Registered";
        $_SESSION['status_code'] = "error";
        header('Location: department.php');
    }
}

// Delete Department Info
if (isset($_POST['departmentdeletebtn'])) {
    $sn = $_POST['deletedepartment'];

    $query = "DELETE FROM department WHERE Sn = '$sn'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {

        $_SESSION['status'] = "Department Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";
        header('Location: department.php'); 
        exist();
    }else{
        $_SESSION['status'] = "Department Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: department.php');
        exist();
    }
}


?>