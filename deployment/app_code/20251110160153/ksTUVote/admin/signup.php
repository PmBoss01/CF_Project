<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for existing email or phone
    $check_query = "SELECT * FROM admins WHERE email='$email' OR phone='$phone'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email or Phone number already exists!');</script>";
    } else {
        $sql = "INSERT INTO admins (full_name, email, phone, password) 
                VALUES ('$full_name', '$email', '$phone', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Admin registered successfully'); window.location='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>

<body>

    <div class="all">
        <div class="all_box">
            <div class="title">
                <h2>NathVote - Admin Signup</h2>
            </div>
            <form method="POST" action="">
                <div class="forms">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="forms">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="forms">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="forms">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form">
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </div>
                <div class="forms">
                    <button type="submit">Sign Up</button>
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