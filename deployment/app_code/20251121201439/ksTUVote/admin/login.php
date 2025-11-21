<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']); // email or phone
    $password = $_POST['password'];

    // Check against both email and phone
    $sql = "SELECT * FROM admins WHERE email='$identifier' OR phone='$identifier'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['full_name'];
            echo "<script>alert('Login successful'); window.location='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No admin found with this email or phone number.');</script>";
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>

<body>

    <div class="all">
        <div class="all_box">
            <div class="title">
                <div class="logo"></div>
                <h2>Admin</h2>
            </div>
            <form method="POST" action="">
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endif; ?>

                <div class="forms">
                    <label>Email or Phone</label>
                    <input type="text" name="identifier" required>
                </div>

                <div class="forms">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form">
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </div>

                <div class="forms">
                    <button type="submit">Login</button>
                </div>
                <br>
                <div class="form forgot_password">
                    <p><a href="forgot_password.php">Forgot your password?</a></p>

                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            x.type = (x.type === "password") ? "text" : "password";
        }
    </script>

</body>

</html>