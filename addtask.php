<?php
// 1. Start the session
session_start();

// 2. Include database connection details
include('db_connection.php');

// 3. If session variable 'username' is not set then
if (!isset($_SESSION['username'])) {
    // 4. Redirect to 'login.php'
    header('Location: login.php');
    exit();
}

// 7. Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 8. Get form data
    // 9. Assign form data to PHP variables
    $taskName = $_POST['taskName'];
    $taskDescription = $_POST['taskDescription'];
    $dueDate = $_POST['dueDate'];

    // 10. Set default value for completed field
    $completed = false;

    // 11. Get the username from the session
    $username = $_SESSION['username'];

    // 12. Create a query to add task details to the database
    $sql = "INSERT INTO tasks (username, task_name, task_description, completed, due_date) VALUES (?, ?, ?, ?, ?)";
    // 13. Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    // 14. Bind parameters to the prepared statement
    $stmt->bind_param("sssis", $username, $taskName, $taskDescription, $completed, $dueDate);
    // 15. Execute the prepared statement
    $stmt->execute();

    // 16. Set a session variable to indicate successful task creation
    $_SESSION['success'] = 'Task added successfully';

    // 17. Redirect to 'taskoverview.php'
    header('Location: taskoverview.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
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

        /* Style the form */
        form {
            margin-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 300px;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="taskoverview.php">Task Overview</a>
        <a href="logout.php">Logout</a>
    </div>
    <h2>Add Task</h2>
    <form action="addtask.php" method="post">
        <label for="taskName">Task Name:</label>
        <input type="text" name="taskName" required>

        <label for="taskDescription">Task Description:</label>
        <textarea name="taskDescription" required></textarea>

        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" required>

        <input type="submit" value="Add Task">
    </form>
</body>
</html>
