<?php
$title = "Thống kê doanh thu";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
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
            <h1 style="text-align:center">Thống kê doanh thu</h1>

            <!-- Form lọc theo ngày -->
            <div style="display:flex;justify-content:center;">
                <form action="" method="post" class="form-inline" autocomplete="off">
                    <div class="form-group">
                        <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
                        <div class="input-group">
                            <input id="ngayBatDau"
                                value="<?php echo (isset($_POST['ngayBatDau'])) ? $_POST['ngayBatDau'] : "" ?>"
                                name="ngayBatDau" type="date" class="form-control datepicker" autocomplete="off"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group ml-4">
                        <label for="ngayKetThuc" class="mr-2">Ngày kết thúc:</label>
                        <div class="input-group">
                            <input id="ngayKetThuc"
                                value="<?php echo (isset($_POST['ngayKetThuc'])) ? $_POST['ngayKetThuc'] : "" ?>"
                                name="ngayKetThuc" type="date" class="form-control datepicker" autocomplete="off"
                                required="required">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary ml-4" name="loc">Lọc</button>
                </form>
            </div>

            <?php
            if (isset($_POST["loc"])) {
                // Lấy dữ liệu từ form lọc
                $ngayBatDau = $_POST['ngayBatDau'];
                $ngayKetThuc = $_POST['ngayKetThuc'];

                // Truy vấn doanh thu
                $sql = "SELECT o.oder_id, od.product_id, p.product_name, od.quantity_oder, od.price_oder 
                        FROM oder o
                        INNER JOIN oder_detail od ON o.oder_id = od.oder_id
                        INNER JOIN product p ON od.product_id = p.product_id
                        WHERE o.oder_date BETWEEN '$ngayBatDau' AND '$ngayKetThuc' 
                        AND o.status_id = 4"; // 4 = 'đã giao'

                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    echo "Lỗi truy vấn: " . mysqli_error($conn);
                }
            ?>
                <h3 class="mt-4">Danh sách chi tiết hóa đơn</h3>
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['oder_id'] ?></td>
                                <td><?php echo $row['product_id'] ?></td>
                                <td><?php echo $row['product_name'] ?></td>
                                <td><?php echo $row['quantity_oder'] ?></td>
                                <td><?php echo number_format($row['price_oder']) ?> VNĐ</td>
                                <td>
                                    <?php
                                    $subtotal = $row['price_oder'] * $row['quantity_oder'];
                                    echo number_format($subtotal) . " VNĐ";
                                    $total += $subtotal;
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <h4 class="mt-4">Tổng doanh thu: <?php echo number_format($total) ?> VNĐ</h4>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>