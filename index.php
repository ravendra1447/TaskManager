<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (isset($_SESSION['login_success'])) {
  echo "<script>alert('{$_SESSION['login_success']}');</script>";
  unset($_SESSION['login_success']);
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
        function hideMessage() {
            const messages = document.querySelectorAll('.success');
            messages.forEach((msg) => {
                setTimeout(() => msg.style.display = 'none', 3000);
            });
        }
        window.onload = hideMessage;
    </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">Task Manager</h2>

    <div id="message" class="alert d-none"></div>

    <!-- Task Form -->
    <form id="taskForm" class="mb-3">
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
      <tbody id="taskList"></tbody>
    </table>
    <a href="#" class="btn btn-danger" onclick="logoutUser(event)">Logout</a>
  </div>

  <script>
    function showMessage(message, type = 'success') {
      const messageDiv = $('#message');
      messageDiv.removeClass('d-none').addClass(`alert-${type}`).text(message);
      setTimeout(() => messageDiv.addClass('d-none').removeClass(`alert-${type}`), 3000);
    }

    function fetchTasks() {
      $.ajax({
        url: 'fetch_tasks.php',
        method: 'GET',
        success: function(data) {
          $('#taskList').html(data);
        }
      });
    }

    $('#taskForm').submit(function(e) {
      e.preventDefault();
      const task = $('#task').val();
      $.ajax({
        url: 'add_task.php',
        method: 'POST',
        data: { task: task },
        success: function(response) {
          showMessage(response);
          $('#task').val('');
          fetchTasks();
        }
      });
    });

    function markComplete(id) {
      $.ajax({
        url: 'mark_complete.php',
        method: 'POST',
        data: { id: id },
        success: function(response) {
          showMessage(response);
          fetchTasks();
        }
      });
    }

    function deleteTask(id) {
      $.ajax({
        url: 'delete_task.php',
        method: 'POST',
        data: { id: id },
        success: function(response) {
          showMessage(response);
          fetchTasks();
        }
      });
    }
    function editTask(id) {
  window.location.href = `edit_task.php?id=${id}`;
}


    function logoutUser(event) {
  event.preventDefault();
  alert('Logout successful!');
  window.location.href = 'login.php';
}


    // Initial fetch
    fetchTasks();
    setInterval(fetchTasks, 60000); // Refresh every 60 seconds
  </script>
</body>
</html>
