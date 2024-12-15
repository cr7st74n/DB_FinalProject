<?php
session_start();
include("connection.php");
include("functions.php");

// Ensure user is logged in
check_login($con);

$user_id = $_SESSION['user_id'];

// Example: Fetch cart items and calculate total
$query = "SELECT SUM(PRODUCT.Price * CART.Quantity) AS Total 
          FROM CART 
          JOIN PRODUCT ON CART.Product_ID = PRODUCT.Product_ID 
          WHERE CART.User_ID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->fetch_assoc()['Total'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $total > 0) {
    // Insert order into ORDERS table
    $insert = "INSERT INTO ORDERS (User_ID, TotalAmount) VALUES (?, ?)";
    $stmt = $con->prepare($insert);
    $stmt->bind_param('id', $user_id, $total);
    if ($stmt->execute()) {
        // Clear cart after checkout
        $delete = "DELETE FROM CART WHERE User_ID = ?";
        $stmt = $con->prepare($delete);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        echo "Order placed successfully!";
    } else {
        echo "Failed to place the order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Checkout</h1>
    <p>Total Amount: $<?php echo number_format($total, 2); ?></p>
    <?php if ($total > 0): ?>
        <form method="POST">
            <button type="submit">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
