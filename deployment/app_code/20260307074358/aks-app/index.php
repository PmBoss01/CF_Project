<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENV Variable Tester</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0d0f14;
            --surface: #151820;
            --border: #252a36;
            --accent: #00e5a0;
            --accent2: #7b61ff;
            --danger: #ff4f4f;
            --text: #e2e8f0;
            --muted: #64748b;
            --font-mono: 'JetBrains Mono', monospace;
            --font-display: 'Syne', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-display);
            min-height: 100vh;
            padding: 40px 20px;
            background-image:
                radial-gradient(ellipse at 10% 20%, rgba(0,229,160,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(123,97,255,0.06) 0%, transparent 50%);
        }

        .container {
            max-width: 780px;
            margin: 0 auto;
        }

        header {
            margin-bottom: 40px;
            border-left: 3px solid var(--accent);
            padding-left: 16px;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #fff;
        }

        header p {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 6px;
            font-family: var(--font-mono);
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .card h2 {
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 20px;
            font-family: var(--font-mono);
        }

        .env-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .env-row:last-child { border-bottom: none; }

        .env-key {
            font-family: var(--font-mono);
            font-size: 0.85rem;
            color: var(--accent2);
        }

        .env-value {
            font-family: var(--font-mono);
            font-size: 0.85rem;
            color: var(--text);
            word-break: break-all;
        }

        .env-value.missing {
            color: var(--danger);
            font-style: italic;
        }

        .badge {
            font-family: var(--font-mono);
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .badge.ok { background: rgba(0,229,160,0.15); color: var(--accent); }
        .badge.missing { background: rgba(255,79,79,0.15); color: var(--danger); }

        .summary {
            display: flex;
            gap: 20px;
            margin-top: 24px;
            font-family: var(--font-mono);
            font-size: 0.8rem;
        }

        .summary span { color: var(--muted); }
        .summary .ok-count { color: var(--accent); }
        .summary .miss-count { color: var(--danger); }

        .setup-card {
            background: #0a0c10;
            border: 1px dashed var(--border);
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .setup-card h2 {
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--accent2);
            margin-bottom: 16px;
            font-family: var(--font-mono);
        }

        .setup-card p {
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.7;
            margin-bottom: 16px;
        }

        pre {
            background: #080a0e;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            font-family: var(--font-mono);
            font-size: 0.8rem;
            color: #a8d8b0;
            overflow-x: auto;
            line-height: 1.8;
        }

        .comment { color: var(--muted); }

        footer {
            text-align: center;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">

    <header>
        <h1>ENV Variable Tester</h1>
        <p>Checks if your required environment variables are loaded correctly</p>
    </header>

    <?php
    // ─────────────────────────────────────────────
    // STEP 1: Define which env vars your app needs
    // ─────────────────────────────────────────────
    $required_vars = [
        'APP_NAME',
        'APP_ENV',
        'DB_HOST',
        'DB_NAME',
        'DB_USER',
        'DB_PASS',
        'API_KEY',
        'SECRET_TOKEN',
    ];

    // Load from .env file if it exists (simple parser)
    $env_file = __DIR__ . '/.env';
    if (file_exists($env_file)) {
        $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // skip comments
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                if (!array_key_exists($key, $_ENV)) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                }
            }
        }
    }

    // Count results
    $found = 0;
    $missing = 0;
    foreach ($required_vars as $var) {
        $val = getenv($var);
        if ($val !== false && $val !== '') $found++; else $missing++;
    }
    ?>

    <!-- Results Card -->
    <div class="card">
        <h2>// Environment Variables Status</h2>

        <?php foreach ($required_vars as $var): ?>
            <?php
            $value = getenv($var);
            $has_value = ($value !== false && $value !== '');

            // Mask sensitive keys partially
            $sensitive = ['DB_PASS', 'API_KEY', 'SECRET_TOKEN'];
            $display = $has_value
                ? (in_array($var, $sensitive) ? str_repeat('*', min(strlen($value), 6)) . '...' : $value)
                : null;
            ?>
            <div class="env-row">
                <span class="env-key"><?php echo htmlspecialchars($var); ?></span>
                <span class="env-value <?php echo $has_value ? '' : 'missing'; ?>">
                    <?php echo $has_value ? htmlspecialchars($display) : 'NOT SET'; ?>
                </span>
                <span class="badge <?php echo $has_value ? 'ok' : 'missing'; ?>">
                    <?php echo $has_value ? 'OK' : 'MISSING'; ?>
                </span>
            </div>
        <?php endforeach; ?>

        <div class="summary">
            <span>Total: <?php echo count($required_vars); ?></span>
            <span class="ok-count">✓ Found: <?php echo $found; ?></span>
            <span class="miss-count">✗ Missing: <?php echo $missing; ?></span>
        </div>
    </div>

    <!-- Setup Instructions -->
    <div class="setup-card">
        <h2>// How to set your environment variables</h2>
        <p>Create a file named <strong style="color:#e2e8f0">.env</strong> in the same folder as this PHP file. Add your variables like this:</p>

        <pre><span class="comment"># .env — paste your variables here, one per line</span>

APP_NAME=MyApplication
APP_ENV=production

DB_HOST=localhost
DB_NAME=my_database
DB_USER=db_user
DB_PASS=your_secret_password

API_KEY=your_api_key_here
SECRET_TOKEN=your_secret_token_here</pre>

        <p style="margin-top:16px">Then reload this page — the tester will pick them up automatically.</p>
    </div>

    <footer>env-tester.php &mdash; <?php echo date('Y-m-d H:i:s'); ?> server time</footer>
</div>
</body>
</html>
