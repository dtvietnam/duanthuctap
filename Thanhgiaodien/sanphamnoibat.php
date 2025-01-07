<?php
require "../database/connect.php";
// Kiểm tra xem có tồn tại giỏ hàng chưa
if (!isset($_SESSION['giohang']) || !is_array($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $saleoff_id = $_POST['saleoff_id'];
    $quantity = $_POST['quantity'] ?? 1;
    foreach ($_SESSION['giohang'] as $index => $item) {
    }
    $sanpham = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'price' => $price,
        'img' => $img,
        'saleoff_id' => $saleoff_id,
        'quantity' => $quantity
    ];

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

// Fetch products
$total = "SELECT count( DISTINCT product_id) AS total FROM product";
$result_total = mysqli_query($conn, $total);
$total_product = mysqli_fetch_assoc($result_total)['total'];
$begin_product = max(0, $total_product - 9);

$product = "SELECT * FROM product ORDER BY create_at DESC LIMIT ?, 8";
$query_type = $conn->prepare($product);
$query_type->bind_param("i", $begin_product);
$query_type->execute();
$result_type = $query_type->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .sanphamnoibat {
            padding: 20px;
            text-align: center;
        }

        .sanphamnoibat h2 {
            font-weight: bold;
            color: rgb(26, 89, 23);
            font-size: 40px;
            margin-bottom: 30px;
        }

        .product-container {
            display: flex;
            justify-content: center;
            /* Center the product container */
            flex-wrap: wrap;
            gap: 20px;
        }

        .dsSanpham {
            width: 100%;
            max-width: 1200px;
            /* Limit the width for larger screens */
            padding: 20px;
        }

        .item {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .image img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            padding: 30px;
        }

        .text {
            text-align: center;
            /* Căn giữa văn bản */
            margin: 10px 0;
            /* Thêm khoảng cách */
            padding-left: 20px;
            /* Dịch sang bên phải 20px */

        }

        .name {
            color: rgb(26, 89, 23);
            font-size: 25px;
            font-weight: bold;
            margin: 10px 0;
        }

        .price {
            font-size: 20px;
            /* Điều chỉnh kích thước chữ cho giá */
            margin: 10px 0;
            /* Thêm khoảng cách */
        }

        .add-to-cart {
            font-size: 20px;
            display: block;
            /* Biến nút thành phần tử block */
            margin: 0 auto;
            /* Căn giữa nút nếu cần */
            background-color: rgb(24, 68, 21);
            color: white;
            padding: 15px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .add-to-cart:hover {
            background-color: rgb(202, 55, 48);
            transform: scale(1.1);
        }

        @media (max-width: 1200px) {
            .item {
                grid-template-columns: repeat(3, 1fr);
                /* 3 columns for medium screens */
            }

            .dsSanpham {
                width: 90%;
            }
        }

        @media (max-width: 768px) {
            .item {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columns for small screens */
            }

            .dsSanpham {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .item {
                grid-template-columns: 1fr;
                /* 1 column for very small screens */
            }
        }
    </style>
</head>

<body>
    <div class="sanphamnoibat">
        <h2>Sản phẩm nổi bật</h2>
        <div class="product-container">
            <div class="dsSanpham">
                <div class="item" id="product-list">
                    <?php if ($result_type && $result_type->num_rows > 0):
                        while ($row = $result_type->fetch_assoc()): ?>
                            <div class="image">
                                <a href="ctsp.php?id=<?= htmlspecialchars($row['product_id']) ?>">
                                    <img src="../anh/<?= htmlspecialchars($row['img']) ?>"
                                        alt="<?= htmlspecialchars($row['product_name']) ?>">
                                </a>
                                <div class="text">
                                    <p class="name"><?= htmlspecialchars($row['product_name']) ?></p>
                                    <p class="price">Giá: <?= htmlspecialchars(number_format($row['price'])) ?> VND</p>
                                </div>
                                <button class="add-to-cart" data-product-id="<?= htmlspecialchars($row['product_id']) ?>"
                                    data-product-name="<?= htmlspecialchars($row['product_name']) ?>"
                                    data-price="<?= htmlspecialchars($row['price']) ?>"
                                    data-img="<?= htmlspecialchars($row['img']) ?>"
                                    data-saleoff-id="<?= htmlspecialchars($row['saleoff_id'] ?? '') ?>"
                                    data-quantity="<?= htmlspecialchars(1) ?>">
                                    Đặt hàng
                                </button>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Không có sản phẩm nào</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const price = this.getAttribute('data-price');
                const img = this.getAttribute('data-img');
                const saleoffId = this.getAttribute('data-saleoff-id');
                const quantity = this.getAttribute('data-quantity');


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