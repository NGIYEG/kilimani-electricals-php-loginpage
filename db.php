<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'kilielectronics';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die('Could not connect to MySQL server: ' . mysqli_connect_error());
    }
?>
