<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  echo "<script>alert('Please log in first'); window.location='login.php';</script>";
  exit();
}

include 'db.php';

$message = "";

function generateStudentId()
{
  return rand(100000, 999999) . '-25';
}

function generatePin()
{
  return rand(100000, 999999);
}

function formatPhoneForSMS($phone)
{
  // Remove non-digits
  return preg_replace('/[^0-9]/', '', $phone);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name']);
  $phone = trim($_POST['phone']);

  if (!empty($full_name) && !empty($phone)) {
    // Check duplicate phone
    $check = $conn->prepare("SELECT id FROM students WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $message = "Phone number already exists!";
    } else {
      $student_id = generateStudentId();
      $pin_plain = generatePin();
      $pin_hash = password_hash($pin_plain, PASSWORD_DEFAULT);

      $stmt = $conn->prepare("INSERT INTO students (full_name, student_id, phone, pin) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $full_name, $student_id, $phone, $pin_hash);

      if ($stmt->execute()) {
        $message = "Student registered successfully!";
        $smsPhone = formatPhoneForSMS($phone);
        $smsText = urlencode("Hi $full_name, your Student ID is $student_id and your Voting PIN is $pin_plain. Do not share this with anyone.");
        $smsLink = "sms:$smsPhone?body=$smsText";
      } else {
        $message = "Error: " . $stmt->error;
      }
      $stmt->close();
    }
    $check->close();
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
  <title>Register Student</title>
  <?php include 'cdn.php'; ?>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/auth.css">

  <style>
    .success {
      color: green;
    }

    .error {
      color: red;
    }

    a.button {
      display: inline-block;
      background: #007bff;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <?php include 'sidebar.php'; ?>
  <div class="all">
    <div class="all_box">
      <h2>Register Student</h2>

      <?php if ($message): ?>
        <p class="<?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
          <?= htmlspecialchars($message) ?>
        </p>

        <?php if (isset($smsLink)): ?>
          <a href="<?= htmlspecialchars($smsLink) ?>" class="button">
            Send PIN via SMS
          </a>
        <?php endif; ?>
      <?php endif; ?>

      <form method="POST" autocomplete="off">
        <div class="forms">
          <label for="full_name">Full Name</label>
          <input type="text" id="full_name" name="full_name" required>
        </div>

        <div class="forms">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" required pattern="[0-9+ ]{8,15}" title="Enter a valid phone number">
        </div>

        <div class="forms">
          <button type="submit">Register Student</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
