<?php
session_start();
include('db_conn.php');
include('alert.php');

if (isset($_POST['smsbtn'])) {
    // Retrieve and sanitize input values
    $Contact = htmlspecialchars($_POST['Contact']);
    $pname = htmlspecialchars($_POST['pname']);

    // SMS Message        
    $url = 'https://devapi.fayasms.com/messages';
    $headers = array('fayasms-developer: 37151436.9JRjLAUCYuYBjarEtNURWabNdjnSb9tm');
    $message = 'Hello ' .$pname .', Your Event Details have been Uploaded Successfully. Website link and QR Code for Webpage have been sent via WhatsApp Contact. For More Info Call +233 555710390. Thank You 🙏';

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

        $_SESSION['status'] = "SMS Sent Successfully";
        $_SESSION['status_code'] = "success";

    } catch (Exception $e) {
        $_SESSION['status'] = "SMS Not Delivered. Check Connection!";
        $_SESSION['status_code'] = "error";
    }

    curl_close($curl);

    // Redirect back to the page after sending SMS
    header("Location: uploadList.php");
    exit();
}

?>