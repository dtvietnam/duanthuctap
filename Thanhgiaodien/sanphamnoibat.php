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
$begin_product = max(0, $total_product - 8);

$product = "SELECT * FROM `product` ORDER BY create_at DESC LIMIT $begin_product,8";
$result = mysqli_query($conn, $product);
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
        }

        .sp {
            width: 22%;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
            background-color: #f9f9f9;
        }

        .image1 {
            padding-top: 10px;
            width: 300px;
            height: 300px;
            overflow: hidden;
            margin: 0 auto;
        }

        .image1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .text {
            padding: 10px;
            background-color: #fff;
            font-size: 14px;
        }

        .text .name {
            font-weight: bold;
            margin: 10px 0;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 14px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 1200px) {
            .sp {
                width: 48%;
            }
        }

        @media (max-width: 768px) {
            .sp {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="sanphamnoibat">
        <h2>Sản phẩm nổi bật</h2>
        <div class="product-container">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="sp">
                    <div class="image1">
                        <a href="../Trang/ctsp.php?id=<?= $row['product_id'] ?>">
                            <img src="../anh/<?= $row['img'] ?>" alt="">
                        </a>
                    </div>
                    <div class="text">
                        <a class="name" href="../Trang/ctsp.php?id=<?= $row['product_id'] ?>">
                            <?= htmlspecialchars($row['product_name']); ?>
                        </a>
                        <p class="name">Giá: <?= number_format($row['price']); ?> VNĐ</p>

                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['product_name']); ?>">
                            <input type="hidden" name="price" value="<?= $row['price'] ?>">
                            <input type="hidden" name="img" value="<?= htmlspecialchars($row['img']); ?>">
                            <button type="submit" name="add_to_cart" class="button">Thêm vào Giỏ hàng</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>