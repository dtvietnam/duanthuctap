<?php
require_once '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $phone = $_POST['phone'];
    $normalizedPhone = preg_replace('/^0/', '+84', $phone);
    
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Số điện thoại không tồn tại, chuyển hướng đến trang đăng ký
        header("Location: register.php?phone=" . $phone);
        exit();
    } else {
        $account = $result->fetch_assoc();
        session_start();
        $_SESSION['customer_id'] = $account['customer_id'];
        if ($account['role_id'] == 2) {
            header("Location: ../Quanly/sanpham.php");
        } else {
            header("Location: Home.php");
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../csspage/login.css">
</head>
<body>
    <?php include '../Thanhgiaodien/header.php'; ?>
    <div class="bm">
        <div class="amh">
            <img src="../anh/logodt.png" alt="Logo">
        </div>
        <div class="container">
            <h2>Đăng nhập</h2>
            <form action="" method="POST">
                <div class="number-input">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" required>
                    <button id="sendOtpBtn" type="button">Xác nhận số điện thoại</button>
                </div>
                <div class="otp-verification" style="display: none;">
                    <input type="text" id="verificationCode" placeholder="OTP Code" required>
                    <button id="verifyOtpBtn" type="button">Xác nhận OTP</button>
                    <p id="otpErrorMessage" style="color: red; display: none;">Lỗi. Hãy thử lại.</p>
                </div>
                <div class="form-actions">
                    <a href="../Trang/home.php">Trang chủ</a>
                    <button id="loginBtn" type="submit" name="login" style="display: none;">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
    <?php include '../Thanhgiaodien/footer.php'; ?>
    <script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
