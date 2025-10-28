<?php
session_start();
include('db_conn.php');
include('scripts.php');

// Truncate Votersdetails Table

if (isset($_POST['truncatebtn'])) {
    // Table to truncate
    $tableName = "votersdetails";

    // SQL query to truncate the table
    $sql = "TRUNCATE TABLE $tableName";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "Voters List Deleted successfully ❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "All Voters List Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }


        header("Location: managevoters.php");
        exit();
    } else {
        $_SESSION['status'] = "Error Deleting Candidate List: " . $conn->error;
        $_SESSION['status_code'] = "error";
        header("Location: managevoters.php");
        exit();
    }

    // Close the database connection
    $conn->close();
}

// Truncate Candidate and result Table
if (isset($_POST['truncatecanbtn'])) {
    // Tables to truncate
    $table1 = "candidate_result";
    $table2 = "candidate_details"; // Add the name of the second table

    // SQL query to truncate the first table
    $sql1 = "TRUNCATE TABLE $table1";

    // SQL query to truncate the second table
    $sql2 = "TRUNCATE TABLE $table2";

    // Execute the first query
    if ($conn->query($sql1) === TRUE) {
        // Execute the second query
        if ($conn->query($sql2) === TRUE) {
            $_SESSION['status'] = "Candidate List Deleted successfully ❌🗑️";
            $_SESSION['status_code'] = "success";
            //Insert Activity Logs for Admin
            $adminid = $_SESSION['Admin_ID'];
            $activity_log = "All Candidate List Deleted";
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
            $currentDateTime = date('Y-m-d H:i:s');

            $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
            if ($stmt->execute()) {
            echo '';
            } else {
            echo '';
            }

            header("Location: managecandidate.php");
            exit();
        } else {
            $_SESSION['status'] = "Error Deleting Candidate List: " . $conn->error;
            $_SESSION['status_code'] = "error";
            header("Location: managecandidate.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Error Deleting Candidate List: " . $conn->error;
        $_SESSION['status_code'] = "error";
        header("Location: managecandidate.php");
        exit();
    }

    // Close the database connection
    $conn->close();
}

// Truncate Polling Agents Table

if (isset($_POST['truncatepollingbtn'])) {
    // Table to truncate
    $tableName = "polling_agent";

    // SQL query to truncate the table
    $sql = "TRUNCATE TABLE $tableName";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "Polling Agent List Deleted successfully ❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Polling Agents List Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }


        header("Location: managepollingAgents.php");
        exit();
    } else {
        $_SESSION['status'] = "Error Deleting Polling List: " . $conn->error;
        $_SESSION['status_code'] = "error";
        header("Location: managepollingAgents.php");
        exit();
    }

    // Close the database connection
    $conn->close();
}

?>