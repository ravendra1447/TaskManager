<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_success'] = "Login successful!";
            header('Location: index.php');
            exit;
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "User not found!";
    }
}

if (isset($_SESSION['login_success'])) {
    echo "<script>alert('{$_SESSION['login_success']}');</script>";
    unset($_SESSION['login_success']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 24px;
            color: #007bff;
        }
        .form-control {
            margin-bottom: 16px;
        }
        .btn-primary {
            width: 100%;
        }
        .error, .success {
            margin-bottom: 16px;
            padding: 12px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
    <script>
        function hideMessage() {
            const messages = document.querySelectorAll('.error, .success');
            messages.forEach((msg) => {
                setTimeout(() => msg.style.display = 'none', 3000);
            });
        }
        window.onload = hideMessage;
    </script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>
        <?php if (!empty($success_message)) { echo "<div class='success'>$success_message</div>"; } ?>
        <form action="login.php" method="post">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
