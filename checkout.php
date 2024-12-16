<?php
session_start();
include("connection.php");
include("functions.php");

check_login($con);

$user_id = $_SESSION['user_id'];
// Fetch cart total
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
    // Insert shipping address
    $address1 = $_POST['address1'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];

    $insert_address = "INSERT INTO SHIPPING_ADDRESS (USER_ID, ADDRESS_LINE1, CITY, STATE, ZIP_CODE, COUNTRY) 
                       VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($insert_address);
    $stmt->bind_param('isssss', $user_id, $address1, $city, $state, $zip, $country);
    $stmt->execute();

    // Insert OR
    $insert_order = "INSERT INTO ORDERS (User_ID, TotalAmount) VALUES (?, ?)";
    $stmt = $con->prepare($insert_order);
    $stmt->bind_param('id', $user_id, $total);
    $stmt->execute();

    // Clear 
    $delete = "DELETE FROM CART WHERE User_ID = ?";
    $stmt = $con->prepare($delete);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    echo "<script>alert('Order placed successfully!'); window.location='profile.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<body>
<?php include('./view/header.php'); ?>

<div class="container mt-4">
    <h1>Checkout</h1>
    <p>Total Amount: $<?php echo number_format($total, 2); ?></p>

    <?php if ($total > 0): ?>
        <form method="POST">
            <h3>Shipping Address</h3>
            <input type="text" name="address1" placeholder="Address Line 1" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="state" placeholder="State" required>
            <input type="text" name="zip" placeholder="Zip Code" required>
            <input type="text" name="country" placeholder="Country" required>
            <button type="submit" class="btn btn-success mt-3">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include("./view/footer.php"); ?>
</body>
</html>

