<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lost and Found</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: "Poppins", "Segoe UI", sans-serif;
            background: linear-gradient(to right, #7F7FD5, #86A8E7, #91EAE4);
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; margin: 0; padding: 20px;
        }
        .form-container {
            background: rgba(255,255,255,.82); padding: 40px 30px;
            border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,.15);
            width: min(500px, 100%); text-align: center;
        }
        h2 { margin-bottom: 25px; font-weight: 600; font-size: 26px; }
        input {
            display: block; width: 100%; padding: 12px 15px;
            margin-bottom: 16px; border: 1px solid #ddd; border-radius: 8px;
            font-size: 15px;
        }
        button {
            width: 100%; padding: 12px; background: #667eea; color: white;
            font-weight: 600; font-size: 16px; border: none; border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background: #5365c9; }
        p { margin-top: 20px; font-size: 14px; }
        a { color: #167b95; font-weight: 500; }
    </style>
</head>
<body>
    <main class="form-container">
        <h2>Login</h2>
        <form action="auth/login.php" method="POST">
            <input type="email" name="email" placeholder="Email Address" autocomplete="email" required>
            <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup_form.php">Sign up here</a></p>
    </main>
</body>
</html>