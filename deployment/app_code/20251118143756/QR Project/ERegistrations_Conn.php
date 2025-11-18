<?php
session_start();
include('db_conn.php');
include('alert.php');

if (isset($_POST['register'])) {
    $ename = $_POST['ename'];
    $nperson = $_POST['nperson'];
    $fphone = $_POST['fphone'];
    $photo = $_FILES['photo']['tmp_name'];
    $gender = $_POST['gender'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $a = rand(10000000, 99999999);
    $eid = "E-" . $a;
    $ustat = "Not Yet";

    $imageData = file_get_contents($photo);

    // Check if the event with the same name, date, and time already exists
    $checkStmt = $conn->prepare("SELECT * FROM registerevent WHERE Event_Name = ?");
    $checkStmt->bind_param("s", $ename);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Event already exists
        $_SESSION['status'] = "Event with the same details already exists";
        $_SESSION['status_code'] = "error";
        header('Location: Event_Registration.php');
        exit;
    }

    // If not, proceed with the insertion
    try {
        $stmt = $conn->prepare("INSERT INTO registerevent (Event_ID, Event_Name, Person_Name, Contact, Photo, Gender, Upload_Status, Event_Time, Event_Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $eid, $ename, $nperson, $fphone, $imageData, $gender, $ustat, $time, $date);
        $stmt->execute();

        $_SESSION['status'] = "Registration Successfully";
        $_SESSION['status_code'] = "success";
        header('Location: Event_Registration.php');
        exit; // Stop further execution
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            $_SESSION['status'] = "Event Is Already Registered";
            $_SESSION['status_code'] = "error";
        } else {
            $_SESSION['status'] = "Error inserting data: " . $e->getMessage();
            $_SESSION['status_code'] = "error";
            echo 'Error inserting data: ' . $e->getMessage();
        }
        header('Location: Event_Registration.php');
        exit; // Stop further execution
    }
}
?>
