<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Something was posted
    $uName = $_POST['userName'];
    $password = $_POST['password'];

    if(!empty($uName) && !empty($password)&& !is_numeric($uName)) {

        //save to DB
        $query = "INSERT INTO USERS (UserName,PasswordHash) VALUES ('$uName', '$password')";
        
        mysqli_query($con,$query);

    }else{
        echo " please enter some valid information";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<?php include('./view/header.php'); ?>


<body>

    <h1><?php echo 'Hey Check out your profile'; ?></h1>
    <ul>
        <li><?php echo 'Inset Title'; ?></li>
        <li><?php echo 'IMG'; ?></li>
        <li><?php echo 'Add to cart'; ?></li>
    </ul>

    <?php include("./view/footer.php"); ?>
</body>


</html>