<?php
// 1. Start session
session_start();

// 2. Include database connection file
include('db_connection.php');

// 3. If request method is POST then (the form is submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 4. Get username and password from the submitted form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 5. Prepare SQL query to check if username already exists
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    
    // 6. Bind username parameter to the prepared statement
    $sql->bind_param("s", $username);
    
    // 7. Execute the query
    $sql->execute();
    
    // 8. Get the result set
    $result = $sql->get_result();
    
    // 9. If there are rows returned then
    if ($result->num_rows > 0) {
        // 10. Set error message in session
        $_SESSION['error'] = 'Username already taken';
        
        // 11. Redirect to signup page and exit
        header('Location: signup.php');
        exit();
    }

    // 12. Check if password length is less than 8 characters
    if (strlen($password) < 8) {
        // 13. If so set error message in session
        $_SESSION['error'] = 'Password must be at least 8 characters long';
        
        // 14. Then redirect to signup page and exit
        header('Location: signup.php');
        exit();
    }

    // 15. Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 16. Prepare SQL query to insert new user into the database
    $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    // 17. Bind username and hashed password parameters to the prepared statement
    $sql->bind_param("ss", $username, $hashed_password);
    
    // 18. Execute the query
    $sql->execute();
    
    // 19. Set success message in session
    $_SESSION['success'] = 'Registration successful';
    
    // 20. Redirect to task overview page and exit
    header('Location: taskoverview.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            justify-content: center;
            padding: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
        }
        
        /* Style the login link */
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
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-top: 80px; /* Add margin to avoid overlap with navbar */
        }
        
        /* Style the form elements */
        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        /* Style the error message */
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 20px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="login.php" style="margin: 0 auto;">Login</a>
    </div>
    <h2>Sign Up</h2>
    <!-- If there is an error message -->
    <?php if (isset($_SESSION['error'])): ?>
        <!-- Display error message -->
        <div class="error"><?php echo $_SESSION['error']; ?></div>
        <!-- Reset error message -->
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="signup.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required minlength="8"><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
