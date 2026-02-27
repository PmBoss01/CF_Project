
<?php
// EventPDF.php

include('db_conn.php');

if (isset($_GET['event_name'])) {
    $eventName = $_GET['event_name'];

    $query = "SELECT Pdf_file FROM registerevent WHERE Event_Name = '$eventName'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pdfData = $row['Pdf_file'];

        // Output PDF data
        header('Content-type: application/pdf');
        echo $pdfData;
        exit();
    }
}

// If Event ID is not provided or PDF data is not found, display a default message
echo "PDF not found.";
?>
