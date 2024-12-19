<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=q, initial-scale=1.0">
    <title>thongtinkhachhang</title>
    <link rel="stylesheet" href="../csspage/kh.css">
</head>
<?php include '../Thanhgiaodien/header.php' ?>

<body>
    <div class="dsttkh">
        <li><a href="../Trang/ttkhachhang.php">Thông tin khách hàng</a></li>
        <li><a href="../Trang/ddm.php">Đơn đã mua</a></li>
    </div>
    <div class="bdh">
        <table>
            <tr>
                <td>STT</td>
                <td>Mã Đơn Hàng </td>
                <td>Ngày Đặt hàng</td>
                <td>Tổng tiền thanh toán</td>
                <td>Chi tiết đơn hàng</td>
            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>23/7.2024</td>
                <td>247.000đ</td>
                <td><button class="btkh">Chi tiết</button></td>
            </tr>
        </table>
    </div>




    <div class="bot">
        <?php include '../Thanhgiaodien/footer.php' ?>
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