<?php
    @$db = new mysqli('localhost', 'gonzac43_testuser1', 'U^fdh{?}aMkc', 'gonzac43_finalproject');

    if ($db->connect_error) {
        echo "Error: Could not connect to database. Please try again later.";
        exit;
    }
?>