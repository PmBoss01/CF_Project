<?php
session_start();
include('db_conn.php'); // Include your database connection script

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $Aid = $_SESSION['Agent_ID'];
    $ECname = $_SESSION['Admin_ID'];
    $currentTimestamp = date("H:i:s"); // Format: HH:MM:SS

    // Insert data into the database
    $sql = "INSERT INTO chats (Sender, Receiver, Messages, Time_Delivered) VALUES ('$ECname','$Aid','$message','$currentTimestamp')";

    if (mysqli_query($conn, $sql)) {
        // Create HTML for the newly added message
        $html = '<div><p class="custom-right mt-2">' . $message . '<span class="float-end mt-2 mx-2" style="font-size: 12px;">' . $currentTimestamp . '<i class="fa fa-check text-success"></i></span></p></div>';
        
        echo $html;
         // Return the HTML for the new message
    } else {
        echo 'Error inserting the message into the database.';
    }
}
?>
