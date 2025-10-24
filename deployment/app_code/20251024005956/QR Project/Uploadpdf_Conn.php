<?php
session_start();
include('db_conn.php');
include('alert.php');

// Upload PDF FIle

if (isset($_POST['uploadpdfbtn'])) {
    $eventID = $_SESSION['Event_ID'];
    $pdffile = $_FILES['pdfdocument']['tmp_name'];
    $upl = "Uploaded";

    $fileData = file_get_contents($pdffile);
    
    try {
        $stmt = $conn->prepare("UPDATE registerevent SET Pdf_file = ?, Upload_Status = ? WHERE Event_ID = ?");
        $stmt->bind_param("sss",$fileData, $upl, $eventID);
        $stmt->execute();


        $_SESSION['status'] = "Upload Successful";
        $_SESSION['status_code'] = "success";

        

        header('Location: uploadList.php');
        exit; // Stop further execution



    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            $_SESSION['status'] = "File Already Upload";
            $_SESSION['status_code'] = "error";
            header('Location: uploadList.php?msg=File Already Upload');
        } else {
            $_SESSION['status'] = "Upload Failed";
            $_SESSION['status_code'] = "error";
            header('Location: uploadList.php?msg=Upload Failed');

        }
       
    }
}
?>