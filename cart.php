<?php
session_start();
include("connection.php");
include("functions.php");

check_login($con);

$user_id = $_SESSION['user_id'];

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $delete_query = "DELETE FROM CART WHERE User_ID = ? AND Product_ID = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Fetch cart items
$query = "SELECT PRODUCT.Name, PRODUCT.Price, CART.Quantity, PRODUCT.Product_ID
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
<body>
<?php include('./view/header.php'); ?>

<div class="container mt-4">
    <h1>Your Cart</h1>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td>$<?php echo number_format($row['Price'], 2); ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $row['Product_ID']; ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    <a href="products.php" class="btn btn-primary">Continue Shopping</a>
    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
</div>

<?php include("./view/footer.php"); ?>
</body>
</html>
