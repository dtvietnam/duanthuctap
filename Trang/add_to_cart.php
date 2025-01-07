<?php
require '../database/connect.php';
// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');

    $product_id = isset($_POST['product_id']) ? mysqli_real_escape_string($conn, $_POST['product_id']) : null;
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    if (isset($_SESSION['giohang'][$product_id])) {
        $_SESSION['giohang'][$product_id]['quantity'] = $quantity;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Thêm sản phẩm vào giỏ hàng thành công!'
    ]);
    exit();
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int) $_GET['id'];
    if (isset($_SESSION['giohang'][$id])) {
        unset($_SESSION['giohang'][$id]);
    }
}
if (isset($_SESSION['phone_number'])) {
    $phone_number = mysqli_real_escape_string($conn, $_SESSION['phone_number']);
    $sql = "SELECT * FROM `customer` WHERE  phone_number =  '$phone_number'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $sdt = $phone_number;
        $name = isset($row['customer_name']) ? $row['customer_name'] : null;
        $add = isset($row['address']) ? $row['address'] : null;
        $poin = isset($row['point']) ? $row['point'] : null;
    }
} else {
    $name = $sdt = $add = null;
}

$customer_id = null;
if(isset($_POST['show_modal'])){
    $description = trim($_POST['description']);
    $_SESSION['giohang'][$product_id]['description'] = $description;
}
if (isset($_POST['checkout_button'])) {
    // Lấy thông tin từ form
    $customer_name = trim($_POST['customer_name']);
    $address = trim($_POST['address']);
    
    if (isset($_SESSION['phone_number'])) {
        $phone_number = $_SESSION['phone_number']; // Using logged-in customer
        $kt_customer = $conn->prepare("SELECT `customer_id` FROM `customer` WHERE phone_number= ?");
        $kt_customer->bind_param("s", $phone_number);
        $kt_customer->execute();
        $kt_result = $kt_customer->get_result();
        if ($kt_result->num_rows > 0) {
            $customer = $kt_result->fetch_assoc();
            $customer_id = $customer['customer_id'];
            if($customer_name != null && $address != null ){
            $sql_customer = "UPDATE customer SET customer_name = ?, address = ? WHERE customer_id = ?";
            $stmt_customer = $conn->prepare($sql_customer);
            $stmt_customer->bind_param("ssi",  $customer_name, $address, $customer_id);
            $stmt_customer->execute();
            }
        }

    } else {
        $phone_number = $_POST['phone_number'];
        // Chuẩn hóa số điện thoại cho Firebase (chuyển 0 đầu thành +84)
        $normalizedPhoneForFirebase = preg_replace('/^0/', '+84', $phone_number); 
        $normalizedPhoneForDatabase = $phone_number;

        $kt_customer = $conn->prepare("SELECT `customer_id` FROM `customer` WHERE phone_number= ?");
        $kt_customer->bind_param("s", $phone_number);
        $kt_customer->execute();
        $kt_result = $kt_customer->get_result();
        if ($kt_result->num_rows > 0) {
            $customer = $kt_result->fetch_assoc();
            $customer_id = $customer['customer_id'];
            if($customer_name != null && $address != null ){
                $sql_customer = "UPDATE customer SET customer_name = ?, address = ? WHERE customer_id = ?";
                $stmt_customer = $conn->prepare($sql_customer);
                $stmt_customer->bind_param("ssi",  $customer_name, $address, $customer_id);
                $stmt_customer->execute();
                }
        } else {
            // Nếu không tồn tại, thêm mới khách hàng
            $sql_customer = "INSERT INTO customer (phone_number, customer_name, address, role_id) VALUES (?, ?, ?, 1)";
            $stmt_customer = $conn->prepare($sql_customer);
            $stmt_customer->bind_param("sss", $phone_number, $customer_name, $address);
            $stmt_customer->execute();
            $customer_id = $conn->insert_id;
        }
        $_SESSION['phone_number'] = $phone_number;
    }    
   

    // Chuyển hướng đến trang quản lý đơn hàng
    header("Location: ../Quanly/check_out_pay.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../csspage/add_to_cart.css">

</head>
<?php require '../Thanhgiaodien/header.php'; ?>

<?php if (!isset($_SESSION['giohang']) || empty($_SESSION['giohang'])): ?>

    <body>
        <div class="container">
            <section>
                <div class="cart-empty">
                    <i class="iconcart-empty"></i>
                    <h1>Giỏ hàng trống</h1>
                    <span class="dmx">Không có sản phẩm nào trong giỏ hàng</span>
                    <a href="" class="btn-backhome">Về trang chủ</a>
                    <p class="note-help">
                        Khi cần trợ giúp vui lòng gọi
                        <a style="color: #288ad6" href="tel:1900232460">0000000000000</a> hoặc
                        <a style="color: #288ad6" href="tel:02836221060">0000000000000</a> (8h00 - 21h30)
                    </p>
                </div>
            </section>

    </body>
<?php elseif (isset($_SESSION['giohang'])): ?>

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
                            <td colspan="4"></td>
                            <td colspan="2">
                                <label class="form-label font-weight-bold" for="Sale">Sale</label>
                                <select name="Sale" id="Sale" class="form-control form-control-lg" onchange="applyVoucher()">
                                    <option value="">Voucher</option>
                                    <?php
                                    if (isset($poin)):
                                        $query = "SELECT `saleoff_id`, `point`, `discount` FROM `saleoff` WHERE `point` <= $poin AND `point` IS NOT NULL";
                                        $result = mysqli_query($conn, $query);
                                        if ($result):
                                            while ($row = mysqli_fetch_array($result)): ?>
                                                <option value="<?= $row['saleoff_id'] ?>"><?= $row['discount'] ?></option>
                                            <?php endwhile;
                                        endif;
                                    endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Tổng giá trị:</td>
                            <td colspan="2">
                                <span class="sale-price" style="color: red;" id="total-price"
                                    data-original-price="<?= $total_price ?>">
                                    <?= number_format($total_price) ?> VNĐ
                                </span>
                                <?php if (isset($_POST['Sale'])): ?>
                                    <span class="h6 original-price">
                                        <del style="color: gray;">
                                            <?= number_format($total_price) ?> VNĐ
                                        </del>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>

            <div class="checkout-form">
                <form action="" method="POST">
                    <table>
                        <tr>
                            <td></td>
                            <td>
                                <div>
                                    <label for="description">Ghi chú</label><br>
                                    <textarea rows="4" cols="30" id="description" name="description"
                                        placeholder="Nhập yêu cầu của bạn"></textarea><br>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="cart-container">
                                    <button type="button" id="show-modal" name="show_modal">Xác nhận</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="modal" class="modal" style="display: none;">
            <div class="modal-content">
                <button class="close" id="close-modal">&times;</button>
                <h3>Thông tin giao hàng</h3>
                <form method="POST" >
                    <label>Thông tin người đặt:</label>
                    <label>
                        <input type="radio" name="gender" value="Anh"> Anh
                        <input type="radio" name="gender" value="Chị"> Chị
                    </label>

                    <label for="customer_name">Họ Và Tên</label>
                    <input type="text" id="customer_name" name="customer_name" required placeholder="Họ và tên của bạn"
                        value="<?= htmlspecialchars($name) ?>">

                    <label for="phone_number">Số Điện Thoại</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Số điện thoại nhận hàng"
                        <?php if (isset($sdt)): ?> readonly style="background-color: #e9ecef;" <?php else: ?> required <?php endif; ?>
                        value="<?= htmlspecialchars($sdt); ?>" pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="11">

                    <label for="address">Địa Chỉ Nhận Hàng</label>
                    <input type="text" id="address" name="address" required placeholder="Nhập địa chỉ nhận hàng"
                        value="<?= $add ?>">

                        <button type="submit" name="checkout_button" class="checkout_button">Xác nhận mua</button>
                </form>
            </div>
        </div>
    </body>
    
    
<?php endif; ?>

<?php require '../Thanhgiaodien/footer.php'; ?>
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

            fetch('add_to_cart.php', {
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
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("modal");
            const showModalButton = document.getElementById("show-modal");
            const closeModalButton = document.getElementById("close-modal");

            if (showModalButton) {
                showModalButton.addEventListener("click", function () {
                    if (modal) modal.style.display = "flex";
                });
            }

            if (closeModalButton) {
                closeModalButton.addEventListener("click", function () {
                    if (modal) modal.style.display = "none";
                });
            }

            window.addEventListener("click", function (event) {
                if (modal && event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });


        </script>
</html>