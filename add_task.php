<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO tasks (user_id, task, status) VALUES ('$user_id', '$task', 0)";
    if (mysqli_query($conn, $sql)) {
        echo "Task added successfully!";

    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
