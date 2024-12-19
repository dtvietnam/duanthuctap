<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
$query = "SELECT * FROM type";
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
if (isset($_POST['add_type'])) {
    $type = $_POST['type'];
    $sql = "INSERT INTO type (type_name) VALUES ('$type')";
    $add = mysqli_query($conn, $sql);
}
$result = mysqli_query($conn, $query);
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
                <li><a href="../Quanly/loaisp.php">Quản lý loại sản phẩm</a></li>
                <li><a href="../Quanly/giamgia.php">Quản lý giảm giá</a></li>
                <li><a href="../Quanly/tintuc.php">Quản lý tin tức</a></li>
                <li><a href="../Quanly/slide.php">Quản lý slide</a></li>
            </ul>
        </div>
        <div class="main-content">
            <table>
                <tr>
                    <td colspan="4">
                        <h1 class="h2">Thông Tin loại sản phẩm</h1>
                    </td>

                    <td colspan="2">
                        <a class="btn" href="themlsp.php"><i class="fas fa-plus"></i> Thêm loại sản phẩm</a>
                    </td>
                </tr>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Id loại sản phẩm</th>
                        <th>Tên loại sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $row['type_id'] ?></td>
                                <td><?= $row['type_name'] ?></td>
                                <td><img src="../anh/<?= $row['type_img'] ?>" alt="Product Image" width="80" height="80"></td>
                                <td>
                                    <button class="btn">
                                        <a href="sualoaisp.php?id=<?= $row['type_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>

                                    <button class="btn">
                                        <a onclick="return Delete('<?= $row['type_name']; ?>')"
                                            href="xoaloaisp.php?id=<?= $row['type_id']; ?>"
                                            style="text-decoration:none; color:inherit;">Xóa</a>
                                    </button>
                                </td>
                            </tr>

                    <?php }
                    } else {
                        // Nếu không có dữ liệu
                        echo "<tr>
                    <td colspan='5'>Không có sản phẩm nào</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function Delete(name) {
        return confirm(" Bạn có chắc muốn xóa người dùng: " + name + " không?");
    }
</script>

</html>