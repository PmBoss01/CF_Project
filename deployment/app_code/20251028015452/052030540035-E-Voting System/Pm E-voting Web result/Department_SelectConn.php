<?php
session_start();
include "db_conn.php";
// Fetch positions from the database
$sql = "SELECT * FROM department";
$result = $conn->query($sql);

// Populate the dropdown with options
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Department_Name'] . "'>" . $row['Department_Name'] . "</option>";
    }
}

$conn->close();
?>
