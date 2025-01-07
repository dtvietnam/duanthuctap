<!DOCTYPE html>
<html lang="en">
<?php
$title = "Trang chủ";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
$query1 = "SELECT * FROM type";
$result1 = mysqli_query($conn, $query1);
if (!$result1) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
$query2 = "SELECT * FROM slide";
$result2 = mysqli_query($conn, $query2);
if (!$result2) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- <link rel="stylesheet" href="../csspage/home.css"> -->
    <style>
        /* Cài đặt cơ bản */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }

        .container-header {
            margin-top: 10%;
            display: flex;
            text-align: center;
            overflow: hidden;

        }

        .slider {
            position: relative;
        }

        .navigation-slider {
            justify-content: space-between;
            display: flex;
            position: absolute;
            top: 50%;
            transform: translateY(50%) translateX(-50%);
            width: 95%;
            left: 50%;

        }

        .home-image {
            max-width: 100%;

            height: auto;

            transition: ease 0.5s;
        }

        .sanphamnb {
            padding: 20px;
        }

        .container {
            padding: 20px;
            /* Khoảng cách cho toàn bộ container */
        }

        .Type {
            padding: 20px;
            background-color: white;
            border-radius: 8px;

        }

        .Type h2 {
            text-align: center;
            color: rgb(26, 89, 23);
            font-size: 40px;
            font-family: 'Arial', sans-serif;
            margin-bottom: 20px;
        }

        .gl {
            display: flex;
            gap: 40px;
            padding: 20px;
            justify-content: center;
        }

        .food-list {

            border-radius: 15px;
            list-style-type: none;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 10px rgb(124, 131, 124);
        }

        .food-list li {
            margin: 15px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }


        .food-list img {
            width: 220px;
            height: 220px;
            border-radius: 8px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .food-list:hover {
            transform: scale(1.1);
        }

        .food-list img:hover {
            transform: scale(1.1);
        }

        .filter-type {
            display: block;
            margin-top: 10px;
            color: rgb(26, 89, 23);
            text-decoration: none;
            font-size: 25px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .filter-type:hover {
            color: #0056b3;
        }


        /* Kiểu dáng phản hồi */
        @media (max-width: 768px) {
            .description-container h3 {
                font-size: 1.2em;
            }
        }

        @media (max-width: 480px) {
            .description-container h3 {
                font-size: 1em;
            }
        }
    </style>
</head>

<body>

    <div class="slider">
        <div class="container-header">
            <?php
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) { ?>

                    <img src="../anh/<?= htmlspecialchars($row2['slide_img']) ?>" class="home-image">

            <?php }
            } else {
                echo "<p>đang tải...</p>";
            }
            ?>
        </div>
        <div class="navigation-slider">
            <div onclick={prevSlide()} class="prev">
                <svg xmlns="http://www.w3.org/2000/svg" height="32" width="16" viewBox="0 0 256 512">
                    <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#d8dee9"
                        d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z" />
                </svg>
            </div>
            <div onclick={nextSlide()} class="next"> <svg xmlns="http://www.w3.org/2000/svg" height="32" width="16"
                    viewBox="0 0 256 512">
                    <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#d8dee9"
                        d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z" />
                </svg>
            </div>
        </div>

    </div>

    <div class="sanphamnb"><?php include '../Thanhgiaodien/sanphamnoibat.php'; ?></div>
    <div class="Type">
        <h2>Loại thực phẩm</h2>
        <div class="gl">
            <?php
            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)) { ?>
                    <ul class="food-list">
                        <li>
                            <a href='shop.php?type=<?= htmlspecialchars($row1['type_id']); ?>'>
                                <img src="../anh/<?= $row1['type_img']; ?>" alt="<?= htmlspecialchars($row1['type_name']); ?>">
                            </a>
                            <a href='shop.php?type=<?= htmlspecialchars($row1['type_id']); ?>' name="type_products"
                                class='filter-type'><?= htmlspecialchars($row1['type_name']); ?></a>
                        </li>
                    </ul>
            <?php }
            } else {
                // Nếu không có dữ liệu
                echo "<p>Không có sản phẩm nào</p>";
            }
            ?>
        </div>
    </div>
    <script src="../js/handlescript.js"></script>
</body>
<?php include '../Thanhgiaodien/tintuc.php'; ?>
<?php include '../Thanhgiaodien/footer.php'; ?>

</html>