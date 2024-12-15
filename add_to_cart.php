<?php
session_start();
include("connection.php");
include("functions.php");

// Ensure user is logged in
check_login($con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Insert into cart
    $query = "INSERT INTO CART (User_ID, Product_ID, Quantity) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iii', $user_id, $product_id, $quantity);

    if ($stmt->execute()) {
        header("Location: cart.php");
    } else {
        echo "Failed to add product to cart.";
    }
}
?>
