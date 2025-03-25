<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$task_id = intval($_GET['id']);

// Fetch task details
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $task_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Task not found.";
    exit;
}

$task = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_task = mysqli_real_escape_string($conn, $_POST['task']);

    $update_sql = "UPDATE tasks SET task = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $updated_task, $task_id);

    if ($update_stmt->execute()) {
        $_SESSION['login_success'] = "Task updated successfully!";
        header('Location: index.php');
        exit;
    } else {
        echo "Error updating task.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Task</h2>
        <form method="post">
            <div class="mb-3">
                <label for="task" class="form-label">Task</label>
                <input type="text" class="form-control" id="task" name="task" value="<?php echo htmlspecialchars($task['task']); ?>" required />
            </div>
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
