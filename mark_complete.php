<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

if (isset($_GET['id'])) {
    $taskId = intval($_GET['id']);
    $userId = $_SESSION['user_id'];

    $sql = "UPDATE tasks SET status = 1 WHERE id = $taskId AND user_id = $userId";
    if (mysqli_query($conn, $sql)) {
        echo "Task marked as complete!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
header('Location: index.php');
exit;
?>
