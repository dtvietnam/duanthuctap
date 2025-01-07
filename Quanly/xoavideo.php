<?php
include '../database/connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM video where video_id = $id";
$query = mysqli_query($conn, $sql);
header("Location: video.php");
