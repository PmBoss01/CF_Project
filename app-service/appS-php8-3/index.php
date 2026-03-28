<?php
$start    = microtime(true);
$hostname = gethostname();
$port     = getenv('PORT') ?: '80';
$path     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/health') {
    header('Content-Type: application/json');
    echo json_encode(['status'=>'ok','runtime'=>'php','version'=>PHP_VERSION,'uptime'=>round(microtime(true)-$start,4)]);
    exit;
}
if ($path === '/info') {
    header('Content-Type: application/json');
    echo json_encode(['runtime'=>'php','version'=>PHP_VERSION,'os'=>PHP_OS,'arch'=>php_uname('m'),'hostname'=>$hostname,'sapi'=>PHP_SAPI]);
    exit;
}
if ($path === '/echo') {
    header('Content-Type: application/json');
    echo json_encode(['echo'=>$_GET['msg']??'(empty)','timestamp'=>date('c')]);
    exit;
}
?>
<!DOCTYPE html><html><head><title>CF PHP 8.3 Test</title>
<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px}
.b{display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px}
.i{background:#e0e7ff;color:#3730a3}.bl{background:#dbeafe;color:#1e40af}</style>
</head><body>
<h1>🐘 PHP 8.3 — Running</h1>
<p>
  <span class="b i">PHP <?= PHP_VERSION ?></span>
  <span class="b bl">SAPI: <?= PHP_SAPI ?></span>
</p>
<h3>Info</h3>
<ul>
  <li><b>PORT:</b> <?= $port ?></li>
  <li><b>Hostname:</b> <?= $hostname ?></li>
  <li><b>OS:</b> <?= PHP_OS ?> / <?= php_uname('m') ?></li>
  <li><b>APP_ENV:</b> <?= getenv('APP_ENV') ?: 'production' ?></li>
</ul>
<h3>Endpoints</h3>
<ul>
  <li><a href="/health">/health</a></li>
  <li><a href="/info">/info</a></li>
  <li><a href="/echo?msg=hello">/echo?msg=hello</a></li>
</ul>
</body></html>
