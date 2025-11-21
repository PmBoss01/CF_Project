<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Please log in first'); window.location='login.php';</script>";
    exit();
}

$admin_name = $_SESSION['admin_name'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="alls">
        <div class="all_box">
            <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?> 👋</h1>
        </div>
    </div>

</body>

</html>