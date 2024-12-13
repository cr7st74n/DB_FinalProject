<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uName = $_POST['userName'];
    $password = $_POST['password'];

    // Validate input
    if (!empty($uName) && !empty($password)) {
        // Fetch user from the database
        $query = "SELECT * FROM USERS WHERE UserName = ? LIMIT 1";
        $stmt = $con->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $uName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                // Fetch user data
                $user_data = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $user_data['PasswordHash'])) {
                    // Set session and redirect to profile
                    $_SESSION['user_id'] = $user_data['User_ID'];
                    $_SESSION['username'] = $user_data['UserName'];
                    header("Location: profile.php");
                    die;
                } else {
                    echo "Invalid username or password.";
                }
            } else {
                echo "No user found with the provided username.";
            }
        } else {
            echo "Query preparation failed: " . $con->error;
        }
    } else {
        echo "Please enter valid login information.";
    }
}
?>
