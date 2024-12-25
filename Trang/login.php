<?php
session_start();
require_once '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Lấy số điện thoại từ form
    $phone = $_POST['phone'];

    // Chuẩn hóa số điện thoại cho Firebase (chuyển 0 đầu thành +84)
    $normalizedPhoneForFirebase = preg_replace('/^0/', '+84', $phone);

    // Lưu số điện thoại gốc vào cơ sở dữ liệu
    $normalizedPhoneForDatabase = $phone;

    // Kiểm tra số điện thoại trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM customer WHERE phone_number = ?");
    $stmt->bind_param("s", $normalizedPhoneForDatabase); // Dùng số điện thoại gốc để kiểm tra
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Số điện thoại không tồn tại, thêm mới vào cơ sở dữ liệu
        $sql_customer = "INSERT INTO customer (phone_number, role_id) VALUES (?, 1)";
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("s", $normalizedPhoneForDatabase); // Lưu số điện thoại gốc
        $stmt_customer->execute();

        // Lấy ID khách hàng mới thêm
        $customer_id = $stmt_customer->insert_id;
    } else {
        // Số điện thoại đã tồn tại, lấy thông tin khách hàng
        $account = $result->fetch_assoc();
        $customer_id = $account['customer_id'];
    }

    // Lưu thông tin khách hàng vào session
    $_SESSION['customer_id'] = $customer_id;
    $_SESSION['phone_number'] = $normalizedPhoneForDatabase; // Lưu số điện thoại gốc trong session

    // Chuyển hướng đến trang shopping.php
    header("Location: shopping.php");
    exit();
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