<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM type where type_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: loaisp.php");
