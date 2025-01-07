<?php
$title = "Chi tiết đơn hàng";
include '../database/connect.php';

$oder_id = intval($_GET['id'] ?? 0);

if ($oder_id === 0) {
    echo "Mã đơn hàng không hợp lệ.";
    exit;
}

// Kiểm tra trạng thái hiện tại
$sql_check_order = "SELECT * FROM `oder` WHERE `oder_id` = $oder_id";
$result_check_order = mysqli_query($conn, $sql_check_order);

if (mysqli_num_rows($result_check_order) == 0) {
    echo "Đơn hàng không tồn tại.";
    exit;
}

if (isset($_POST['submit'])) {
    // Lấy trạng thái hiện tại của đơn hàng
    $sql_get_status = "SELECT status_id FROM `oder` WHERE `oder_id` = $oder_id";
    $query_status = mysqli_query($conn, $sql_get_status);
    if ($query_status && $row = mysqli_fetch_assoc($query_status)) {
        $current_status = (int)$row['status_id'];

        // Tăng trạng thái thêm 1
        $new_status = $current_status + 1;

        // Kiểm tra nếu trạng thái mới tồn tại trong bảng `status`
        $sql_check_status = "SELECT COUNT(*) as count FROM `status` WHERE `status_id` = $new_status";
        $query_check_status = mysqli_query($conn, $sql_check_status);
        $status_exists = mysqli_fetch_assoc($query_check_status)['count'] ?? 0;

        if ($status_exists > 0) {
            // Cập nhật trạng thái đơn hàng
            $update_sql = "UPDATE `oder` SET `status_id` = $new_status WHERE `oder_id` = $oder_id";
            $update_query = mysqli_query($conn, $update_sql);

            if ($update_query) {
                echo "<script>alert('Trạng thái đơn hàng đã được cập nhật thành công!');</script>";
                echo "<script>window.location.href = 'donhang.php';</script>";
            } else {
                echo "Có lỗi xảy ra khi cập nhật trạng thái: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Không thể cập nhật trạng thái vì trạng thái mới không hợp lệ!');</script>";
            echo "<script>window.location.href = 'donhang.php';</script>";
        }
    } else {
        echo "Không thể lấy trạng thái hiện tại của đơn hàng: " . mysqli_error($conn);
    }
}
// Truy vấn thông tin chi tiết đơn hàng
$sql = "SELECT 
    o.oder_id,
    o.oder_date,
    o.address AS order_address,
    o.total_price,
    c.customer_name,
    c.phone_number,
    c.address AS customer_address,
    st.status_name
FROM 
    `oder` o
INNER JOIN 
    `customer` c ON o.customer_id = c.customer_id
INNER JOIN 
    `status` st ON o.status_id = st.status_id
WHERE 
    o.oder_id = $oder_id";

$query = mysqli_query($conn, $sql);
$order_info = mysqli_fetch_assoc($query);

$sql_product = "SELECT 
    p.product_name, 
    od.quantity_oder, 
    od.price_oder
FROM 
    oder_detail od
INNER JOIN 
    product p ON od.product_id = p.product_id
WHERE 
    od.oder_id = $oder_id";

$query1 = mysqli_query($conn, $sql_product);
?>

<div>
    <h2>Chi tiết đơn hàng</h2>
    <p>Mã Hóa Đơn: <?= $order_info['oder_id'] ?></p>
    <p>Tên người nhận: <?= $order_info['customer_name'] ?></p>
    <p>Địa chỉ giao hàng: <?= $order_info['order_address'] ?></p>
    <p>Trạng thái đơn hàng: <?= $order_info['status_name'] ?></p>
</div>
<table>
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($query1)) { ?>
            <tr>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['quantity_oder'] ?></td>
                <td><?= number_format($row['price_oder'], 0, ',', '.') ?> VND</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<form method="POST" action="">
    <input type="hidden" name="oder_id" value="<?= $oder_id ?>">
    <button type="submit" name="submit">Xác nhận đơn hàng</button>
</form>