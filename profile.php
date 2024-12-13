<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

// Fetch user details (optional if needed)
include("connection.php");
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM USERS WHERE User_ID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    echo "Welcome, " . $user_data['UserName'];
} else {
    echo "User not found.";
}
?>
