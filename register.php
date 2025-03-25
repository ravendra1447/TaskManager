<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (empty($username) || empty($_POST['password'])) {
        echo "<div class='error'>Username and password cannot be empty!</div>";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='success'>Registration successful! Redirecting to login...</div>";
            header('refresh:2;url=login.php');
        } else {
            echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .error {
            color: red;
            margin-bottom: 16px;
        }
        .success {
            color: green;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
