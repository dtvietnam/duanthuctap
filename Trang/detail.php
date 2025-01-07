<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM note WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
    } else {
        echo "Không tìm thấy tin tức!";
        exit;
    }
} else {
    echo "ID tin tức không hợp lệ!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $row['note_name'] ?></title>
</head>

<body>
    <div class="news-detail">
        <h1><?= $row['note_name'] ?></h1>
        <img src="../anh/<?= $row['note_img'] ?>" alt="<?= $row['note_name'] ?>" width="400" height="400">
        <p><?= $row['description'] ?></p>
        <p><?= $row['content'] ?></p>
    </div>
</body>

</html>

<?php include '../Thanhgiaodien/footer.php'; ?>