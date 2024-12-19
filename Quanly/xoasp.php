<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM product where product_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: sanpham.php");
