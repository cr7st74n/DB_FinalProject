<?php
    $host = "localhost";
    $db_user = "gonzac43_testuser1";
    $db_password = "U^fdh{?}aMkc";
    $db_name = "gonzac43_finalproject";

    @$con = new mysqli($host, $db_user, $db_password, $db_name);

    if ($con->connect_error) {
        die("Database connection failed: " . $con->connect_error);
    }
?>