<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = $user_id");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['task']}</td>
            <td>" . ($row['status'] ? 'Completed' : 'Pending') . "</td>
            <td>
              <button class='btn btn-sm btn-primary' onclick='editTask({$row['id']})'>Edit</button>
              <button class='btn btn-success btn-sm' onclick='markComplete({$row['id']})'>Complete</button>
              <button class='btn btn-danger btn-sm' onclick='deleteTask({$row['id']})'>Delete</button>
            </td>
          </tr>";
}
?>
