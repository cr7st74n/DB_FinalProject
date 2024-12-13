<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<?php include('./view/header.php'); ?>

<?php
    $image_url = './img/product-POP.png';
?>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($user_data['UserName']); ?></h1>
    <ul>
        <li><?php echo 'Inset Title'; ?></li>
        <li><?php echo 'IMG'; ?></li>
        <li><?php echo 'Add to cart'; ?></li>
    </ul>

    <?php include("./view/footer.php"); ?>
</body>


</html>