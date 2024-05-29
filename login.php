<?php
// 1. Start the session
session_start();

// 2. Include database connection details
include('db_connection.php');

// 3. Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 4. Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 5. Prepare SQL statement to select username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    // 6. Bind the username parameter to the prepared statement
    $stmt->bind_param("s", $username);
    
    // 7. Execute statement
    $stmt->execute();
    
    // 8. Store result in variable
    $result = $stmt->get_result();

    // 9. If username exists
    if ($result->num_rows === 1) {
        // 10. Fetch the user data
        $row = $result->fetch_assoc();
        
        // 11. Verify password
        if (password_verify($password, $row['password'])) {
            // 12. Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['userID'];
            
            // 13. Redirect to task overview page
            header("Location: taskoverview.php");
            exit();
        } else {
            // 14. If invalid password, redirect to login page and exit
            $_SESSION['error'] = 'Invalid username or password';
            header("Location: login.php");
            exit();
        }
    } else {
        // 15. If username not found, redirect to login page
        $_SESSION['error'] = 'Invalid username or password';
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        
        /* Center container vertically and horizontally */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
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
        
        /* Style the signup button */
        .navbar .btn-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            padding: 10px;
            transition: color 0.3s ease;
        }
        
        .navbar .btn-link:hover {
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
        
        /* Style the form header */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        /* Style form elements */
        .form-label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        /* Style the error message */
        .alert-danger {
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
        <a href="signup.php" class="btn btn-link">Signup</a>
    </div>
    <div class="container">
        <h2>Login</h2>
        <!-- If there is an error message -->
        <?php if (isset($_SESSION['error'])): ?>
            <!-- Display error message -->
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <!-- Reset error message -->
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
