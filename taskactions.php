<?php
// 1. Start the session
session_start();

// 2. Include database connection
include('db_connection.php');

// 3. Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // 4. Redirect to login page and exit if not logged in
    header('Location: login.php');
    exit();
}

// 5. Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 6. if so get task ID from the submitted form
    $task_id = $_POST['task_id'];

    // 7. if "delete" button is clicked
    if (isset($_POST['delete'])) {
        // 8. then create query to delete the task from the database
        $sql = "DELETE FROM tasks WHERE task_id = '$task_id'";
        // 9. Execute the delete query 
        mysqli_query($conn, $sql);
        // 10. Set session success message for task deletion
        $_SESSION['success'] = 'Task deleted successfully';
    // 11. elseif "mark_as_done" button is clicked
    } elseif (isset($_POST['mark_as_done'])) {
        // 12. then create SQL query to mark task as done with task ID
        $sql = "UPDATE tasks SET completed = true WHERE task_id = '$task_id'";
        // 13. Execute the update query 
        mysqli_query($conn, $sql);
        // 14. Set session success message for marking task as done
        $_SESSION['success'] = 'Task marked as done';
    // 15. elseif "mark_as_todo" button is clicked
    } elseif (isset($_POST['mark_as_todo'])) {
        // 16. then create SQL query to mark task as to-do with task ID
        $sql = "UPDATE tasks SET completed = false WHERE task_id = '$task_id'";
        // 17. Execute the update query on the database
        mysqli_query($conn, $sql);
        // 18. Set session success message for marking task as to-do
        $_SESSION['success'] = 'Task marked as to-do';
    }
}

// 19. Redirect back to the task overview page
header('Location: taskoverview.php');
// 20. Exit the script
exit();
?>
!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
</body>
</html>

