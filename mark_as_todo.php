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

//8. Check if the task_id is provided in the URL
if (!isset($_GET['task_id'])) {
    // 9. Redirect to task overview with an error message if task_id is not provided and exit
    $_SESSION['error'] = 'Task ID not provided';
    header('Location: taskoverview.php');
    exit();
}// 10. End if

// 11. Get the task_id from the URL
$task_id = $_GET['task_id'];

// 12. Create a query to update the task's completed status to false
$sql = "UPDATE tasks SET completed = false WHERE task_id = ?";
// 13. Prepare the query for execution
$stmt = $conn->prepare($sql);
// 14. Bind the task_id parameter to the prepared statement
$stmt->bind_param("i", $task_id);
// 15. Execute the prepared statement
$stmt->execute();

// 16. Check if the task was successfully updated
// 17. If the task was successfully updated, then
if ($stmt->affected_rows > 0) {
    // 18. Set a success message in the session: 'Task marked as to-do successfully'
    $_SESSION['success'] = 'Task marked as to-do successfully';
    // 19. Else
} else {
    // 20. Set an error message in the session: 'Failed to mark task as to-do'
    $_SESSION['error'] = 'Failed to mark task as to-do';
}// 21. End if


// 22. Redirect back to task overview
header('Location: taskoverview.php');
// 23. Exit
exit();
?>


