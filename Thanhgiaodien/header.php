<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../Trang/Home.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <style>

    </style>
    <link rel="stylesheet" href="../csspage/head.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header task">
            <div class="logo">
                <img src="../anh/logodt.png" alt="">
            </div>
            <div class="header list">
                <li><a href="../Trang/home.php">Trang Chủ</a></li>
                <li><a href="../Trang/Shop.php">Shop</a></li>
                <li><a href="../Trang/about.php">About us</a></li>
                <li><a href="../Trang/contact.php">Contact us</a></li>
            </div>
            <div class="header icon">
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="../Trang/ttkhachhang.php"><i class="fas fa-user"></i>
                        <?php echo htmlspecialchars($_SESSION['customer_id']); ?></a>
                    <a href="?logout=true"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="../Trang/login.php"><i class="fas fa-user"></i></a>
                <?php endif; ?>
                <a href="../Trang/shopping.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="../Quanly/nguoidung.php"><i class="fas fa-cog"></i></a>
            </div>
        </div>
    </header>
</body>

</html>