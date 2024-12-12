<!--
Add a wrapper element with .form-group, around each form control, 
to ensure proper margins
-->
<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>

<body>
    <?php include('./view/header.php'); ?>
    <div class="container mt-2">
        <form action="Signin.php" method="post">
            <table border="0">
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="userName" maxlength="20" size="20"></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td> <input type="text" name="name" maxlength="30" size="30"></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td> <input type="text" name="lastName" maxlength="60" size="30"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" maxlength="7" size="7"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" maxlength="7" size="7"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>

        <!-- Create the user and insert it to the DB -->
        <?php
            // create short variable names
            $uName=$_POST['userName'];
            $name=$_POST['name'];
            $lname=$_POST['lastName'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            if (!$uName || !$name || !$lname || !$email || !$password) {
                echo "You have not entered all the required details.<br />"
                    . "Please go back and try again.";
                exit;
            }

            if (!get_magic_quotes_gpc()) {
                $uName = addslashes($uName);
                $name = addslashes($name);
                $lname = addslashes($lname);
                $email = doubleval($email);
                $password = doubleval($password);
            }

            @$db = new mysqli('localhost', 'gonzac43_testuser1', 'U^fdh{?}aMkc', 'gonzac43_finalproject');

            if (mysqli_connect_errno()) {
                echo "Error: Could not connect to database.  Please try again later.";
                exit;
            }

            $query = "insert into users values
                ('" . $uName . "', '" . $name . "', '" . $lname . "', '" . $email . "', '" . $password . "')";
            $result = $db->query($query);

            if ($result) {
                echo  $db->affected_rows . " book inserted into database.";
            } else {
                echo "An error has occurred.  The item was not added.";
            }

            $db->close();
        ?>

        </div>
    <?php include("./view/footer.php"); ?>
</body>

</html>