<!DOCTYPE html>
<html lang="en">
<?php
// Kết nối cơ sở dữ liệu
include '../database/connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../Trang/login.php");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$customer_id = mysqli_real_escape_string($conn, $_SESSION['customer_id']);
$sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
$result = mysqli_query($conn, $sql);

// Kiểm tra nếu có kết quả trả về
if (!$result || mysqli_num_rows($result) === 0) {
    die("Không tìm thấy thông tin khách hàng!");
}

$row = mysqli_fetch_assoc($result);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
    <link rel="stylesheet" href="../csspage/kh.css">
</head>
<?php include '../Thanhgiaodien/header.php'; ?>

<body>
    <div class="dsttkh">
        <li><a href="../Trang/ttkhachhang.php" class="nav-link active">Thông tin khách hàng</a></li>
        <li><a href="../Trang/ddm.php" class="nav-link">Đơn đã mua</a></li>
    </div>
    <div class="ttkh">
        <h1>Thông tin khách hàng</h1>
        <div class="tt">
            <h3>Họ và tên: <?= htmlspecialchars($row['customer_name']); ?></h3>
            <h3>Số điện thoại: <?= htmlspecialchars($row['phone_number']); ?></h3>
            <h3>Địa chỉ: <?= htmlspecialchars($row['address']); ?></h3>
            <h3>Điểm tích lũy: <?= htmlspecialchars($row['point']); ?></h3>
        </div>
        <div class="btk">
            <a href="edit_customer.php?id=<?= $row['customer_id']; ?>" class="btkh" style="text-align: center;">Sửa
                thông tin</a>
        </div>
    </div>
    <div class="bot">
        <?php include '../Thanhgiaodien/footer.php'; ?>
    </div>

    <script>
        const links = document.querySelectorAll('.nav-link');

        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>