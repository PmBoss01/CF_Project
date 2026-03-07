<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f4f8;
        }
        h1 {
            color: #333;
        }
        .btn {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
    $page_title = "Main Page";
    $message = "Welcome! Click the button below to open the second page.";
?>

    <h1><?php echo $page_title; ?></h1>
    <p><?php echo $message; ?></p>

    <!-- Button that links to the second PHP file -->
    <a href="second_page.php" class="btn">Open Second Page</a>

</body>
</html>
