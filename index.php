<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task Manager</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <script>
    // Auto reload every 1 minute (60000 ms)
    setTimeout(() => {
      location.reload();
    }, 60000);
  </script>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">Task Manager</h2>

    <!-- Task Form -->
    <form id="taskForm" class="mb-3" action="add_task.php" method="post">
      <div class="mb-3">
        <label for="task" class="form-label">Task</label>
        <input type="text" class="form-control" id="task" name="task" required />
      </div>
      <button type="submit" class="btn btn-primary">Add Task</button>
    </form>

    <!-- Task List -->
    <h3>Task List</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Task</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="taskList">
        <?php
        include 'config.php';
        $user_id = $_SESSION['user_id'];
        $result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = $user_id");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['task']}</td>
                  <td>" . ($row['status'] ? 'Completed' : 'Pending') . "</td>
                  <td>
                    <a href='mark_complete.php?id={$row['id']}' class='btn btn-success btn-sm'>Complete</a>
                    <a href='delete_task.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                  </td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
    <a href="logout.php" class="btn btn-danger" onclick="logoutUser(event)">Logout</a>
  </div>
  <script>
    const taskForm = document.getElementById('taskForm');
    taskForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const task = document.getElementById('task').value;
      fetch('add_task.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `task=${task}`,
      })
        .then((response) => response.text())
        .then(() => {
          window.location.reload();
        });
    });

    function logoutUser(event) {
      event.preventDefault();
      fetch('logout.php')
        .then(() => {
          alert('Logout successful!');
          window.location.href = 'login.php';
        });
    }
  </script>
</body>
</html>
