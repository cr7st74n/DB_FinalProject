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
            ?>
            <h1>"Welcome, <?php echo htmlspecialchars($user_data['UserName']); ?></h1>
                <h1>echo 'This is your profile !';</h1>
                <ul>
                    <li><?php echo 'Inset Title'; ?></li>
                    <li><?php echo 'IMG'; ?></li>
                    <li><?php echo 'Add to cart'; ?></li>
                </ul>
        <?php    
        } else {
            echo "User not found.";
        }
        ?>
    
    
    <?php include("./view/footer.php"); ?>
</body>
</html>