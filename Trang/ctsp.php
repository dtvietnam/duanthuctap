<?php
global $conn;
require '../database/connect.php';

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $saleoff_id = $_POST['saleoff_id'];
    $quantity = $_POST['quantity'] ?? 1;

    $sanpham = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'price' => $price,
        'img' => $img,
        'saleoff_id' => $saleoff_id,
        'quantity' => $quantity
    ];
    // Kiểm tra xem có tồn tại giỏ hàng chưa
    if (!isset($_SESSION['giohang'])) {
        $_SESSION['giohang'] = [];
    }
    // Kiểm tra sản phẩm đã tồn tại chưa
    if (isset($_SESSION['giohang'][$product_id])) {
        $_SESSION['giohang'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['giohang'][$product_id] = $sanpham;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Thêm sản phẩm vào giỏ hàng thành công!'
    ]);
    exit();
}
?>
<?php
include '../Thanhgiaodien/header.php';
if (isset($_GET['id'])) {
    $product_id = (int) $_GET['id'];
} else {
    echo "Không tìm thấy sản phẩm.";
    exit;
}
$sql = "SELECT * FROM product WHERE product_id = $product_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    echo "Sản phẩm không tồn tại.";
    exit;
}
$quantity = isset($_POST['soluong']) ? (int) $_POST['soluong'] : 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTSP</title>
    <link rel="stylesheet" href="../csspage/ctsp.css">
</head>
<style>
    .quantity-wrapper {
        display: flex;
        margin: 1%;
        align-items: center;
        gap: 5px;
        /* Khoảng cách giữa các thành phần */
    }

    .quantity-input {
        width: 50px;
        /* Độ rộng trường nhập số */
        text-align: center;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px;
        height: 20px;
    }

    .quantity-input:invalid {
        border-color: red;
    }

    .quantity-btn {
        width: 20px;
        height: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        color: #333;
        font-size: 14px;
        text-align: center;
        line-height: 18px;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        padding: 0;
    }

    .quantity-btn:hover {
        background-color: #e0e0e0;
        border-color: #aaa;
    }

    .quantity-btn:active {
        background-color: #ccc;
    }
</style>

<body>
    <div class="container">
        <div class="product-image">
            <img src="../anh/<?= htmlspecialchars($product['img']) ?>"
                alt="<?= htmlspecialchars($product['product_name']) ?>" height="400" width="autos" />
        </div>
        <div class="product-details">
            <h1>
                <?= htmlspecialchars($product['product_name']) ?>
            </h1>
            <p>
                <?= htmlspecialchars($product['describe_product']) ?>
            </p>
            <div class="price">
                <?= number_format($product['price']) ?> VND
            </div>

            <div class='quantity-wrapper'>
                <button type='button' class='quantity-btn decrease'>-</button>
                <input type="text" id="phone_number" class="no-spinners quantity-input" name='soluong[]'
                    pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" min="1" step="1"
                    value='<?= $quantity ?>'><br>
                <button type='button' class='quantity-btn increase'>+</button>
            </div>
            <button class="add-to-cart" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"
                data-product-name="<?= htmlspecialchars($product['product_name']) ?>"
                data-price="<?= htmlspecialchars($product['price']) ?>"
                data-img="<?= htmlspecialchars($product['img']) ?>"
                data-saleoff-id="<?= htmlspecialchars($product['saleoff_id'] ?? '') ?>"
                data-quantity="<?= htmlspecialchars($quantity) ?>">
                Đặt hàng
            </button>
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
        });
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const price = this.getAttribute('data-price');
                const img = this.getAttribute('data-img');
                const saleoffId = this.getAttribute('data-saleoff-id');
                const quantityInput = this.closest('.product-details').querySelector('.quantity-input');
                const quantity = quantityInput.value;

                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('product_name', productName);
                formData.append('price', price);
                formData.append('img', img);
                formData.append('saleoff_id', saleoffId);
                formData.append('quantity', quantity);

                fetch('shop.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                        } else {
                            alert(data.message || 'Thêm sản phẩm thất bại!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi. Vui lòng thử lại!');
                    });
            });
        });
    });
</script>

</html>