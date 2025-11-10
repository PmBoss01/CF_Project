<?php
$servername = "nathstack.tech"; // or your database host
$username = "u257031014_ballotboxx";        // your database username
$password = "OnGod@@123";            // your database password
$dbname = "u257031014_ballotboxx"; // replace with your actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
