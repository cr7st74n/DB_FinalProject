<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<?php
    $image_url = './img/product-POP.png';
?>

<body>
<?php include('./view/header.php'); ?>
    <div class="container mt-2">
        <form action="products.php" method="post"  enctype="multipart/form-data">
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
                // Get form inputs
                $pName = $_POST['productName'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $imageFile = $_FILES['img'];

                // Check if the form fields are filled
                if (!$pName || !$description || !$price || !$imageFile) {
                    echo "You have not entered all the required details.<br />Please go back and try again.";
                    exit;
                }

                // Check for file upload errors
                if ($imageFile['error'] !== UPLOAD_ERR_OK) {
                    echo "File upload error code: " . $imageFile['error'] . "<br>";
                    switch ($imageFile['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            echo "Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            echo "Error: The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form.";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            echo "Error: The uploaded file was only partially uploaded.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            echo "Error: No file was uploaded.";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            echo "Error: Missing a temporary folder.";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            echo "Error: Failed to write file to disk.";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            echo "Error: A PHP extension stopped the file upload.";
                            break;
                        default:
                            echo "Error: Unknown upload error.";
                            break;
                    }
                    exit;
                }

                // Debug uploaded file paths
                echo "Temp file location: " . $imageFile['tmp_name'] . "<br>";
                echo "Original file name: " . $imageFile['name'] . "<br>";

                // Ensure "uploads" directory exists
                $targetDir = __DIR__ . "/uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Move uploaded file to the "uploads" directory
                $targetFile = $targetDir . basename($imageFile['name']);
                if (move_uploaded_file($imageFile['tmp_name'], $targetFile)) {
                    echo "File successfully uploaded to: " . $targetFile . "<br>";

                    // Database connection
                    @$db = new mysqli('localhost', 'gonzac43_testuser1', 'U^fdh{?}aMkc', 'gonzac43_finalproject');

                    if ($db->connect_error) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    // Insert product details into the database
                    $query = "INSERT INTO PRODUCT (Name, Description, Price, Image) VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($query);

                    if ($stmt) {
                        $stmt->bind_param('ssds', $pName, $description, $price, $targetFile);

                        if ($stmt->execute()) {
                            echo "Product added successfully!";
                        } else {
                            echo "Error: Could not add the product. Please try again.";
                        }

                        $stmt->close();
                    } else {
                        echo "Error: Could not prepare the SQL statement.";
                    }

                    $db->close();
                } else {
                    echo "Error: Failed to move the uploaded file.";
                }
            }
            ?>
            
        </div>
    <?php include("./view/footer.php"); ?>
</body>
</html>