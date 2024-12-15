<?php
session_start();
include("connection.php");
include("functions.php");

// Ensure user is logged in
check_login($con);

$user_id = $_SESSION['user_id'];
$query = "SELECT PRODUCT.ProductName, CART.Quantity 
          FROM CART 
          JOIN PRODUCT ON CART.Product_ID = PRODUCT.Product_ID 
          WHERE CART.User_ID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<?php include('./view/header.php'); ?>

<body>
    <h1>Your Cart</h1>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    Product: <?php echo htmlspecialchars($row['ProductName']); ?> - 
                    Quantity: <?php echo $row['Quantity']; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    <a href="products.php">Continue Shopping</a>
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
