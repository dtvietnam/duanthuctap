<!DOCTYPE html>
<html lang="en">
<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
$query1 = "SELECT * FROM type";
$result1 = mysqli_query($conn, $query1);
if (!$result1) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../csspage/home.css">

</head>

<body>

    <div class="container">
        <div class="image-container">
            <img src="../anh/inf.webp" class="home-image">
        </div>

        <div class="description-container">
            <h3>Chào mừng bạn đến với shop thực phẩm rau củ sạch của chúng tôi</h3>
        </div>
    </div>
    <div class="Type">
        <h2></h2>
        <?php include '../Thanhgiaodien/sanphamnoibat.php' ?>
    </div>
    <div class="Type">
        <h2>Loại thực phẩm</h2>
        <?php
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) { ?>
        <div class="Type">
            <ul class="food-list">
                <li>
                    <img src="../anh/<?= $row1['type_img']; ?>" alt="<?= $row1['type_name']; ?>">
                    <a href="../Trang/shop.php?type_id=<?= $row1['type_id']; ?>"><?= $row1['type_name']; ?></a>
                </li>
            </ul>
        </div>
        <?php }
        } else {
            // Nếu không có dữ liệu
            echo "<tr>
                    <td >Không có sản phẩm nào</td>
                    </tr>";
        } ?>
    </div>


    <div class="container">
        <div class="image-container">
            <img src="../anh/contact.jpg" class="home-image">
        </div>
        <div class="description-container">
            <h3>Chào mừng bạn đến với shop thực phẩm rau củ sạch của chúng tôi,với kinh nghiệm mua bán rau củ
                trong
                10
                năm , tận tình chăm sóc và chu đáo với khách hàng</h3>
        </div>
    </div>
</body>
<?php include '../Thanhgiaodien/tintuc.php'; ?>


<?php include '../Thanhgiaodien/footer.php'; ?>


</html>