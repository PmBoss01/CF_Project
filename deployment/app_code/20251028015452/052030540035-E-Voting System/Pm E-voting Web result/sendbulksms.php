<?php
session_start();
include "db_conn.php";
include "scripts.php";

// Send Bulk SMS
$sql = "SELECT * FROM votersdetails";
$result = $conn->query($sql);

// SMS API details
$url = 'https://devapi.fayasms.com/messages';
$headers = array('fayasms-developer: 37151436.9JRjLAUCYuYBjarEtNURWabNdjnSb9tm');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $StudentID = $row['Student_ID'];
        $Contact = $row['Contact'];
        $SerialCode = $row['Serial_Code'];

        // SMS Message
        $message = 'Hello, Please be informed that the election is commencing, and your Credentials for Voting are Voter ID: ' . $StudentID . ' and Serial Code: ' . $SerialCode . '. Click on the link to Cast Your vote and View Candidate Results. https://votingsystem2580.000webhostapp.com/Homepage.php. Thank You 🙏';

        $data = array(
            'sender' => 'PmTecH',
            'message' => $message,
            'recipients' => array($Contact)
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        try {
            $response = curl_exec($curl);

            if ($response === false) {
                throw new Exception(curl_error($curl));
            }

            // Log successful SMS sends if needed
            // You can also track the status in your SMS service dashboard

        } catch (Exception $e) {
            // Log errors or handle them as needed
            // You can also add more specific error messages for different error scenarios

            $_SESSION['status'] = "SMS Not delivered. Check Connection!";
            $_SESSION['status_code'] = "error";
            header('Location: managevoters.php');
            exit();
        } finally {
            curl_close($curl);
        }
    }

    //Insert Activity Logs for Admin
    $adminid = $_SESSION['Admin_ID'];
    $activity_log = "Bulk SMS Sent";
    $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    $currentDateTime = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
    
    if ($stmt->execute()) {
        // Redirect after sending SMS and logging activity

        $valid = "Validated";
        $sms = "SMS Sent";
        $stmt = $conn->prepare("UPDATE votersdetails SET Validations = ?, SMS_Status = ? WHERE Student_ID  = ?");
        $stmt->bind_param("sss",$valid, $sms, $StudentID);
        $stmt->execute();

        $_SESSION['status'] = "Bulk SMS Sent Successfully";
        $_SESSION['status_code'] = "success";
        header('Location: managevoters.php');
        exit();
        
    } else {
        $_SESSION['status'] = "Error logging SMS activity";
        $_SESSION['status_code'] = "error";
        header('Location: managevoters.php');
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where there are no records to send SMS to
    $_SESSION['status'] = "No records found to send SMS";
    $_SESSION['status_code'] = "error";
    header("Location: managevoters.php");
    exit();
}
?>
