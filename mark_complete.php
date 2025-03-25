<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    echo "Invalid request.";
    exit;
}

$id = intval($_POST['id']);
$user_id = $_SESSION['user_id'];

$sql = "UPDATE tasks SET status = 1 WHERE id = $id AND user_id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo "Task marked as completed.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
