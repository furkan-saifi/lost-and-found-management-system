<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Lost and Found</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; padding: 24px;
            display: flex; align-items: center; justify-content: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #7F7FD5, #86A8E7, #91EAE4);
        }
        .form-container {
            width: min(420px, 100%); padding: 40px;
            border-radius: 16px; text-align: center; background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,.12);
        }
        h2 { color: #333; }
        a { color: #007bff; font-weight: 600; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <main class="form-container">
        <h2>Welcome to Lost and Found</h2>
        <p><a href="start.php">Start</a> to continue.</p>
    </main>
</body>
</html>