<?php
session_start();
include('db_conn.php');
// Export Voter List
    $query = $conn->query("SELECT * FROM votersdetails");

    if (!$query) {
        // Query execution failed, handle the error here
        die("Error executing the query: " . $conn->error);
    }

    if ($query->num_rows > 0) {

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Voters List Exported";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }

        $delimiter = ",";
        $filename = "voters-List_" . date('Y-m-d') . ".csv";

        // Create a file pointer
        $f = fopen('php://memory', 'w');

        //set column headers
        $field = array('STUDENT ID', 'STUDENT NAME', 'CONTACT', 'DEPARTMENT');
        fputcsv($f, $field, $delimiter);

        //Output for each row
        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['Student_ID'], $row['Student_Name'], $row['Contact'], $row['Department']);
            fputcsv($f, $lineData, $delimiter);
        }
        fseek($f, 0);

        // Set header to download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        //Output
        fpassthru($f);
        exit;

    } else {
        $_SESSION['status'] = "No data found for export.";
        $_SESSION['status_code'] = "error";
        //echo "No data found for export.";
    }


?>