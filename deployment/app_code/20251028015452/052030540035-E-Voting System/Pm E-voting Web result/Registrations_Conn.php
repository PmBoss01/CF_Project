<?php
session_start();
include('db_conn.php');
include('scripts.php');

// Registering Voters Individually

if (isset($_POST['registervoterbtn'])) {
    $sid = $_POST['sid'];
    $sname = $_POST['sname'];
    $spno = $_POST['spno'];
    $department = $_POST['department'];
    $string = "abcdefghijklmnopqrstuvwxyz0123456789";
    $code = substr(str_shuffle($string),0,6);
    $action = "Not Voted";
    $currentTimestamp = date('Y-m-d H:i:s');
    $otp = "0";
    $valid ="Not Validated";
    $sms = "Not Sent";
            

    try {
        $stmt = $conn->prepare("INSERT INTO votersdetails (Student_ID, Student_Name, Contact, Department, Serial_Code, Actions, Validations, SMS_Status, Registration_Time, Otp_Code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $sid, $sname, $spno, $department, $code, $action, $valid, $sms, $currentTimestamp, $otp);
        $stmt->execute();

        $_SESSION['status'] = "Voter Registered successfully";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Voter Registered";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        $stmt->execute();

        header('Location: voter_Registration.php');
        exit; // Stop further execution
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            $_SESSION['status'] = "Voter have been Registered";
            $_SESSION['status_code'] = "error";
        } else {
            $_SESSION['status'] = "Error inserting data: " . $e->getMessage();
            $_SESSION['status_code'] = "error";
        }
        header('Location: voter_Registration.php');
        exit; // Stop further execution
    }
}

// Edit / Update Voter Info
if (isset($_POST['updatestudentinfo'])) {
    $sid = $_POST['editsid'];
    $sname = $_POST['sname'];
    $pno = $_POST['pno'];
    $Department = $_POST['Department'];
    

    $stmt = $conn->prepare("UPDATE votersdetails SET Student_Name = ?, Contact = ?, Department = ? WHERE Student_ID  = ?");
    $stmt->bind_param("ssss",$sname, $pno, $Department, $sid);

    if ($stmt->execute()) {

        $stmt = $conn->prepare("UPDATE candidate_details SET Student_Name = ?, Contact = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("ssss",$sname, $pno, $Department, $sid);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE candidate_result SET Student_Name = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("sss",$sname, $Department, $sid);
        $stmt->execute();

        $_SESSION['status'] = "Voter Info Updated Successfully";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $sid ." Voter Info Edited";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        header('Location: managevoters.php');
        exit; // Stop further execution

        
    } else {
        $_SESSION['status'] = "Voter Info Not Updated";
        $_SESSION['status_code'] = "error";
        header('Location: managevoters.php');
        exit; // Stop further execution
    }
}


// Delete Voter Info
if (isset($_POST['studentdeletebtn'])) {
    $sid = $_POST['deletesid'];

    $query = "DELETE FROM votersdetails WHERE Student_ID = '$sid'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['status'] = "Voter Details Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $sid ." Voter Info Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        header('Location: managevoters.php');
        exist();
    }else{
        $_SESSION['status'] = "Student Details Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: managevoters.php');
        exist();
    }
}


// Importation of CSV File

    // Assuming you have a database connection established as $conn

if (isset($_POST["importbtn"])) {
    $fileName = $_FILES["uploadcsvfile"]["tmp_name"];

    if ($_FILES["uploadcsvfile"]["size"] > 0) {
        $file = fopen($fileName, "r");
        $string = "abcdefghijklmnopqrstuvwxyz0123456789";

        $removeFirstRow = isset($_POST['radio']) && $_POST['radio'] == 'remove';  // Check if radio button 1 is selected

        // Truncate the table before inserting new data
        $truncateTableQuery = "TRUNCATE TABLE votersdetails";
        mysqli_query($conn, $truncateTableQuery);

        $isFirstRow = true;  // Flag to skip the first row
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($isFirstRow) {
                if ($removeFirstRow) {
                    $isFirstRow = false;
                    continue;  // Skip the first row
                }
                $isFirstRow = false;
            }

            $studentID = str_pad(mysqli_real_escape_string($conn, $column[0]), 12, '0', STR_PAD_LEFT);
            $studentName = mysqli_real_escape_string($conn, $column[1]);

            // Assuming Contact should be 10 characters long with '0' padding
            $contact = str_pad(mysqli_real_escape_string($conn, $column[2]), 10, '0', STR_PAD_LEFT);

            $department = mysqli_real_escape_string($conn, $column[3]);
            $code = substr(str_shuffle($string), 0, 6);  // Generate 6-character code
            $action = "Not Voted";
            $valid ="Not Validated";
            $sms = "Not Sent";


            $sqlInsert = "INSERT INTO votersdetails (Student_ID, Student_Name, Contact, Department, Serial_Code, Actions, Validations, SMS_Status) 
                          VALUES ('$studentID', '$studentName', '$contact', '$department', '$code', '$action', '$valid', '$sms')";

            $result = mysqli_query($conn, $sqlInsert);

            if ($result) {
                

                $_SESSION['status'] = "CSV Data Imported Successfully";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "CSV Data Not Imported";
                $_SESSION['status_code'] = "error";
            }
        }
        
        fclose($file);  // Close the file after processing

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Voters CSV List Imported";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
        echo '';
        } else {
        echo '';
        }
        
        header('Location: voter_Registration.php');
        exit();  // Terminate the script after redirect
    }
}

// Registration of Candidate
if (isset($_POST['registercanbtn'])) {
    $studentID = $_SESSION['Student_ID'];
    $studentName = $_SESSION['Student_Name'];
    $contact = $_SESSION['Contact'];
    $department = $_SESSION['Department'];
    $photo = $_FILES['photo']['tmp_name'];
    $position = $_POST['position'];
    
    $tvoters = "0";
    $tvote = "0";
    $votepercent = "0";
    $voteno = "0";
    $votenopercent = "0";

    $imageData = file_get_contents($photo);

    try {
        $stmt = $conn->prepare("INSERT INTO candidate_details (Student_ID, Student_Name, Student_Image, Position, Contact, Department) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $studentID, $studentName, $imageData, $position, $contact, $department);
        $stmt->execute();

        $stmtt = $conn->prepare("INSERT INTO candidate_result (Student_ID, Student_Name, Student_Image, Position, Department, Total_Voters, Total_Votes, Votes_Percentage, Voted_No, Voted_No_Percentage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtt->bind_param("ssssssssss", $studentID, $studentName, $imageData, $position, $department, $tvoters, $tvote, $votepercent, $voteno, $votenopercent);
        $stmtt->execute();

        $_SESSION['status'] = "Candidate Registration Successful";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "Candidate Registered";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        header('Location: can_Registration.php');
        exit; // Stop further execution

        

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            $_SESSION['status'] = "Candidate Already Registered";
            $_SESSION['status_code'] = "error";
            header('Location: can_Registration.php');
        } else {
            $_SESSION['status'] = "Candidate Registration Failed";
            $_SESSION['status_code'] = "error";
            header('Location: can_Registration.php');

        }
       
    }
}

// Send Single SMS
if (isset($_POST['sendsmsbtn'])) {
    // Retrieve and sanitize input values
    $StudentID = htmlspecialchars($_POST['StudentID']);
    $Contact = htmlspecialchars($_POST['Contact']);
    $SerialCode = htmlspecialchars($_POST['SerialCode']);

    // SMS Message        
    $url = 'https://devapi.fayasms.com/messages';
    $headers = array('fayasms-developer: 37151436.9JRjLAUCYuYBjarEtNURWabNdjnSb9tm');
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

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = "SMS Sent to " .$StudentID;
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }

        $valid = "Validated";
        $sms = "SMS Sent";
        $stmt = $conn->prepare("UPDATE votersdetails SET Validations = ?, SMS_Status = ? WHERE Student_ID  = ?");
        $stmt->bind_param("sss",$valid, $sms, $StudentID);
        $stmt->execute();

        $_SESSION['status'] = "SMS Sent Successfully";
        $_SESSION['status_code'] = "success";

    } catch (Exception $e) {
        $_SESSION['status'] = "SMS Not delivered. Check Connection!";
        $_SESSION['status_code'] = "error";
    }

    curl_close($curl);

    // Redirect back to the page after sending SMS
    header("Location: managevoters.php");
    exit();
}



?>