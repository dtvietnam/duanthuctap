<?php
session_start();
ob_start();
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>giỏ hàng</title>
    <link rel="stylesheet" href="../csspage/shopping.css">

</head>

<body>
    <?php
    if (!isset($_SESSION['giohang']))
        $_SESSION['giohang'] = [];

    // Xóa sản phẩm khỏi giỏ hàng
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $id = (int) $_GET['id'];
        if (isset($_SESSION['giohang'][$id])) {
            unset($_SESSION['giohang'][$id]);
        }
    }
    if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
        $sql = "SELECT `customer_id`, `customer_name`, `address`FROM `customer` WHERE customer_id =  $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $sdt = $row['customer_id'];
            $name = $row['customer_name'];
            $add = $row['address'];
        }
    } else {
        $name = $sdt = $add = '';
    }
    function saveOrderDetail($conn, $orderId, $productId, $quantity, $price)
    {
        $sql = "INSERT INTO `oder_detail` (`product_id`, `oder_id`, `quantity_oder`, `price_oder`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $productId, $orderId, $quantity, $price);
        return $stmt->execute();
    }

    $error_message = [];
    if (isset($_POST['submit'])) {
        // Lấy thông tin từ form
        $customer_name = trim($_POST['customer_name']);
        $address = trim($_POST['address']);
        $description = trim($_POST['dedescription']);
        $giohang = json_decode($_POST['giohang'], true);
        $total_price = $_POST['total_price'] ?? 0;
        if (isset($_SESSION['customer_id'])) {
            $customer_id = $_SESSION['customer_id']; // Using logged-in customer
        } else {
            $customer_id = $_POST['customer_id'];
            $kt_customer = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
            $kt_customer->bind_param("s", $customer_id);
            $kt_customer->execute();
            $kt_result = $kt_customer->get_result();
            if ($kt_result->num_rows === 0) {
                // Insert new customer into the database
                $sql_customer = "INSERT INTO customer (customer_id, customer_name, address, role_id) VALUES (?, ?, ?, 1)";
                $stmt_customer = $conn->prepare($sql_customer);
                $stmt_customer->bind_param("sss", $customer_id, $customer_name, $address);
                $stmt_customer->execute();
                $customer_id = $conn->insert_id; // Get the new customer ID
            }

        }
        $sql_order = "INSERT INTO `oder` (address, description, status_id, customer_id, total_price) 
              VALUES (?, ?, 1, ?, ?)";
        $stmt = $conn->prepare($sql_order);
        $stmt->bind_param("ssii", $address, $description, $customer_id, $total_price);
        $stmt->execute();
        $orderId = $conn->insert_id;

        foreach ($giohang as $item) {
            $price = $item['price'];
            $quantity = isset($_POST['soluong'][$index]) ? (int) $_POST['soluong'][$index] : 1;
            saveOrderDetail($conn, $orderId, $item['product_id'], $quantity, $price);
        }


        // Xóa giỏ hàng sau khi hoàn tất
        unset($_SESSION['giohang']);

        // Chuyển hướng đến trang quản lý đơn hàng
        header("Location: ../Quanly/donhang.php");
        exit();
    }
    // Kiểm tra nếu có thay đổi số lượng từ form
    if (isset($_POST['soluong'])) {
        foreach ($_POST['soluong'] as $index => $quantity) {
            if (isset($_SESSION['giohang'][$index])) {
                // Cập nhật lại số lượng trong giỏ hàng
                $_SESSION['giohang'][$index][4] = $quantity;  // Cập nhật số lượng cho sản phẩm tại index
            }
        }
    }
    ?>

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
                <?php if (isset($_SESSION['giohang']) && count($_SESSION['giohang']) > 0):
                    $tong = 0; // Khởi tạo tổng giá trị
                    foreach ($_SESSION['giohang'] as $index => $item):
                        $quantity = isset($_POST['soluong'][$index]) ? (int) $_POST['soluong'][$index] : 1;
                        $thanhtien = $item['price'] * $quantity; // Tính thành tiền
                        $tong += $thanhtien; // Cộng dồn vào tổng giá trị
                        ?>
                        <tr>
                            <td><img src="../anh/<?= htmlspecialchars($item['img']) ?>" class="product-image" alt="Hình sản phẩm">
                            </td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td class="product-price"><?= number_format($item['price']) ?> VNĐ</td>
                            <td>
                                <div class='quantity-wrapper'>
                                    <button type='button' class='quantity-btn decrease' data-index='<?= $index ?>'>-</button>
                                    <input type='number' class="no-spinners quantity-input" name='soluong[<?= $index ?>]'
                                        min="1" step="1" value='<?= $quantity ?>'>
                                    <button type='button' class='quantity-btn increase' data-index='<?= $index ?>'>+</button>
                                </div>
                            </td>
                            <td class="item-total-price"><?= number_format($thanhtien) ?> VNĐ</td>

                            <td>
                                <a href="shopping.php?action=delete&id=<?= $index ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Tổng giá trị:</td>
                        <td colspan="2"><span id="total-price" name="total_price"><?= isset($tong) ? $tong : 0 ?></span>VND
                        </td>
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
                            <div> <label for="customer_name">Họ Và Tên</label><br>
                                <input type="text" id="customer_name" name="customer_name" required
                                    placeholder="Họ và tên của bạn" value="<?= $name ?>"><br>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="customer_id">Số Điện Thoại</label><br>
                                <input type="text" id="customer_id" name="customer_id" required
                                    placeholder="Số điện thoại nhận hàng" value="<?= $sdt ?>"><br>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="address">Địa Chỉ Nhận Hàng</label><br>
                                <input type="text" id="address" name="address" required
                                    placeholder="Nhập địa chỉ nhận hàng" value="<?= $add ?>"><br>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div>
                                <label for="description">Ghi chú</label><br>
                                <textarea rows="4" cols="30" id="dedescription" name="dedescription"
                                    placeholder="Nhập yêu cầu của bạn"></textarea><br>
                            </div>
                        </td>
                        <td>

                        </td>
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
</body>
<script>
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function (event) {
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
        button.addEventListener('click', function () {
            const input = this.closest('.quantity-wrapper').querySelector('.quantity-input');
            let currentValue = parseInt(input.value);

            if (this.classList.contains('increase')) {
                currentValue += 1; // Tăng số lượng
            } else if (this.classList.contains('decrease') && currentValue > 1) {
                currentValue -= 1; // Giảm số lượng, không thấp hơn 1
            }

            input.value = currentValue;

            // Cập nhật lại giá trị thành tiền của sản phẩm
            updateItemTotalPrice(this.closest('tr'));

            // Cập nhật lại tổng giá trị của giỏ hàng
            updateTotalPrice();
        });
    });

    // Cập nhật giá trị thành tiền khi người dùng nhập trực tiếp vào ô input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function () {
            let currentValue = parseInt(this.value);

            // Kiểm tra nếu giá trị không phải là số hoặc nhỏ hơn 1
            if (isNaN(currentValue) || currentValue < 1) {
                alert("Vui lòng nhập một số hợp lệ (lớn hơn hoặc bằng 1).");
                this.value = 1; // Thiết lập lại giá trị mặc định nếu không hợp lệ
                currentValue = 1;
            }

            // Cập nhật lại giá trị thành tiền của sản phẩm
            updateItemTotalPrice(this.closest('tr'));

            // Cập nhật lại tổng giá trị của giỏ hàng
            updateTotalPrice();
        });
    });

    // Cập nhật thành tiền của từng sản phẩm
    function updateItemTotalPrice(row) {
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const price = parseFloat(row.querySelector('.product-price').textContent.replace(' VNĐ', '').replace(',', ''));
        const itemTotal = quantity * price;

        row.querySelector('.item-total-price').textContent = itemTotal.toFixed(0) + ' VNĐ'; // Cập nhật thành tiền
    }

    // Cập nhật lại tổng giá trị của giỏ hàng
    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('.product-price').textContent.replace(' VNĐ', '').replace(
                ',', ''));
            const quantity = parseInt(input.value);
            total += price * quantity;
        });
        document.getElementById('total-price').textContent = total.toFixed(0) + ' VNĐ'; // Cập nhật tổng giá trị
    }

    // Cập nhật thành tiền và tổng giá trị khi trang tải
    document.querySelectorAll('tr').forEach(row => {
        updateItemTotalPrice(row); // Cập nhật thành tiền của từng sản phẩm
    });
    updateTotalPrice(); // Cập nhật tổng giá trị khi trang tải
</script>



</html>
<?php include '../Thanhgiaodien/footer.php'; ?>