<!DOCTYPE html>
<html lang="en">
<?php
include '../database/connect.php';
$sql = "SELECT * FROM note ";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news</title>
    <link rel="stylesheet" href="../csspage/news.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="news">
            <div class="news-grid">
                <?php
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) { ?>

                <div class="form">
                    <div class="news-item">
                        <div class="anh">
                            <img src="../anh/<?= $row['note_img'] ?>" alt="Product Image" width="300" height="400">
                        </div>
                        <h2>
                            <td><?= $row['note_name'] ?></td>
                        </h2>
                        <p>
                            <td><?= $row['description'] ?></td>
                        </p>
                    </div>
                    <div class="btn">
                        <a class="read-more" href="#">
                            Xem thêm
                        </a>
                    </div>
                </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</body>

</html>