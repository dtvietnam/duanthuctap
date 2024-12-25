<?php
ini_set('session.gc_maxlifetime', 3600); // Thời gian phiên làm việc (1 giờ)
session_start();
ob_start();
include '../database/connect.php';
include '../Thanhgiaodien/header.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int)$_GET['id'];
    unset($_SESSION['giohang'][$id]);
}

// Lấy thông tin khách hàng nếu đã đăng nhập
$customer_info = [
    'name' => '',
    'phone' => '',
    'address' => ''
];

if (isset($_SESSION['phone_number'])) {
    $phone_number = $_SESSION['phone_number'];
    $sql = "SELECT phone_number, customer_name, address FROM customer WHERE phone_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_info = [
            'name' => $row['customer_name'],
            'phone' => $row['phone_number'],
            'address' => $row['address']
        ];
    } else {
        //echo "<script>alert('Không tìm thấy thông tin khách hàng.');</script>";
    }
}

// Hàm lưu chi tiết đơn hàng
function saveOrderDetail($conn, $orderId, $productId, $quantity, $price)
{
    $sql = "INSERT INTO order_detail (product_id, order_id, quantity_order, price_order) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $productId, $orderId, $quantity, $price);
    $stmt->execute();
}

// Xử lý khi đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $address = trim($_POST['address']);
    $description = trim($_POST['description']);
    $giohang = $_SESSION['giohang'];
    $total_price = $_POST['total_price'] ?? 0;

    $phone_number = isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : trim($_POST['phone_number']);
    $phone_number = preg_replace('/^0/', '+84', $phone_number);

    // Kiểm tra khách hàng trong database
    $sql_customer = "SELECT customer_id FROM customer WHERE phone_number = ?";
    $stmt = $conn->prepare($sql_customer);
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer_id = $result->fetch_assoc()['customer_id'];
    } else {
        $sql_insert_customer = "INSERT INTO customer (phone_number, customer_name, address, role_id) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql_insert_customer);
        $stmt->bind_param("sss", $phone_number, $customer_name, $address);
        $stmt->execute();
        $customer_id = $conn->insert_id;
    }

    // Thêm đơn hàng mới
    $sql_order = "INSERT INTO `order` (address, description, customer_id, total_price, status_id) VALUES (?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql_order);
    $stmt->bind_param("ssii", $address, $description, $customer_id, $total_price);
    $stmt->execute();
    $orderId = $conn->insert_id;

    // Lưu chi tiết từng sản phẩm trong giỏ hàng
    foreach ($giohang as $item) {
        saveOrderDetail($conn, $orderId, $item['product_id'], $item['quantity'], $item['price']);
    }

    // Xóa giỏ hàng và chuyển hướng
    unset($_SESSION['giohang']);
    header("Location: ../Quanly/donhang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../csspage/shopping.css">
</head>

<body>
    <div class="container">
        <h2>Danh Sách Mua Sắm</h2>
        <table>
            <thead>
                <tr>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá Thành</th>
                    <th>Số lượng</th>
                    <th>Thành Tiền</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['giohang']) && count($_SESSION['giohang']) > 0): ?>
                    <?php
                    $tong = 0;
                    foreach ($_SESSION['giohang'] as $index => $item):
                        $quantity = isset($_POST['soluong'][$index]) ? (int) $_POST['soluong'][$index] : 1;
                        $thanhtien = $item['price'] * $quantity;
                        $tong += $thanhtien;
                    ?>
                        <tr>
                            <td><img src="../anh/<?= htmlspecialchars($item['img']) ?>" class="product-image" alt="Hình sản phẩm"></td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td class="product-price"><?= number_format($item['price']) ?> VNĐ</td>
                            <td>
                                <div class='quantity-wrapper'>
                                    <button type='button' class='quantity-btn decrease' data-index='<?= $index ?>'>-</button>
                                    <input type="text" class="no-spinners quantity-input" name='soluong[<?= $index ?>]' required value='<?= $quantity ?>'>
                                    <button type='button' class='quantity-btn increase' data-index='<?= $index ?>'>+</button>
                                </div>
                            </td>
                            <td class="item-total-price"><?= number_format($thanhtien) ?> VNĐ</td>
                            <td>
                                <a href="shopping.php?action=delete&id=<?= $index ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Tổng giá trị:</td>
                        <td colspan="2"><span id="total-price"><?= number_format($tong) ?></span> VNĐ</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Giỏ hàng trống</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="checkout-form">
            <form action="" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="customer_name">Họ Và Tên</label><br>
                            <input type="text"
                                id="customer_name"
                                name="customer_name" required
                                placeholder="Họ và tên của bạn"
                                value="<?= isset($customer_info['name']) ? htmlspecialchars($customer_info['name']) : '' ?>"><br>
                        </td>
                        <td>
                            <label for="phone_number">Số Điện Thoại</label><br>
                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                placeholder="Số điện thoại nhận hàng"
                                value="<?= isset($customer_info['phone']) ? htmlspecialchars($customer_info['phone']) : '' ?>"
                                <?= isset($_SESSION['phone_number']) ? 'readonly style="background-color: #e9ecef;"' : 'required' ?>
                                pattern="[0-9]*"
                                maxlength="11">
                            <br>
                        </td>
                        <td>
                            <label for="address">Địa Chỉ Nhận Hàng</label><br>
                            <input type="text"
                                id="address"
                                name="address" required
                                placeholder="Nhập địa chỉ nhận hàng"
                                value="<?= isset($customer_info['address']) ? htmlspecialchars($customer_info['address']) : '' ?>"><br>
                        </td>
                    </tr>
                    <td></td>
                    <td>
                        <label for="description">Ghi chú</label><br>
                        <textarea rows="4" cols="30" id="description" name="description" placeholder="Nhập yêu cầu của bạn"></textarea><br>
                    </td>
                    <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" name="submit" class="checkout-button">Xác nhận mua</button>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="giohang" value='<?= json_encode($_SESSION['giohang']) ?>'>
            </form>
        </div>
    </div>
    <script>
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function(event) {
                // Kiểm tra nếu giá trị không phải là số hoặc nhỏ hơn 1
                if (isNaN(event.target.value) || event.target.value < 1) {
                    alert("Vui lòng nhập một số hợp lệ (lớn hơn hoặc bằng 1).");
                    event.target.value = 1; // Thiết lập lại giá trị mặc định
                }
            });
        });
    </script>
    <script>
        // Cập nhật giá trị trong input khi người dùng nhấn "+" hoặc "-"
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.quantity-wrapper').querySelector('.quantity-input');
                let currentValue = parseInt(input.value);

                if (this.classList.contains('increase')) {
                    currentValue += 1;
                } else if (this.classList.contains('decrease') && currentValue > 1) {
                    currentValue -= 1;
                }

                input.value = currentValue;
                updateItemTotalPrice(this.closest('tr'));
                updateTotalPrice();
            });
        });

        // Cập nhật giá trị thành tiền khi người dùng nhập trực tiếp vào ô input
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function() {
                let currentValue = parseInt(this.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    alert("Vui lòng nhập một số hợp lệ (lớn hơn hoặc bằng 1).");
                    this.value = 1;
                    currentValue = 1;
                }
                updateItemTotalPrice(this.closest('tr'));
                updateTotalPrice();
            });
        });

        // Cập nhật thành tiền của từng sản phẩm
        function updateItemTotalPrice(row) {
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            const price = parseFloat(row.querySelector('.product-price').textContent.replace(' VNĐ', '').replace(',', ''));
            const itemTotal = quantity * price;
            row.querySelector('.item-total-price').textContent = itemTotal.toFixed(0) + ' VNĐ';
        }

        // Cập nhật lại tổng giá trị của giỏ hàng
        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const row = input.closest('tr');
                const price = parseFloat(row.querySelector('.product-price').textContent.replace(' VNĐ', '').replace(',', ''));
                const quantity = parseInt(input.value);
                total += price * quantity;
            });
            document.getElementById('total-price').textContent = total.toFixed(0) + ' VNĐ';
        }

        // Cập nhật thành tiền và tổng giá trị khi trang tải
        document.querySelectorAll('tr').forEach(row => {
            updateItemTotalPrice(row);
        });
        updateTotalPrice(); // Cập nhật tổng giá trị khi trang tải
    </script>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>