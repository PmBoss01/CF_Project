<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — RocketDash</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #f5f0e8;
            --panel: #ffffff;
            --ink: #1a1714;
            --muted: #8a8480;
            --accent: #c84b2f;
            --accent-hover: #a83a20;
            --border: #e0d9d0;
            --input-bg: #faf8f5;
            --success: #2a7a4b;
            --error-bg: #fdf2f0;
            --error-border: #f0b8ae;
        }

        body {
            background-color: var(--bg);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image:
                radial-gradient(circle at 15% 85%, rgba(200,75,47,0.07) 0%, transparent 45%),
                radial-gradient(circle at 85% 10%, rgba(200,75,47,0.05) 0%, transparent 40%);
        }

        .wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 860px;
            width: 100%;
            margin: 20px;
            background: var(--panel);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(26,23,20,0.12), 0 4px 16px rgba(26,23,20,0.08);
            animation: rise 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .panel-left {
            background: var(--ink);
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            border: 60px solid rgba(200,75,47,0.18);
            bottom: -100px; right: -100px;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 30px solid rgba(200,75,47,0.12);
            top: -40px; left: -40px;
        }

        .brand { position: relative; z-index: 1; }

        .brand-icon {
            width: 44px; height: 44px;
            background: var(--accent);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }

        .brand-icon svg { width: 22px; height: 22px; fill: white; }

        .brand h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem;
            color: #fff;
            font-weight: 400;
            letter-spacing: -0.02em;
        }

        .panel-tagline { position: relative; z-index: 1; }

        .panel-tagline p {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.35);
            line-height: 1.7;
        }

        .panel-right { padding: 52px 48px; }

        .panel-right h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--ink);
            font-weight: 400;
            letter-spacing: -0.03em;
            margin-bottom: 6px;
        }

        .panel-right .subtitle {
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 36px;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200,75,47,0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(200,75,47,0.3);
        }

        .btn-login:hover {
            background: var(--accent-hover);
            box-shadow: 0 6px 20px rgba(200,75,47,0.4);
        }

        .btn-login:active { transform: scale(0.98); }

        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--accent);
        }

        .alert svg { flex-shrink: 0; width: 16px; height: 16px; }

        @media (max-width: 620px) {
            .wrapper { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 40px 28px; }
        }
    </style>
</head>
<body>

<?php
session_start();

// ── If already logged in, redirect straight to About Me ──
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: about.php');
    exit;
}

// ── Load .env file ──
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// ── Handle login form submission ──
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $env_user = getenv('LOGIN_USERNAME');
    $env_pass = getenv('LOGIN_PASSWORD');

    if (empty($username) || empty($password)) {
        $error = 'Please fill in both fields.';
    } elseif ($username === $env_user && $password === $env_pass) {
        // ── Set session and redirect to About Me ──
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $username;
        header('Location: about.php');
        exit;
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>

<div class="wrapper">

    <div class="panel-left">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <h2>RocketDash</h2>
        </div>
        <div class="panel-tagline">
            <p>Secure access to your<br>dashboard. Credentials are<br>loaded from environment<br>variables.</p>
        </div>
    </div>

    <div class="panel-right">
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to your account to continue</p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                    autocomplete="username"
                />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                />
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

</div>

</body>
</html>
