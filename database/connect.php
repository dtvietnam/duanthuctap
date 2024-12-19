<?php
    $servername = "localhost";
    $username = "root";
    $database = "qlshop";
    $password = "";
    $conn = new mysqli($servername, $username,   $password, $database)
        OR DIE('Không thể kết nối MySQL: ' . mysqli_connect_error());

    mysqli_set_charset($conn, 'UTF8');

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

    