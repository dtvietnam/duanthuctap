<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thongtinkhachhang</title>
    <link rel="stylesheet" href="../csspage/kh.css">
</head>
<?php include '../Thanhgiaodien/header.php' ?>

<body>
    <div class="dsttkh">
        <li><a href="../Trang/ttkhachhang.php" class="nav-link">Thông tin khách hàng</a></li>
        <li><a href="../Trang/ddm.php" class="nav-link">Đơn đã mua</a></li>
    </div>
    <div class="ttkh">
        <h1>Thông tin khách hàng</h1>
        <div class="tt">
            <h3>Họ và tên - <?php echo "Trương Văn Thọ" ?> </h3>
            <h3>Tên đăng nhập - <?php echo "tho123" ?></h3>
            <h3>Mật khẩu - <?php echo "123456" ?></h3>
            <h3>Số điện thoại - <?php echo "0901234567" ?></h3>
            <h3>email - <?php echo "tho123@gmail.com" ?></h3>
        </div>
        <div class="btk">
            <button class="btkh"> Sửa thông tin người dùng</button>
        </div>
    </div>
    <div class="bot">
        <?php include '../Thanhgiaodien/footer.php' ?>
    </div>

    <script>
        const links = document.querySelectorAll('.nav-link');

        links.forEach(link => {
            link.addEventListener('click', function () {

                links.forEach(l => l.classList.remove('active'));

                this.classList.add('active');
            });
        });
    </script>
</body>

</html>