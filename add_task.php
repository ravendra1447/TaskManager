<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $userId = $_SESSION['user_id'];

    if (empty($task)) {
        echo "Task cannot be empty!";
    } else {
        $sql = "INSERT INTO tasks (user_id, task, status) VALUES ('$userId', '$task', 0)";
        if (mysqli_query($conn, $sql)) {
            echo "Task added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
header('Location: index.php');
exit;
?>
