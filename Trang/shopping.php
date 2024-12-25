<?php
ob_start();
include '../database/connect.php';
// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['giohang'][$product_id])) {
        $_SESSION['giohang'][$product_id]['quantity'] = $quantity;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Thêm sản phẩm vào giỏ hàng thành công!'
    ]);
    exit();
}

if (!isset($_SESSION['giohang']))
    $_SESSION['giohang'] = [];

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int) $_GET['id'];
    if (isset($_SESSION['giohang'][$id])) {
        unset($_SESSION['giohang'][$id]);
    }
}
if (isset($_SESSION['phone_number'])) {
    $id = $_SESSION['phone_number'];
    $sql = "SELECT `phone_number`, `customer_name`, `address`FROM `customer` WHERE phone_number =  $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $sdt = $row['phone_number'];
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
$customer_id = null;
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form
    $customer_name = trim($_POST['customer_name']);
    $address = trim($_POST['address']);
    $description = trim($_POST['dedescription']);
    $giohang = json_decode($_POST['giohang'], true);
    // Tính lại tổng giá trị trên server để đảm bảo tính chính xác
    $total_price = 0;
    foreach ($giohang as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
    if (isset($_SESSION['phone_number'])) {
        $phone_number = $_SESSION['phone_number']; // Using logged-in customer
        $phone_number = preg_replace('/^0/', '+84', $phone_number);

        $kt_customer = $conn->prepare("SELECT `customer_id` FROM `customer` WHERE phone_number= ?");
        $kt_customer->bind_param("s", $phone_number);
        $kt_customer->execute();
        $kt_result = $kt_customer->get_result();
        if ($kt_result->num_rows > 0) {
            $customer = $kt_result->fetch_assoc();
            $customer_id = $customer['customer_id'];
        }
    } else {
        $phone_number = $_POST['phone_number'];
        $phone_number = preg_replace('/^0/', '+84', $phone_number);

        $kt_customer = $conn->prepare("SELECT `customer_id` FROM `customer` WHERE phone_number= ?");
        $kt_customer->bind_param("s", $phone_number);
        $kt_customer->execute();
        $kt_result = $kt_customer->get_result();
        if ($kt_result->num_rows > 0) {
            $customer = $kt_result->fetch_assoc();
            $customer_id = $customer['customer_id'];
        } else {
            // Nếu không tồn tại, thêm mới khách hàng
            $sql_customer = "INSERT INTO customer (phone_number, customer_name, address, role_id) VALUES (?, ?, ?, 1)";
            $stmt_customer = $conn->prepare($sql_customer);
            $stmt_customer->bind_param("sss", $phone_number, $customer_name, $address);
            $stmt_customer->execute();
            $customer_id = $conn->insert_id;
        }

    }
    echo $customer_id;
    $sql_order = "INSERT INTO `oder` (address, description, customer_id, total_price, status_id) 
        VALUES (?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql_order);
    $stmt->bind_param("ssii", $address, $description, $customer_id, $total_price);
    $stmt->execute();
    $orderId = $conn->insert_id;

    foreach ($giohang as $item) {
        $price = $item['price'];
        $quantity = $item['quantity'];
        saveOrderDetail($conn, $orderId, $item['product_id'], $quantity, $price);
    }


    // Xóa giỏ hàng sau khi hoàn tất
    unset($_SESSION['giohang']);

    // Chuyển hướng đến trang quản lý đơn hàng
    header("Location: ../Quanly/donhang.php");
    exit();
}
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

    <?php include '../Thanhgiaodien/header.php'; ?>
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
                    $total_price = 0; // Khởi tạo tổng giá trị
                    foreach ($_SESSION['giohang'] as $index => $item):
                        $quantity = $item['quantity'];
                        $thanhtien = $item['price'] * $quantity; // Tính thành tiền
                        $total_price += $thanhtien; // Cộng dồn vào tổng giá trị
                        ?>
                        <tr>
                            <td><img src="../anh/<?= htmlspecialchars($item['img']) ?>" class="product-image"
                                    alt="Hình sản phẩm">
                            </td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td class="product-price"><?= number_format($item['price']) ?> VNĐ</td>
                            <td>
                                <div class='quantity-wrapper'>
                                    <button type='button' class='quantity-btn decrease' data-index='<?= $index ?>'>-</button>
                                    <input type="text" class="no-spinners quantity-input" name='soluong[<?= $index ?>]'
                                        data-product-id="<?= htmlspecialchars($item['product_id']) ?>"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" min="1"
                                        value='<?= $quantity ?>'>
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
                        <td colspan="2"><span id="total-price"
                                name="total_price"><?= isset($total_price) ? $total_price : 0 ?></span>VND
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
                                <label for="phone_number">Số Điện Thoại</label><br>
                                <input type="text" id="phone_number" name="phone_number" required
                                    placeholder="Số điện thoại nhận hàng" value="<?= $sdt ?>" pattern="[0-9]*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="11"><br>
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

            // Cập nhật lại số lượng trên session
            updateItemQuantity(this.closest('tr'));


            // Cập nhật lại tổng giá trị của giỏ hàng
            updateTotalPrice();
        });
    });
    // Cập nhật giá trị trong input khi người dùng nhập trực tiếp vào ô input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function () {
            let currentValue = parseInt(this.value);

            // Kiểm tra nếu giá trị không phải là số hoặc nhỏ hơn 1
            if (isNaN(currentValue) || currentValue < 1) {
                alert("Vui lòng nhập một số hợp lệ (lớn hơn hoặc bằng 1).");
                this.value = 1; // Thiết lập lại giá trị mặc định
                currentValue = 1;
            }

            // Cập nhật lại giá trị thành tiền của sản phẩm
            updateItemTotalPrice(this.closest('tr'));

            // Cập nhật lại số lượng trên session
            updateItemQuantity(this.closest('tr'));

            // Cập nhật lại tổng giá trị của giỏ hàng
            updateTotalPrice();
        });
    });

    function updateItemQuantity(row) {
        const productId = row.querySelector('.quantity-input').getAttribute('data-product-id');
        const quantity = parseInt(row.querySelector('.quantity-input').value);

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch('shopping.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                } else {
                    console.error(data.message || 'Cập nhật thất bại!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi. Vui lòng thử lại!');
            });
    }

    function updateItemTotalPrice(row) {
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const price = parseFloat(row.querySelector('.product-price').textContent.replace(' VNĐ', '').replace(',', ''));
        const itemTotal = quantity * price;

        row.querySelector('.item-total-price').textContent = itemTotal.toFixed(0) + ' VNĐ';
    }

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
</script>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>