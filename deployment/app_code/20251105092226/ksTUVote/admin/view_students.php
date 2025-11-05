<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  echo "<script>alert('Please log in first'); window.location='login.php';</script>";
  exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Students</title>
  <?php include 'cdn.php'; ?>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/auth.css">
 
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div class="alls">
    <div class="all_box">
      <h2>Registered Students</h2>

      <table>
  <thead>
    <tr>
      <th>#</th>
      <th>Full Name</th>
      <th>Student ID</th>
      <th>Phone</th>
      <th>Has Voted?</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT id, full_name, student_id, phone, has_voted FROM students ORDER BY id DESC";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $count = 1;
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$count}</td>
                <td>" . htmlspecialchars($row['full_name']) . "</td>
                <td>" . htmlspecialchars($row['student_id']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td>" . ($row['has_voted'] ? 'Yes' : 'No') . "</td>
              </tr>";
        $count++;
      }
    } else {
      echo "<tr><td colspan='5'>No students registered yet.</td></tr>";
    }
    ?>
  </tbody>
</table>

    </div>
  </div>
</body>
</html>
