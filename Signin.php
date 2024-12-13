<!--
Add a wrapper element with .form-group, around each form control, 
to ensure proper margins
-->
<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<body>
    <?php include('./view/header.php'); ?>
    <h1><?php echo "Log in" ?></h1>
    <div class="container mt-2">
        <form action="login.php" method="post">
            <table border="0">
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="userName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>
    </div>
    <br>

    <p><?php echo"Hey! you don't have an account! sing in with us"?></p>

    <h1><?php echo "Sing in with us" ?></h1>
    <div class="container mt-2">
        <form action="Signin.php" method="post">
            <table border="0">
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="userName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="name" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" name="lastName" maxlength="255" size="30" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" maxlength="100" size="30" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>
        <br>
    </div>

<!--PHP Part ================================================  -->
        <?php
        // sing in user

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize form inputs
            $uName = $_POST['userName'] ?? null;
            $name = $_POST['name'] ?? null;
            $lname = $_POST['lastName'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if (!$uName || !$name || !$lname || !$email || !$password) {
                echo "You have not entered all the required details.<br />Please go back and try again.";
                exit;
            }

            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Database connection
            include("connection.php");

            // Prepared statement to prevent SQL injection
            $query = "INSERT INTO USERS (UserName, FirstName, LastName, Email, PasswordHash) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('sssss', $uName, $name, $lname, $email, $passwordHash);

            if ($stmt->execute()) {
                echo "User registered successfully!";
            } else {
                echo "An error has occurred. Please try again.";
            }

            $stmt->close();
            $db->close();
        }
        ?>

    <?php include("./view/footer.php"); ?>
</body>
</html>
