<?php
session_start();
include("connection.php");
include("functions.php");

// Check for product_id in the URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uName = $_POST['userName'];
    $password = $_POST['password'];

    if (!empty($uName) && !empty($password)) {
        // Authenticate User
        $query = "SELECT * FROM USERS WHERE UserName = ? LIMIT 1";
        $stmt = $con->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $uName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user_data = $result->fetch_assoc();

                if (password_verify($password, $user_data['PasswordHash'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user_data['User_ID'];
                    $_SESSION['username'] = $user_data['UserName'];

                    // If product_id exists, redirect to add it to cart
                    if ($product_id) {
                        header("Location: products.php?add_to_cart=true&product_id=$product_id");
                        exit();
                    }

                    // Redirect to profile page if no product_id
                    header("Location: profile.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid username or password.');</script>";
                }
            } else {
                echo "<script>alert('No user found with that username.');</script>";
            }
        } else {
            echo "Query preparation failed: " . $con->error;
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<body>
    <?php include('./view/header.php'); ?>
    <h1>Log in</h1>
    <div class="container mt-2">
        <form action="login.php<?php echo $product_id ? '?product_id=' . $product_id : ''; ?>" method="post">
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
</body>
</html>

