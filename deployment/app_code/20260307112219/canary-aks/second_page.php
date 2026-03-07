<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #eaf4fb;
        }
        h1 {
            color: #333;
        }
        .btn {
            padding: 12px 24px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<?php
    $page_title = "Second Page";
    $message = "You've successfully navigated to the second page!";
    $current_time = date("Y-m-d H:i:s");
?>

    <h1><?php echo $page_title; ?></h1>
    <p><?php echo $message; ?></p>
    <p>Server time: <strong><?php echo $current_time; ?></strong></p>

    <!-- Button to go back to the main page -->
    <a href="index.php" class="btn">Go Back</a>

</body>
</html>
