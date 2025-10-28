<?php
session_start();
include('db_conn.php');
include('scripts.php');

// Registration of Candidate
if (isset($_POST['registerpollingagentbtn'])) {
    $studentID = $_SESSION['Student_ID'];
    $studentName = $_SESSION['Student_Name'];
    $photo = $_FILES['photo']['tmp_name'];
    $cname = $_POST['cname'];
    $pollingid = $_POST['pollingid'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $contact = $_SESSION['Contact'];
    $department = $_SESSION['Department'];
    $Audit = "Not Audited";
    $Avail = "Offline";
    

    $imageData = file_get_contents($photo);

    if ($pass !== $cpass) {
        $_SESSION['status'] = "Password does not match";
        $_SESSION['status_code'] = "info";
        header('Location: polling_SignUp.php');
    } else {
        try {
            // Check if $cname exists in the polling_agent table
            $checkStmt = $conn->prepare("SELECT * FROM polling_agent WHERE Candidate_Name = ?");
            $checkStmt->bind_param("s", $cname);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // $cname already exists, handle accordingly
                $_SESSION['status'] = "Candidate Already Assigned";
                $_SESSION['status_code'] = "error";
                header('Location: polling_SignUp.php');
            } else {
                // $cname is unique, proceed with insertion
                $insertStmt = $conn->prepare("INSERT INTO polling_agent (Student_ID, Student_Name, Photo, Candidate_Name, Agent_ID, Agent_Password, Contact, Department, Agent_Audit, Agent_Availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insertStmt->bind_param("ssssssssss", $studentID, $studentName, $imageData, $cname, $pollingid, $pass, $contact, $department, $Audit, $Avail);
                $insertStmt->execute();

                $_SESSION['status'] = "Polling Agent Registered Successfully";
                $_SESSION['status_code'] = "success";
                header('Location: PollingAgent_ID.php');
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION['status'] = "Polling Agent Registration Failed";
            $_SESSION['status_code'] = "error";
            header('Location: polling_SignUp.php');
        }
    }
}

// Audit Result
if (isset($_POST['yes'])) {
    $Astatus = "Audited";
    $agentid = $_SESSION['Agent_ID'];
    $agentpass = $_SESSION['Agent_Password'];

    $stmt = $conn->prepare("UPDATE polling_agent SET Agent_Audit = ? WHERE Agent_ID = ? AND Agent_Password = ?");
    $stmt->bind_param("sss", $Astatus, $agentid, $agentpass);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Audited Successfully";
        $_SESSION['status_code'] = "success";
        header('Location: polling_agent Fold/PollingAuditResults.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Audit Not Successful";
        $_SESSION['status_code'] = "error";
        header('Location: polling_agent Fold/PollingAuditResults.php');
        exit; // Stop further execution
    }
}

if (isset($_POST['no'])) {
    $Astatus = "Not Audited";
    $agentid = $_SESSION['Agent_ID'];
    $agentpass = $_SESSION['Agent_Password'];

    $stmt = $conn->prepare("UPDATE polling_agent SET Agent_Audit = ? WHERE Agent_ID = ? AND Agent_Password = ?");
    $stmt->bind_param("sss", $Astatus, $agentid, $agentpass);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Results Audited Removed";
        $_SESSION['status_code'] = "success";
        header('Location: polling_agent Fold/PollingAuditResults.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Results Audit Not Removed";
        $_SESSION['status_code'] = "error";
        header('Location: polling_agent Fold/PollingAuditResults.php');
        exit; // Stop further execution
    }
}




?>