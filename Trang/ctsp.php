<?php
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTSP</title>
    <link rel="stylesheet" href="../csspage/ctsp.css">
</head>
<?php ?>

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

            <div class="quantity">
                <button>
                    -
                </button>
                <input type="text" value="1" />
                <button>
                    +
                </button>
            </div>
            <form action="shopping.php" method="post">
                <input type="submit" name="themgiohang" value="Đặt hàng">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">
                <input type="hidden" name="img" value="<?= htmlspecialchars($product['img']) ?>">
                <input type="hidden" name="saleoff_id" value="<?= htmlspecialchars($product['saleoff_id']) ?>">
                </button>
            </form>
        </div>
    </div>

</body>

</html>