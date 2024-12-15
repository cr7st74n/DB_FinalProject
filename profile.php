<?php
session_start();
include("connection.php");
include("functions.php");

// Ensure user is logged in
check_login($con);
$user_data = fetch_user_data($con);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<?php include('./view/header.php'); ?>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($user_data['UserName']); ?></h1>
    <h2>This is your profile page.</h2>

    <ul>
        <li><a href="cart.php">Manage Your Cart</a></li>
        <li><a href="order_history.php">View Order History</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <?php include("./view/footer.php"); ?>
</body>
</html>
