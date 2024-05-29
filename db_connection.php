<?php
// 1. Assign connection details to PHP variables
$host = 'localhost';
$username = 'kalejoo';
$password = 'password';
$database = 'tasktracker';

// 2. Connect to database server
$conn = mysqli_connect($host, $username, $password, $database);

// 3. If there is an error with the connection then
if (!$conn) {
    // 4. Display error message
    die('Connection failed: ' . mysqli_connect_error());
}//5. End if
?>
