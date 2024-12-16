<?php
function check_login($con) {
    if (!isset($_SESSION['user_id'])) {
        // Go to the login page if needed
        header("Location: login.php");
        die;
    }
}
function fetch_user_data($con) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM USERS WHERE User_ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    return null;
}
?>
