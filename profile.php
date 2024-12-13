<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uName = $_POST['userName'];
    $password = $_POST['password'];

    if (!empty($uName) && !empty($password) && !is_numeric($uName)) {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Save to DB
        $query = "INSERT INTO USERS (UserName, PasswordHash) VALUES ('$uName', '$passwordHash')";
        
        mysqli_query($con, $query);
        echo "User registered successfully!";
    } else {
        echo "Please enter some valid information.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<?php include('./view/header.php'); ?>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($user_data['UserName']); ?>!</h1>
    <p>Your ID: <?php echo htmlspecialchars($user_data['id']); ?></p>

    <a href="logout.php">Logout</a>
    <?php include("./view/footer.php"); ?>
</body>
</html>
