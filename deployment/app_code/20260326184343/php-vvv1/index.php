<?php
$route = $_SERVER['REQUEST_URI'] ?? '/';

if ($route === '/health') {
    header('Content-Type: application/json');
    echo json_encode([
        'status'    => 'healthy',
        'runtime'   => 'PHP ' . PHP_VERSION,
        'timestamp' => gmdate('c'),
    ]);
    exit;
}

if ($route === '/info') {
    header('Content-Type: application/json');
    echo json_encode([
        'app'     => 'php-test',
        'php'     => PHP_VERSION,
        'server'  => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><title>PHP 8.3 Test</title>
  <style>
    body{font-family:system-ui,sans-serif;background:#f0f4f8;display:flex;
         justify-content:center;align-items:center;min-height:100vh;margin:0}
    .card{background:#fff;border-radius:12px;padding:2.5rem 3rem;
          box-shadow:0 4px 20px rgba(0,0,0,.1);text-align:center;max-width:440px}
    h1{color:#8892be;margin-bottom:.5rem}
    .badge{display:inline-block;background:#8892be;color:#fff;
           padding:.3rem 1rem;border-radius:999px;font-size:.85rem;margin:1rem 0}
    a{color:#8892be;text-decoration:none;border:1px solid #8892be;
      padding:.3rem .8rem;border-radius:6px;font-size:.88rem;margin:.25rem}
  </style>
</head>
<body>
  <div class="card">
    <h1>&#x2705; Deployment Successful</h1>
    <p>PHP app live on Azure</p>
    <div class="badge">PHP <?= PHP_VERSION ?> &bull; Apache</div>
    <br/><br/>
    <a href="/health">Health</a>
    <a href="/info">Info</a>
  </div>
</body>
</html>
