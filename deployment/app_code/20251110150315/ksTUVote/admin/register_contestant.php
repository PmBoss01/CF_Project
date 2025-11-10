<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Please log in first'); window.location='login.php';</script>";
    exit();
}

include 'db.php';

$message = "";

// Fetch positions for the dropdown
$positions = [];
$result = $conn->query("SELECT * FROM positions ORDER BY position_name ASC");
while ($row = $result->fetch_assoc()) {
    $positions[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $position_id = intval($_POST['position_id']);
    $image_path = '';

    if (!empty($name) && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        // Check if contestant with same name and position already exists
        $check_stmt = $conn->prepare("SELECT id FROM contestants WHERE name = ? AND position_id = ?");
        $check_stmt->bind_param("si", $name, $position_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "This contestant has already been registered for this position.";
        } else {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['profile_image']['name']);
            $uploadDir = 'uploads/contestants/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destPath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $image_path = $destPath;

                // Insert into database
                $stmt = $conn->prepare("INSERT INTO contestants (name, profile_image, position_id) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $name, $image_path, $position_id);

                if ($stmt->execute()) {
                    $message = "Contestant registered successfully!";
                } else {
                    $message = "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Failed to upload image.";
            }
        }
        $check_stmt->close();
    } else {
        $message = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Contestant - ksTUVote</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
    <style>
        .form-message {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="all">
        <div class="all_box">
            <h1>Register Contestant</h1>
            <?php if ($message): ?>
                <p class="form-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="forms">
                    <label>Full Name:</label>
                    <input type="text" name="name" required placeholder="Enter full name">
                </div>
                <div class="forms">
                    <label>Profile Image:</label>
                    <input type="file" name="profile_image" accept="image/*" required>
                </div>
                <div class="forms">
                    <label>Select Position:</label>
                    <select name="position_id" required>
                        <option value="">-- Select Position --</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?php echo $position['id']; ?>"><?php echo htmlspecialchars($position['position_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="forms">
                    <button type="submit">Register Contestant</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>