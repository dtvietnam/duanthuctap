<?php
$title = "Nhân Viên";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
?>

<?php

$role_id = 2;
$sql2 = "SELECT * FROM customer WHERE role_id = '$role_id'";
$query = mysqli_query($conn, $sql2);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin nhân viên</title>
    <link rel="stylesheet" href="../csspage/manage.css">

</head>

<body>
    <div class="container">

        <div class="sidebar">
            <h2>Quản Lý</h2>
            <ul>
                <?php
                include 'sidebar.php';
                ?>
            </ul>
        </div>

        <div class="main-content">
            <h1 class="h1">Thông Tin Nhân Viên</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Số điện thoại</th>
                        <th>Tên Nhân Viên</th>
                        <th>Địa chỉ</th>
                        <th>point</th>
                        <th>Quản Lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $row['phone_number'] ?></td>
                                <td><?= $row['customer_name'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['point'] ?></td>
                                <td>
                                    <div class="but"></div>
                                    <button class="btn">
                                        <a href="suanv.php?id=<?= $row['customer_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>

                                    <button class="btn">
                                        <a onclick="return Delete('<?= $row['customer_name']; ?>')"
                                            href="xoanv.php?id=<?= $row['customer_id']; ?>"
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
        return confirm("Bạn có chắc muốn xóa nhân viên: " + name + " không?");
    }
</script>

</html>