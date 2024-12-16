<?php
//Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];

    if ($user_logged_in) {
        // Check if the product is already in the user's cart
        $query = "SELECT Quantity FROM CART WHERE User_ID = ? AND Product_ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $user_id, $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product is already in cart, update the quantity
            $query = "UPDATE CART SET Quantity = Quantity + 1 WHERE User_ID = ? AND Product_ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $user_id, $productID);
            $stmt->execute();
        } else {
            // Product is not in cart, insert it
            $query = "INSERT INTO CART (User_ID, Product_ID, Quantity) VALUES (?, ?, 1)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $user_id, $productID);
            $stmt->execute();
        }

        echo "<script>alert('Product added to cart!');</script>";
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php?product_id=$productID");
        exit();
    }
}
?>