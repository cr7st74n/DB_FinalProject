<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<?php
    $image_url = './img/product-POP.png';
?>

<body>
<?php include('./view/header.php'); ?>
    <div class="container mt-2">
        <form action="addProducts.php" method="post"  enctype="multipart/form-data">
            <table border="0">
                <tr>
                    <td>Product Name</td>
                    <td><input type="text" name="productName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type="text" name="description" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="text" name="price" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Img</td>
                    <td><input type="file" name="img" accept="image/*" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the info from the user
            $pName = $_POST['productName'];
            $descriptionProduct = $_POST['description'];
            $price = $_POST['price'];
            $imageFile = $_FILES['img']['name'];

            if (!$pName || !$descriptionProduct || !$price || !$imageFile) {
                echo "You have not entered all the required details.<br />Please go back and try again.";
                exit;
            }

            // Database connection
            @$db = new mysqli('localhost', 'gonzac43_testuser1', 'U^fdh{?}aMkc', 'gonzac43_finalproject');

            if ($db->connect_error) {
                echo "Error: Could not connect to database. Please try again later.";
                exit;
            }

            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($imageFile['name']);

            // Prepared statement to prevent SQL injection
            $query = "INSERT INTO PRODUCTS (Name, Description, Price, Image) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ssds', $pName, $description, $price, $imageFile);

            if ($stmt->execute()) {
                echo "Product added successfully!";
            } else {
                echo "An error has occurred. Please try again.";
            }

            $stmt->close();
            $db->close();
        }
        ?>
</body>
</html>