<?php
// login.php — PHP 8.2 test

session_start();

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    // Demo credentials
    if ($user === 'admin' && $pass === 'password123') {
        $_SESSION['user'] = $user;
        $success = true;
    } else {
        $error = 'Invalid username or password.';
    }
}

$phpVersion = phpversion();
$time = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP 8.2 Login Test</title>
  <style>
    body { font-family: sans-serif; max-width: 400px; margin: 60px auto; padding: 0 1rem; }
    input { display: block; width: 100%; padding: 8px; margin: 8px 0 16px; box-sizing: border-box; }
    button { padding: 10px 24px; background: #185FA5; color: white; border: none; cursor: pointer; border-radius: 4px; }
    .error { color: #c00; } .success { color: #090; }
    footer { margin-top: 2rem; font-size: 12px; color: #888; }
  </style>
</head>
<body>
  <h2>Login — PHP <?= htmlspecialchars($phpVersion) ?></h2>

  <?php if ($success): ?>
    <p class="success">Logged in as <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>!</p>
  <?php else: ?>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST">
      <label>Username <input type="text" name="username" placeholder="admin"></label>
      <label>Password <input type="password" name="password" placeholder="password123"></label>
      <button type="submit">Log in</button>
    </form>
  <?php endif; ?>

  <footer>PHP <?= $phpVersion ?> · <?= $time ?></footer>
</body>
</html>