<?php
// 1. Start the session
session_start();

// 2. if the user is logged in
if (isset($_SESSION['username'])) {
    // 3. Clear all session variables
    session_unset();

    // 4. Destroy the session
    session_destroy();
}

// 5. Redirect to the login page
header('Location: login.php');
exit(); // 6. Exit the script
?>
