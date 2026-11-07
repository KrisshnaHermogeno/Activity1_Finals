<?php
require_once "config.php";

function h($str){
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

$mess = [];
$errors = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password === $password2){

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $uname, $password);

        if($stmt->execute()){
            $mess[] = "Account created successfully. Please wait for approval.";
        }else{
            $errors[] = "Something went wrong. Please try again.";
        }

        $stmt->close();

    }else{
        $errors[] = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

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

        .success {
            background: #f0fdf4;
            color: #16a34a;
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
        <h2>Create an Account</h2>

        <?php foreach ($errors as $e): ?>
            <p class="error"><?= h($e) ?></p>
        <?php endforeach; ?>

        <?php foreach ($mess as $m): ?>
            <p class="success"><?= h($m) ?></p>
        <?php endforeach; ?>

        <form action="" method="post">

            <label>Username:</label>
            <input type="text" name="uname" placeholder="Enter your username" required autofocus>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <label>Confirm Password:</label>
            <input type="password" name="password2" placeholder="Confirm your password" required>

            <input type="submit" value="Create Account">

        </form>

        <p class="footer">
            Already have an account?
            <a href="index.php">Sign in here</a>
        </p>

    </div>

</body>
</html>