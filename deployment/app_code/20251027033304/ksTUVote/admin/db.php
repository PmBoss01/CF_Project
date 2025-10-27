<?php
$servername = "localhost"; // or your database host
$username = "root";        // your database username
$password = "";            // your database password
$dbname = "kstuvote"; // replace with your actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
