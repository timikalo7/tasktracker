<?php
// 1. Start the session
session_start();

// 2. Include database connection details
include('db_connection.php');

// 3. Check if the user is logged in
// 4. If user is not logged in then
if (!isset($_SESSION['username'])) {
    //5. Redirect to the login page
    header('Location: login.php');
    exit();
}//6. End if

// 7. Check if the task_id is provided in the URL
// 8. If task_id is not provided then
if (!isset($_GET['task_id'])) {
    // 9. Set error message in session: 'Task ID not provided'
    $_SESSION['error'] = 'Task ID not provided';
    //10. Redirect to task overview page
    header('Location: taskoverview.php');
    //11. exit
    exit();
}//12. End if

// 13. Get the task_id from the URL
$task_id = $_GET['task_id'];

// 14. Create query to delete task
$sql = "DELETE FROM tasks WHERE task_id = ?";

//15. Prepare the query using the database connection
$stmt = $conn->prepare($sql);
//16. Bind the task_id parameter to the prepared statement
$stmt->bind_param("i", $task_id);
//17. Execute the prepared statement
$stmt->execute();

// 19. If task deletion was successful then
if ($stmt->affected_rows > 0) {
    // 20. Set success message in session: 'Task deleted successfully'
    $_SESSION['success'] = 'Task deleted successfully';
    //21. Else
} else {
    //22. Set error message in session: 'Failed to delete task'
    $_SESSION['error'] = 'Failed to delete task';
}//23. End if

// 24. Redirect back to task overview page
header('Location: taskoverview.php');
// 25. End session and exit
exit();
?>

