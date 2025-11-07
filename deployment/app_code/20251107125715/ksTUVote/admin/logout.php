<?php
session_start();
session_unset(); // Clear session variables
session_destroy(); // Destroy the session

echo "<script>
    alert('You have been logged out successfully.');
    window.location = '../index.php';
</script>";
?>
