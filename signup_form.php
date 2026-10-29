<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lost and Found</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #00c9ff, #92fe9d);
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh; padding: 20px;
        }
        .form-container {
            background: rgba(255,255,255,.88); padding: 40px 30px;
            border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,.15);
            width: min(500px, 100%); text-align: center;
        }
        h2 { margin-bottom: 25px; color: #333; }
        input {
            width: 100%; padding: 12px; margin-bottom: 16px;
            border: 1px solid #ddd; border-radius: 8px; font-size: 15px;
        }
        button {
            width: 100%; padding: 12px; background: #00a9bd; color: white;
            font-size: 16px; border: none; border-radius: 6px; cursor: pointer;
        }
        button:hover { background: #008b9b; }
        p { margin-top: 16px; font-size: 14px; }
        a { color: #007f91; }
    </style>
</head>
<body>
    <main class="form-container">
        <h2>Create Account</h2>
        <form action="auth/signup.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" autocomplete="name" required>
            <input type="email" name="email" placeholder="Email Address" autocomplete="email" required>
            <input type="password" name="password" placeholder="Password (minimum 8 characters)" autocomplete="new-password" minlength="8" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="new-password" minlength="8" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login_form.php">Login here</a></p>
    </main>
</body>
</html>