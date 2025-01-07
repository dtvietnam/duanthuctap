<!DOCTYPE html>
<html lang="en">
<?php
include '../database/connect.php';
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../Trang/Home.php");
    exit();
}
$sql = "SELECT * FROM customer";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (isset($_SESSION['customer_id'])) {
    $customer_id = mysqli_real_escape_string($conn, $_SESSION['customer_id']);
    $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra nếu có kết quả trả về
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $role_id = $row['role_id']; // Lấy giá trị role_id
    } else {
        die('User not found!');
    }
}
?>

<head>
    <link rel="shortcut icon" href="../anh/logodt.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>

    </style>
    <link rel="stylesheet" href="../csspage/head.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .cart {
            display: flex;
        }

        .cart-number {
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            margin-left: -10px;
            margin-top: -10px;
        }
    </style>
</head>

<body>
    <?php
    $total_items_in_cart = 0; // Biến đếm số lượng sản phẩm
    if (isset($_SESSION['giohang'])) {
        foreach ($_SESSION['giohang'] as $item) {
            $total_items_in_cart += $item['quantity']; // Tăng số lượng từng sản phẩm
        }
    }

    ?>

    <header>
        <div class="header task">
            <div class="logo">
                <img src="../anh/logodt.png" alt="">
            </div>
            <div class="header list">
                <li><a href="../Trang/home.php">Trang Chủ</a></li>
                <li><a href="../Trang/Shop.php">Shop</a></li>
                <li><a href="../Trang/contact.php">Tin Tức</a></li>
                <li><a href="../Trang/library.php">Thư Viện</a></li>
            </div>
            <div class="header icon">
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="../Trang/ttkhachhang.php?id=<?= $row['customer_id']; ?>"><i class="fa-brands fa-bitcoin"></i>
                        <?php echo htmlspecialchars($row['point']); ?></a>
                    <a href="../Trang/ttkhachhang.php?id=<?= $row['customer_id']; ?>"><i class="fas fa-user"></i>
                        <?php echo  '***' . htmlspecialchars(substr($_SESSION['phone_number'], -5)); ?>
                        <a href="?logout=true"><i class="fas fa-sign-out-alt"></i></a>
                    <?php else: ?>
                        <a href="../Trang/login.php"><i class="fas fa-user"></i></a>
                    <?php endif; ?>

                    <div class="cart">
                        <a href="../Trang/shopping.php"><i class="fas fa-shopping-cart"></i></a>
                        <?php if ($total_items_in_cart > 0): ?>
                            <div class="cart-number">
                                <p><?php echo $total_items_in_cart; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($role_id) && $role_id == 2): ?>
                        <a href="../Quanly/nguoidung.php"><i class="fas fa-cog"></i></a>
                    <?php endif; ?>
            </div>
        </div>
    </header>
    <script>


    </script>
</body>

</html>