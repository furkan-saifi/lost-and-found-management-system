<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Lost and Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; padding: 24px;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #7F7FD5, #86A8E7, #91EAE4);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: white; text-align: center;
        }
        .logo { width: 88px; height: 88px; margin-bottom: 22px; animation: float 2s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        h1 { font-size: clamp(28px, 5vw, 40px); margin: 0 0 14px; text-shadow: 1px 1px 4px #0003; }
        .tagline { font-size: 17px; margin: 0 0 36px; opacity: .95; }
        .links { display: flex; flex-wrap: wrap; justify-content: center; gap: 18px; margin-bottom: 48px; }
        .links a { min-width: 130px; padding: 12px 28px; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; border: 2px solid #ffffff66; background: #ffffff33; transition: .25s; }
        .links a:hover { background: #fff; color: #536567; transform: translateY(-2px); }
        footer { font-size: 13px; opacity: .85; }
    </style>
</head>
<body>
    <img src="logo.svg" alt="Lost and Found Logo" class="logo">
    <h1>Welcome to Lost and Found</h1>
    <p class="tagline">Helping you recover what matters, right on campus.</p>
    <nav class="links" aria-label="Account">
        <a href="login_form.php">Login</a>
        <a href="signup_form.php">Sign Up</a>
    </nav>
    <footer>&copy; <?php echo date('Y'); ?> Lost and Found | Campus Web App</footer>
</body>
</html>