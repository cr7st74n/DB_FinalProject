<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<?php include('./view/header.php'); ?>

<body>
    <?php
    $image_url = './img/yurt-exterior.jpg';
    ?>

    <h1><?php echo 'The Yurts at GroupX’s Resort'; ?></h1>
    <p><?php echo 'Experience rustic luxury in the heart of nature with our unique yurts at GroupX’s Resort. Elevated four feet off the ground, each yurt blends the charm of a camping experience with the comforts of a well-furnished retreat. Our yurts are circular, permanent structures made with sturdy canvas walls, a wooden floor, and an openable roof dome, allowing natural light to filter in and fresh ocean air to flow through. The domed ceiling creates an airy, spacious ambiance, offering a cozy yet expansive feel.'; ?></p>
    <p><?php echo "Inside, you'll find a plush queen-size bed layered with a soft down quilt, perfect for curling up on cool coastal nights. A gas-fired stove keeps you warm and adds to the cozy, rustic charm. Each yurt is equipped with electricity, and you'll have access to running water through a convenient sink right inside your space. For additional facilities, our lodge offers well-appointed shower and restroom amenities nearby."; ?></p>
    <p><?php echo 'Whether you’re lounging on your private deck overlooking the ocean or simply enjoying the peaceful interior of your yurt, this unique lodging option allows you to connect with nature while enjoying a luxurious experience.'; ?></p>

    <img src="<?php echo $image_url; ?>">

    <ul>
        <li><?php echo 'Private Ocean Views: Each yurt is positioned to provide sweeping views of the Atlantic.'; ?></li>
        <li><?php echo 'Comfort and Warmth: Queen-sized bed with down quilt and a gas-fired stove for chilly evenings.'; ?></li>
        <li><?php echo 'Rustic Elegance: Combines the camping vibe with luxurious amenities.'; ?></li>
    </ul>

    <?php include("./view/footer.php"); ?>
</body>


</html>