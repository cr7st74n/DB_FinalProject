<?php

function check_login($con)
{
    if($_SESSION['User_ID']){
        $id = $_SESSION['User_ID'];
        $query = "SELECT * FROM USERS WHERE USER_ID = '$id' LIMIT 1";

        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) >0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    header("Signin.php");
}