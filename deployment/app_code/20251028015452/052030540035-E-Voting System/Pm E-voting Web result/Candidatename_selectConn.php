<?php
include "db_conn.php";
// Establish a database connection (same as in process.php)

// Fetch positions from the database
$sql = "SELECT * FROM candidate_details";
$result = $conn->query($sql);

// Populate the dropdown with options
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['Student_Name'] . "" . " (" . "" . $row['Position'] . "" . " )" . "'>" . $row['Student_Name'] . "" . " (" . "" . $row['Position'] . "" . " )" . "</option>";
    }
}

$conn->close();
?>
