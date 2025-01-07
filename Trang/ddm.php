<?php

include '../database/connect.php';
$customer_id = intval($_SESSION['customer_id'] ?? 0);
$customer_id = mysqli_real_escape_string($conn, $_SESSION['customer_id']);
$customer_id = intval($customer_id);
if ($customer_id === 0) {
    echo "Không tìm thấy thông tin khách hàng. Vui lòng kiểm tra lại.";
    exit();
}
$sql = "SELECT *
          FROM `oder`
          JOIN customer ON `oder`.customer_id = customer.customer_id
          JOIN status ON `oder`.status_id = status.status_id
          WHERE `oder`.customer_id = $customer_id";
$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Lỗi truy vấn: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng</title>
    <link rel="stylesheet" href="../csspage/kh.css">
</head>
<?php include '../Thanhgiaodien/header.php'; ?>

<body>
    <div class="dsttkh">
        <li><a href="../Trang/ttkhachhang.php">Thông tin khách hàng</a></li>
        <li><a href="../Trang/ddm.php" class="active">Đơn đã mua</a></li>
    </div>
    <div class="bdh">
        <h1>Danh sách đơn hàng của bạn</h1>
        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Đặt Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['oder_id']); ?></td>
                            <td><?= htmlspecialchars(date("d-m-Y H:i:s", strtotime($row['oder_date']))); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td><?= htmlspecialchars(number_format($row['total_price'], 0, ',', '.')); ?> đ</td>
                            <td><?= htmlspecialchars($row['status_name']); ?></td>
                            <td><a href="order_detail.php?order_id=<?= htmlspecialchars($row['oder_id']); ?>"
                                    class="btkh">Xem</a></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='6'>Không có sản phẩm nào</td></tr>";
                } ?>

            </tbody>
        </table>
    </div>
    <div class="bot">
        <?php include '../Thanhgiaodien/footer.php'; ?>
    </div>

    <script>
        document.querySelectorAll('.dsttkh li').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.dsttkh li').forEach(li => li.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>