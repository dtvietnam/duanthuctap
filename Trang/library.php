<?php
$title = "Thư viện";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
$sql = "SELECT * FROM video ";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức</title>
    <link rel="stylesheet" href="../csspage/contact.css">
</head>

<body>
    <div>
        <?php
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) { ?>

                <div class="form">
                    <div class="news-item">
                        <div class="anh">
                            <video src="../anh/<?= $row['video_img'] ?>" type="video/mp4" controls alt="Product Image"
                                width="300" height="400">
                        </div>
                        <h2>
                            <td><?= $row['note'] ?></td>
                        </h2>

                    </div>
                </div>
        <?php }
        } ?>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php' ?>