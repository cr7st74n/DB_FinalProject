<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>

<?php include('./view/header.php'); ?>

<body>

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
        echo "<h1>Welcome, " . htmlspecialchars($user_data['UserName']) . "</h1>";
        echo "<h1>This is your profile!</h1>";
        echo "<ul>
                <li>Insert Title</li>
                <li>IMG</li>
                <li>Add to cart</li>
              </ul>";
        header("Location: LoginUser.php");
    } else {
        echo "User not found.";
    }

    ?>

    <?php include("./view/footer.php"); ?>

</body>

</html>