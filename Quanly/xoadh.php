<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM oder where oder_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: donhang.php");
