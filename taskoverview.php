<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Overview</title>
    <style>
        /* Reset some default styles */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        
        /* Style the navbar */
        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
        }
        
        /* Style the navbar links */
        .navbar a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            padding: 10px;
            transition: color 0.3s ease;
        }
        
        .navbar a:hover {
            color: #0056b3;
        }
        
        /* Style the table */
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 80px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            border-bottom: 2px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        /* Style the success and error messages */
        .success {
            color: green;
        }
        
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="addtask.php">Add Task</a>
        <a href="logout.php">Logout</a>
    </div>
    <h2>Task Overview</h2>
    <div id="countdown"></div>

    <?php
    // 1. Start the session
    session_start();

    // 2. Include database connection file
    include('db_connection.php');

    // 3. Check if user is not logged in, then
    if (!isset($_SESSION['username'])) {
        // 4. Redirect to login page and exit
        header('Location: login.php');
        exit();
    }

    // 5. Get the username from the session
    $username = $_SESSION['username'];

    // 6. Define a function to display status button with parameters completed and taskId
    function displayStatusButton($completed, $taskId)
    {
        // 7. Inside the function, if completed is true, then
        if ($completed) {
            // 8. Display a link to mark the task as To Do
            echo '<a href="mark_as_todo.php?task_id=' . $taskId . '">Mark as To Do</a>';
            // 9. Else, display a link to mark the task as Done
        } else {
            echo '<a href="mark_as_done.php?task_id=' . $taskId . '">Mark as Done</a>';
        }
    }

    // 10. Define a function to display delete button with parameter task_id
    function displayDeleteButton($task_id)
    {
        // 11. Inside the function, display a link to delete the task
        echo '<a href="delete_task.php?task_id=' . $task_id . '">Delete</a>';
    }

    // 12. Create an SQL query to select all tasks for the logged-in user from the database
    $sql = "SELECT * FROM tasks WHERE username = '$username'";

    // 13. Execute the SQL query and store the result in $result
    $result = mysqli_query($conn, $sql);
    
    // 14. If success message is set in the session, then
    if (isset($_SESSION['success'])) {
        // 15. Display the success message and unset the session variable
        echo '<p class="success">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }

    // 16. If error message is set in the session, then
    if (isset($_SESSION['error'])) {
        // 17. Display the error message and unset the session variable
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <table>
        <tr>
            <th>Task Name</th>
            <th>Task Description</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        // 18. Fetch tasks from the database using a while loop
        while ($row = mysqli_fetch_assoc($result)) {
            // 19. Inside the loop, display task details in table rows
            echo '<tr>';
            echo '<td>' . $row['task_name'] . '</td>';
            echo '<td>' . $row['task_description'] . '</td>';
            echo '<td>' . $row['due_date'] . '</td>';
            echo '<td>' . ($row['completed'] ? 'Done' : 'To Do') . '</td>';
            echo '<td>';
            // 20. Display delete and status buttons for each task using the defined functions
            displayDeleteButton($row['task_id']);
            echo ' | ';
            displayStatusButton($row['completed'], $row['task_id']);
            echo '</td>';
            echo '</tr>';
        }// 21. End the loop
        ?>
    </table>
    <script>
        // JavaScript for countdown timer
        function updateCountdown() {
            var dueDates = document.querySelectorAll('td:nth-child(3)');
            var closestDueDate = null;

            dueDates.forEach(function(date) {
                var currentDate = new Date();
                var dueDate = new Date(date.innerText);
                
                if (dueDate >= currentDate) {
                    if (closestDueDate === null || dueDate < closestDueDate) {
                        closestDueDate = dueDate;
                    }
                }
            });

            if (closestDueDate !== null) {
                var timeDifference = closestDueDate.getTime() - new Date().getTime();
                var daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

                document.getElementById('countdown').innerHTML = 'Days until next due task: ' + daysDifference;
            } else {
                document.getElementById('countdown').innerHTML = 'No tasks due';
            }
        }

        // Call updateCountdown initially and then every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
