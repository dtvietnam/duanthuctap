<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM saleoff where saleoff_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: giamgia.php");
