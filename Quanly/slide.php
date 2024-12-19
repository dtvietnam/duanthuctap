<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';

// Fetch slide data
$sql = "SELECT * FROM slide";
$query = mysqli_query($conn, $sql);
if (!$query) {
    die("Lỗi truy vấn: " . mysqli_error($conn)); // Use a more secure error handling in production
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý slide</title>
    <link rel="stylesheet" href="../csspage/manage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        img {
            max-width: 100px;
            max-height: 80px;
            object-fit: cover;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="h2">Thông Tin Slide</h1>
                <a class="btn" href="themslide.php"><i class="fas fa-plus"></i> Thêm slide</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID Slide</th>
                        <th>Ảnh Slide</th>
                        <th>Quản Lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $stt = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= htmlspecialchars($stt++) ?></td>
                                <td><?= htmlspecialchars($row['slide_id']) ?></td>
                                <td>
                                    <img src="../anh/<?= htmlspecialchars($row['slide_img']) ?>" alt="Slide Image">
                                </td>
                                <td>
                                    <a class="btn" href="suaslide.php?id=<?= htmlspecialchars($row['slide_id']) ?>">Sửa</a>
                                    <a class="btn" onclick="return confirmDelete('<?= htmlspecialchars($row['slide_id']) ?>')"
                                        href="xoaslide.php?id=<?= htmlspecialchars($row['slide_id']) ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Không có slide nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(slideId) {
            return confirm("Bạn có chắc muốn xóa slide ID: " + slideId + " không?");
        }
    </script>
</body>

</html>