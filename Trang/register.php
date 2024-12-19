<?php
require '../database/connect.php';

if (isset($_GET['phone'])) {
    $_SESSION['phone'] = $_GET['phone'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_SESSION['phone'];
    $gmail = $_POST['gmail'];

    $stmt = $conn->prepare("INSERT INTO customer (customer_name, address, phone, gmail, role_id) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssss", $name, $address, $phone, $gmail);
    $stmt->execute();

    header('Location: shopping.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../csspage/register.css">
</head>
<body>
    <?php include '../Thanhgiaodien/header.php'; ?>
    <div class="main">
        <div class="container">
            <h1>Đăng ký</h1>
            <form action="" method="POST">
                <label for="name">Họ tên:</label>
                <input type="text" id="name" name="name" required>
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" required>
                <label for="gmail">Gmail:</label>
                <input type="email" id="gmail" name="gmail" required>
                <button type="submit">Đăng ký</button>
            </form>
        </div>
    </div>
    <?php include '../Thanhgiaodien/footer.php'; ?>
</body>
</html>
