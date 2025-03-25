<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    echo "Invalid request.";
    exit;
}

$id = intval($_POST['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM tasks WHERE id = $id AND user_id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo "Task deleted successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
