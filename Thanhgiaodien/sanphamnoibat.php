<?php
require "../database/connect.php";

// Initialize shopping cart session if not set
if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Handle adding product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    // Check if the product is already in the cart
    if (!isset($_SESSION['giohang'][$product_id])) {
        $_SESSION['giohang'][$product_id] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'price' => $price,
            'img' => $img,
            'quantity' => 1
        ];
    } else {
        // Increment quantity if already in cart
        $_SESSION['giohang'][$product_id]['quantity']++;
    }

    // Redirect to avoid form resubmission
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Fetch products
$total = "SELECT count( DISTINCT product_id) AS total FROM product";
$result_total = mysqli_query($conn, $total);
$total_product = mysqli_fetch_assoc($result_total)['total'];
$begin_product = max(0, $total_product - 9);

$product = "SELECT * FROM product ORDER BY create_at DESC LIMIT ?, 9";
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
        }

        .sanphamnoibat {
            padding: 20px;
            text-align: center;
        }

        .sanphamnoibat h2 {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .dsSanpham {
            width: 70%;
            padding: 20px;
        }

        .item {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .image img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .text {
            text-align: center;
        }

        .name {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .button {
            background-color: #0800ff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0066cc;
        }

        @media (max-width: 1200px) {
            .dsSanpham {
                width: 48%;
            }
        }

        @media (max-width: 768px) {
            .dsSanpham {
                width: 100%;
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
                                    data-saleoff-id="<?= htmlspecialchars($row['saleoff_id'] ?? '') ?>">
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
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const price = this.getAttribute('data-price');
                const img = this.getAttribute('data-img');
                const saleoffId = this.getAttribute('data-saleoff-id');

                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('product_name', productName);
                formData.append('price', price);
                formData.append('img', img);
                formData.append('saleoff_id', saleoffId);

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