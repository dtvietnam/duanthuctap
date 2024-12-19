<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM customer where customer_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: nguoidung.php");
