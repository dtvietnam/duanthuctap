<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM slide where slide_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: slide.php");
