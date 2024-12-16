<?php
session_start();
include("connection.php");
include("functions.php");

check_login($con);
$user_data = fetch_user_data($con);
$user_id = $_SESSION['user_id'];

$is_editing = isset($_GET['edit']) && $_GET['edit'] === 'true';

// Update Profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];

    $query = "UPDATE USERS SET FirstName = ?, LastName = ?, Email = ? WHERE User_ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssi', $firstName, $lastName, $email, $user_id);
    $stmt->execute();
    header("Location: profile.php");
    exit;
}

// Fetch Or history
$order_query = "SELECT O.Order_ID, O.OrderDate, O.TotalAmount, SA.ADDRESS_LINE1, SA.CITY, SA.STATE, SA.ZIP_CODE, SA.COUNTRY 
                FROM ORDERS O
                LEFT JOIN SHIPPING_ADDRESS SA ON SA.USER_ID = O.User_ID
                WHERE O.User_ID = ?";
$stmt = $con->prepare($order_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<?php include("./view/head.php"); ?>
<body>
<?php include('./view/header.php'); ?>

<div class="container mt-4">
    <h1>Welcome, <?php echo htmlspecialchars($user_data['UserName']); ?></h1>
    
    <!-- User Profile Section ======================================================================-->
    <h3>Your Profile</h3>
    <?php if ($is_editing): ?>
        <form method="post" action="profile.php">
            <div class="mb-3">
                <label for="FirstName" class="form-label">First Name</label>
                <input type="text" id="FirstName" name="FirstName" class="form-control" 
                       value="<?php echo htmlspecialchars($user_data['FirstName']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="LastName" class="form-label">Last Name</label>
                <input type="text" id="LastName" name="LastName" class="form-control" 
                       value="<?php echo htmlspecialchars($user_data['LastName']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email</label>
                <input type="email" id="Email" name="Email" class="form-control" 
                       value="<?php echo htmlspecialchars($user_data['Email']); ?>" required>
            </div>
            <button type="submit" name="update_profile" class="btn btn-success">Save Changes</button>
            <a href="profile.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php else: ?>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($user_data['FirstName']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user_data['LastName']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['Email']); ?></p>
        <a href="profile.php?edit=true" class="btn btn-primary">Edit Profile</a>
    <?php endif; ?>

    <!-- Order History Section =================================================================-->
    <h3 class="mt-4">Order History</h3>
    <?php if ($orders->num_rows > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Shipping Address</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['Order_ID']; ?></td>
                        <td><?php echo $order['OrderDate']; ?></td>
                        <td>$<?php echo number_format($order['TotalAmount'], 2); ?></td>
                        <td>
                            <?php echo htmlspecialchars($order['ADDRESS_LINE1']) . ", " . 
                                       htmlspecialchars($order['CITY']) . ", " . 
                                       htmlspecialchars($order['STATE']) . " " . 
                                       htmlspecialchars($order['ZIP_CODE']) . ", " . 
                                       htmlspecialchars($order['COUNTRY']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no orders yet.</p>
    <?php endif; ?>
</div>

<?php include("./view/footer.php"); ?>
</body>
</html>
