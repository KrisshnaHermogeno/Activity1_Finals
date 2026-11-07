<?php
require_once "config.php";

function h($str){
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

$errors = [];

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $uname = $_POST['uname'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $uname);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && $password === $user['password']) {
        if ($user['status'] !== "approved") {
            $errors[] = "Your account is not approved yet.";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: dashboard.php');
            exit;
        }
    } else {
        $errors[] = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        h1 {
            font-size: 25px;
            color: #222;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 14px;
            font-weight: 400;
            color: #888;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px;
            border: 1px solid #e2e5e9;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
            margin-bottom: 20px;
            background: #fafafa;
        }

        input:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 13px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #1d4ed8;
        }

        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 20px;
        }

        .error {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 22px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Inventory System</h1>
        <h2>Sign In to your account</h2>

        <?php foreach ($errors as $e): ?>
            <p class="error"><?= h($e) ?></p>
        <?php endforeach; ?>

        <form action="" method="post">

            <label>Username:</label>
            <input type="text" name="uname" placeholder="Enter your username" required autofocus>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <input type="submit" value="Sign In">

        </form>

        <p class="footer">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>

    </div>

</body>
</html>