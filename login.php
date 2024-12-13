<?php
session_start();

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connection.php"); // Ensure the file exists and is correct
include("functions.php");  // Ensure functions like check_login are defined

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uName = $_POST['userName'];
    $password = $_POST['password'];

    if (!empty($uName) && !empty($password)) {
        $query = "SELECT * FROM USERS WHERE UserName = ? LIMIT 1";
        $stmt = $con->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $uName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user_data = $result->fetch_assoc();

                if (password_verify($password, $user_data['PasswordHash'])) {
                    $_SESSION['user_id'] = $user_data['User_ID'];
                    $_SESSION['username'] = $user_data['UserName'];
                    header("Location: profile.php");
                    die;
                } else {
                    echo "Invalid username or password.";
                }
            } else {
                echo "No user found with that username.";
            }
        } else {
            echo "Query preparation failed: " . $con->error;
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="userName">Username:</label>
        <input type="text" id="userName" name="userName" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
