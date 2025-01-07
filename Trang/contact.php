<?php
$title = "Tin tức";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';

// Truy vấn lấy danh sách tin tức
$sql = "SELECT * FROM note";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}

// Truy vấn lấy thông tin mới nhất
$sql_latest = "SELECT * FROM note ORDER BY note_id  DESC LIMIT 1";
$query_latest = mysqli_query($conn, $sql_latest);
$latest = mysqli_fetch_assoc($query_latest);
if (!$query_latest) {
    die("Lỗi truy vấn lấy tin tức nổi bật: " . mysqli_error($conn));
}
$sql_product = "SELECT * FROM product ORDER BY product_id DESC LIMIT 1";
$query_product = mysqli_query($conn, $sql_product);
$product = mysqli_fetch_assoc($query_product);
if (!$query_product) {
    die("Lỗi truy vấn lấy sản phẩm nổi bật: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: white;
        }

        .sidebar {
            position: fixed;
            top: 120px;
            width: 25%;
            max-height: 80vh;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        .content {
            position: fixed;
            width: 75%;
            padding: 20px;
            box-sizing: border-box;
            top: 120px;
            left: 25%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .content::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        .sidebar .section {
            margin-bottom: 20px;
        }

        .sidebar .section h2 {
            background-color: #007b00;
            color: white;
            padding: 10px;
            margin: 0;
            text-align: center;
        }

        .sidebar .section img {
            width: 100%;
            display: block;
            height: auto;
        }

        .sidebar .section p {
            text-align: center;
            margin: 10px 0 0 0;
        }

        .content h2 {
            color: #007b00;
            margin: 0 0 20px 0;
            text-align: center;
        }

        .news-item {
            display: flex;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .news-item img {
            width: 200px;
            height: 200px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .news-item .details {
            flex: 1;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            flex-direction: column;
        }

        .news-item .details h3 {
            margin: 0 0 10px 0;
            color: #007b00;
        }

        .news-item .details p {
            margin: 0 0 10px 0;
            color: #333333;
        }

        .news-item .details a {
            color: #007b00;
            text-decoration: none;
            font-weight: bold;
        }

        .news-item .details a:hover {
            text-decoration: underline;
        }

        .news-item p:hover {
            overflow-y: auto;
            white-space: normal;
            max-height: 150px;
        }

        @media (max-width: 768px) {

            .sidebar,
            .content {
                width: 100%;
            }

            .news-item {
                flex-direction: column;
            }

            .news-item img {
                margin: 0 0 10px 0;
                width: 100%;
            }

        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="section">
            <h2>DANH MỤC SẢN PHẨM</h2>
        </div>
        <div class="section">
            <h2>SẢN PHẨM MỚI NHẤT</h2>
            <img alt="Highlighted information image" src="../anh/<?= $product['img'] ?>" />
            <p><?= $product['product_name'] ?></p>
        </div>

        <div class="section">
            <h2>THÔNG TIN NỔI BẬT</h2>
            <img alt="Highlighted information image" src="../anh/<?= $latest['note_img'] ?>" />
            <p><?= $latest['note_name'] ?></p>

        </div>
    </div>

    <div class="content">
        <h2>Tin tức</h2>
        <?php
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) { ?>
                <div class="news-item">
                    <img src="../anh/<?= $row['note_img'] ?>" alt="News Image">
                    <div class="details">
                        <h3><?= $row['note_name'] ?></h3>
                        <p><?= $row['description'] ?></p>
                        <a href="#">» Xem chi tiết</a>
                    </div>
                </div>
        <?php }
        } ?>
    </div>


</body>

</html>