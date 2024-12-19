<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM note where note_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: tintuc.php");
