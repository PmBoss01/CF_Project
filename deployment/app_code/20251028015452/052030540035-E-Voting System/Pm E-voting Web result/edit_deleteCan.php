<?php
session_start();
include('db_conn.php');
include('scripts.php');

//Edit Candidate details

if (isset($_POST['updatecaninfo'])) {
    $cid = $_POST['editcid'];
    $sname = $_POST['sname'];
    $pno = $_POST['pno'];
    $position = $_POST['position'];
    $Department = $_POST['Department'];

    $imageData = null; // Initialize imageData variable

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($photo);
    }

    $stmt = null; // Prepare statement variable

    if ($imageData !== null) {
        $stmt = $conn->prepare("UPDATE candidate_details SET Student_Name = ?, Student_Image = ?, Position = ?, Contact = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("ssssss", $sname, $imageData , $position, $pno, $Department, $cid);
    } else {
        $stmt = $conn->prepare("UPDATE candidate_details SET Student_Name = ?, Position = ?, Contact = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("sssss", $sname, $position, $pno, $Department, $cid);
    }

    if ($stmt->execute()) {

        $stmt = $conn->prepare("UPDATE candidate_result SET Student_Name = ?, Student_Image = ?, Position = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("sssss", $sname, $imageData , $position, $Department, $cid);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE votersdetails SET Student_Name = ?, Contact = ?, Department = ? WHERE Student_ID  = ?");
        $stmt->bind_param("ssss",$sname, $pno, $Department, $cid);
        $stmt->execute();

        $_SESSION['status'] = "Candidate details have been updated Successfully.";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $cid ." Candidate Info Updated";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }
        
        header('Location: managecandidate.php');
        exit; // Stop further execution
    } else {
        $_SESSION['status'] = "Candidate Details not updated";
        $_SESSION['status_code'] = "error";
        header('Location: UpdateCanInfo.php');
        exit; // Stop further execution
    }
}



// Delete Candidate details
if (isset($_POST['candeletebtn'])) {
    $cid = $_POST['deletecid'];

    $query = "DELETE FROM candidate_details WHERE Student_ID = '$cid'";
    $query_run = mysqli_query($conn, $query);

    
    if ($query_run) {

        $stmt = $conn->prepare("DELETE FROM candidate_result WHERE Student_ID = ?");
        $stmt->bind_param("s", $cid);
        $stmt->execute();

        $_SESSION['status'] = "Candidate Info Deleted Successfully❌🗑️";
        $_SESSION['status_code'] = "success";

        //Insert Activity Logs for Admin
        $adminid = $_SESSION['Admin_ID'];
        $activity_log = $cid ." Candidate cInfo Deleted";
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $currentDateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO admin_logs (Admin_ID, Activity_Logs, IP_Address, Created_At) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $adminid, $activity_log, $ipAddress, $currentDateTime);
        if ($stmt->execute()) {
          echo '';
        } else {
          echo '';
        }


        header('Location: managecandidate.php');

    }else{
        $_SESSION['status'] = "Candidate Info Not Deleted";
        $_SESSION['status_code'] = "error";
        header('Location: managecandidate.php');
    }
}
?>