<?php
session_start();
include("connection.php");
include("functions.php");

$user_logged_in = false;

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_logged_in = true;
    $user_id = $_SESSION['user_id'];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];

    if ($user_logged_in) {
        $query = "SELECT Quantity FROM CART WHERE User_ID = ? AND Product_ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $user_id, $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $query = "UPDATE CART SET Quantity = Quantity + 1 WHERE User_ID = ? AND Product_ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $user_id, $productID);
            $stmt->execute();
        } else {
            $query = "INSERT INTO CART (User_ID, Product_ID, Quantity) VALUES (?, ?, 1)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $user_id, $productID);
            $stmt->execute();
        }

        echo "<script>alert('Product added to cart!');</script>";
    } else {
        header("Location: login.php?product_id=$productID");
        exit();
    }
}

// Handle Delete Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $productID = $_POST['product_id'];

    // Ensure the product belongs to the logged-in user
    $query = "DELETE FROM PRODUCT WHERE Product_ID = ? AND User_ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii', $productID, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete product.');</script>";
    }
}

// Handle Edit Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $productID = $_POST['product_id'];
    $newName = $_POST['name'];
    $newDescription = $_POST['description'];
    $newPrice = $_POST['price'];

    // Ensure the product belongs to the logged-in user
    $query = "UPDATE PRODUCT SET Name = ?, Description = ?, Price = ? WHERE Product_ID = ? AND User_ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssdii', $newName, $newDescription, $newPrice, $productID, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update product.');</script>";
    }
}

// Fetch All Products
$query = "SELECT * FROM PRODUCT";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<body>
<?php include('./view/header.php'); ?>
<div class="container mt-4">
    <h2>All Products</h2>
    <div class="row">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($product['Image']); ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['Name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['Description']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($product['Price'], 2); ?></p>

                        <!-- Add to Cart Form -->
                        <form method="post" action="products.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
                        </form>

                        <!-- Edit Product Form -->
                        <?php if ($user_logged_in && $product['User_ID'] == $user_id): ?>
                            <form method="post" action="products.php" class="mt-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($product['Name']); ?>" required>
                                <input type="text" name="description" value="<?php echo htmlspecialchars($product['Description']); ?>" required>
                                <input type="number" step="0.01" name="price" value="<?php echo $product['Price']; ?>" required>
                                <button type="submit" name="edit_product" class="btn btn-warning">Edit</button>
                            </form>

                            <!-- Delete Product Form -->
                            <form method="post" action="products.php" class="mt-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include("./view/footer.php"); ?>
</body>
</html>
