<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>
<!-- Login if you have an account. -->
<body>
    <?php include('./view/header.php'); ?>
    <h1><?php echo "Log in" ?></h1>
    <div class="container mt-2">
        <form action="login.php" method="post">
            <table border="0">
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="userName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>
    </div>
    <br>

    <p><?php echo"Hey! you don't have an account! sing in with us"?></p>
    <!-- Sign in part here  -->
    <h1><?php echo "Sing in with us" ?></h1>
    <div class="container mt-2">
        <form action="Signin.php" method="post">
            <table border="0">
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="userName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="name" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" name="lastName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>
        <br>
    </div>
    <!--PHP Part ================================================  -->
    <?php
    session_start();
    include("connection.php");
    include("functions.php");
    
    // Check if product_id is passed
    $product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Authentication
        $query = "SELECT * FROM USERS WHERE UserName = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
    
        if ($user_data && password_verify($password, $user_data['PasswordHash'])) {
            $_SESSION['User_ID'] = $user_data['User_ID'];
            $_SESSION['UserName'] = $user_data['UserName'];
    
            if ($product_id) {
                $user_id = $user_data['User_ID'];
                $cart_query = "INSERT INTO CART (User_ID, Product_ID) VALUES (?, ?)";
                $cart_stmt = $con->prepare($cart_query);
                $cart_stmt->bind_param('ii', $user_id, $product_id);
                $cart_stmt->execute();
    
                // Redirect back to products page
                header("Location: products.php");
                exit();
            }
    
            // Default page to go
            header("Location: products.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    }
    ?>
    <?php include("./view/footer.php"); ?>
</body>
</html>
