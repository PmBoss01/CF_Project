<?php

$sname = 'localhost';
$uname = "root";
$password = "";

$db_name = "eplan";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$dbconfig = mysqli_select_db($conn, $db_name);

if (!$conn){
    echo "Connection failed";
}
