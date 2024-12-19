<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<?php
$sql1 = "SELECT *
          FROM `oder_detail`
          JOIN oder ON `oder_detail`.oder_id = oder.oder_id
          JOIN product ON `oder_detail`.product_id = product.product_id
          ";
$query = mysqli_query($conn, $sql1);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin đơn hàng</title>
    <link rel="stylesheet" href="../csspage/manage.css">

</head>

<body>
    <div class="container">

        <div class="sidebar">
            <h2>Quản Lý</h2>
            <ul>
                <li><a href="../Quanly/nguoidung.php">Quản lý người dùng</a></li>
                <li><a href="../Quanly/nhanvien.php">Quản lý nhân viên</a></li>
                <li><a href="../Quanly/sanpham.php">Quản lý sản phẩm</a></li>
                <li><a href="../Quanly/donhang.php">Quản lý đơn hàng</a></li>
                <li><a href="../Quanly/qlslsp.php">Quản lý sl trong đơn hàng</a></li>
                <li><a href="../Quanly/loaisp.php">Quản lý loại sản phẩm</a></li>
                <li><a href="../Quanly/giamgia.php">Quản lý giảm giá</a></li>
                <li><a href="../Quanly/tintuc.php">Quản lý tin tức</a></li>
                <li><a href="../Quanly/slide.php">Quản lý slide</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1 class="h1">Thông Tin Đơn Hàng</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID đơn hàng</th>
                        <th>ID sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng sản phẩm</th>
                        <th>giá thành</th>
                        <th>Quản lý đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {

                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $row['oder_id'] ?></td>
                                <td><?= $row['product_id'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['quantity_oder'] ?></td>
                                <td><?= $row['price_oder'] ?></td>
                                <td>
                                    <button class="btn">
                                        <a href="suahd.php?id=<?= $row['oder_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>

                                    <button class="btn">
                                        <a onclick="return Delete('hóa đơn')" href="xoahd.php?id=<?= $row['oder_id']; ?>"
                                            style="text-decoration:none; color:inherit;">Xóa</a>
                                    </button>
                                </td>
                            </tr>

                    <?php }
                    } else {
                        // Nếu không có dữ liệu
                        echo "<tr>
                    <td colspan='9'>Không có sản phẩm nào</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function Delete(name) {
        return confirm(" Bạn có chắc muốn xóa " + name + " này khô  ng?");
    }
</script>

</html>