<?php
$title = "Video";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
?>

<?php
$sql = "SELECT * FROM video ";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức công ty</title>
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
            <table>
                <tr>
                    <td colspan="4">
                        <h1 class="h2">Thông Tin video</h1>
                    </td>

                    <td colspan="2">
                        <a class="btn" href="themvideo.php"><i class="fas fa-plus"></i> Thêm video</a>
                    </td>
                </tr>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID video</th>
                        <th>Tiêu đề video</th>
                        <th>Video</th>
                        <th>Quản Lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $row['video_id'] ?></td>
                                <td><?= $row['note'] ?></td>
                                <td><video src="../anh/<?= $row['video_img'] ?>" type="video/mp4" autoplay="autoplay" controls
                                        alt="Product Image" width="100" height="100"></video>
                                </td>
                                <td>
                                    <div class="but"></div>
                                    <button class="btn">
                                        <a href="suavideo.php?id=<?= $row['video_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>

                                    <button class="btn">
                                        <a onclick="return Delete(name)" href="xoavideo.php?id=<?= $row['video_id']; ?>"
                                            style="text-decoration:none; color:inherit;">Xóa</a>
                                    </button>

                                </td>
                            </tr>
                    <?php }
                    } else {
                        // Nếu không có dữ liệu
                        echo "<tr>
                    <td colspan='6'>Không có sản phẩm nào</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function Delete(name) {
        return confirm("Bạn có chắc muốn xóa video này không?");
    }
</script>

</html>