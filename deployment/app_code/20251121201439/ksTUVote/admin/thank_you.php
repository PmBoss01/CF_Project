<?php
session_start();

// Optionally, you can clear the voting session data here if you stored any
// unset($_SESSION['votes']); // example if you stored votes in session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            text-align: center;
            background: #f4f4f9;
            color: #333;
        }
        .thank-you-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: inline-block;
            max-width: 400px;
        }
        h1 {
            color: #4caf50;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        a.button {
            text-decoration: none;
            background: #4caf50;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        a.button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Your vote has been successfully submitted.</p>
    <a href="student_dashboard.php" class="button">Go to Dashboard</a>
    <!-- Or change href to your homepage or voting page as needed -->
</div>

</body>
</html>
