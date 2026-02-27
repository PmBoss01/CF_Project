<?php
session_start();
include('db_conn.php');
include('alert.php');

if (isset($_POST['eventupdatebtn'])) {
    $eid = $_POST['Updateid'];
    $ename = $_POST['ename'];
    $nperson = $_POST['nperson'];
    $fphone = $_POST['fphone'];
    $gender = $_POST['gender'];
    $time = $_POST['time'];
    $date = $_POST['date'];

    $imageData = null; // Initialize imageData variable

    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['tmp_name'];
        $imageData = file_get_contents($photo);
    }

    $stmt = null; // Prepare statement variable

    if ($imageData !== null) {
        $stmt = $conn->prepare("UPDATE registerevent SET Event_Name = ?, Person_Name= ?, Contact = ?, Photo = ?, Gender = ?, Event_Time = ?, Event_Date = ? WHERE Event_ID = ?");
        $stmt->bind_param("ssssssss", $ename, $nperson, $fphone, $imageData, $gender, $time, $date, $eid);
    } else {
        $stmt = $conn->prepare("UPDATE registerevent SET Event_Name = ?, Person_Name= ?, Contact = ?, Gender = ?, Event_Time = ?, Event_Date = ? WHERE Event_ID = ?");
        $stmt->bind_param("sssssss", $ename, $nperson, $fphone, $gender, $time, $date, $eid);
    }

    if ($stmt->execute()) {
        $_SESSION['status'] = "Event Details have been Updated Successfully.";
        $_SESSION['status_code'] = "success";

        header('Location: Eventsinfo.php');
        exit; // Stop further execution

    }else{
        $_SESSION['status'] = "Event Details Vot Updated";
        $_SESSION['status_code'] = "error";
        header('Location: Eventsinfo.php');
        exit; // Stop further execution

    }

    
}

?>