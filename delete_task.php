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

    $sql = "DELETE FROM tasks WHERE id = $taskId AND user_id = $userId";
    if (mysqli_query($conn, $sql)) {
        echo "Task deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
header('Location: index.php');
exit;
?>
