<?php
// 1. Start the session
session_start();

// 2. Include database connection
include('db_connection.php');

// 3. Check if the user is logged in
// 4. If the user is not logged in, then
if (!isset($_SESSION['username'])) {
    // 5. Redirect to the login page
    header('Location: login.php');
    //6. Exit
    exit();
}//7. End if

// 8. Check if the task_id is provided in the URL
// 9. If task_id is not provided, then
if (!isset($_GET['task_id'])) {
    // 10. Set an error message in the session
    $_SESSION['error'] = 'Task ID not provided';
    // 11. Redirect to the task overview page
    header('Location: taskoverview.php');
    // 12. Exit
    exit();
}// 13. End if

// 14. Get the task_id from the URL
$task_id = $_GET['task_id'];

// 15. Create sql statement to update the task to mark it as done in the database
$sql = "UPDATE tasks SET completed = true WHERE task_id = ?";
// 16. Prepare a SQL query to update the 'completed' field
$stmt = $conn->prepare($sql);
// 17. Bind the task_id to the prepared statement
$stmt->bind_param("i", $task_id);
// 18. Execute the prepared statement
$stmt->execute();

// 19. Check if the task was successfully updated
// 20. If the task was successfully updated, then
if ($stmt->affected_rows > 0) {
    // 21. Set a success message in the session
    $_SESSION['success'] = 'Task marked as done successfully';
    //22. Else, if the task update failed, then
} else {
    // 23. Set an error message in the session
    $_SESSION['error'] = 'Failed to mark task as done';
}// 24. End if

// 25. Redirect back to task overview
header('Location: taskoverview.php');
// 26. Exit
exit();
?>
