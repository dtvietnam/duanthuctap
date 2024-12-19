<?php
session_start();
global $conn;
include '../database/connect.php';

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');
    
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $saleoff_id = $_POST['saleoff_id'];

    $sanpham = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'price' => $price,
        'img' => $img,
        'saleoff_id' => $saleoff_id
    ];

    if (!isset($_SESSION['giohang'])) {
        $_SESSION['giohang'] = [];
    }

    $_SESSION['giohang'][] = $sanpham;

    echo json_encode([
        'success' => true,
        'message' => 'Thêm sản phẩm vào giỏ hàng thành công!'
    ]);
    exit();
}
?>

<?php
include '../Thanhgiaodien/header.php';
$rowsPerPage = 9;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $rowsPerPage;

// Tính tổng số sản phẩm
$sql_total_products = "SELECT COUNT(*) as total FROM product";
$result_total_products = mysqli_query($conn, $sql_total_products);
$row_total_products = mysqli_fetch_assoc($result_total_products);
$totalProducts = $row_total_products['total'];

// Tính số trang tối đa
$maxPage = ceil($totalProducts / $rowsPerPage);
$type_id = isset($_GET['type_id']) ? (int) $_GET['type_id'] : 0;

// Truy vấn sản phẩm theo type_id
$sql = "SELECT * FROM product";
if ($type_id > 0) {
    $sql .= " WHERE type_id = $type_id"; // Lọc theo loại sản phẩm
}
$sql .= " LIMIT $offset, $rowsPerPage";

$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>
    <link rel="stylesheet" href="../csspage/shop.css">
</head>

<body>
    <div class="shop">
        <?php include '../Thanhgiaodien/search.php' ?>
    </div>
    <div class="shop">
        <div class="listtype">
            <h1>Phân loại</h1>
            <ul class="type-list">
                <?php
                $sql_type = "SELECT * FROM type";
                $result_type = mysqli_query($conn, $sql_type);

                if (mysqli_num_rows($result_type) > 0) {
                    while ($row = mysqli_fetch_assoc($result_type)) {
                        $type_id = $row['type_id'];
                        $type_name = $row['type_name'];
                        echo "<li><a href='#' data-type-id='{$type_id}' class='filter-type'>{$type_name}</a></li>";
                    }
                }
                ?>
            </ul>
            <h1>Giá thành</h1>
            <ul class="price-list">
                <li><a href="#" data-sort="asc" class="filter-price">Thấp đến cao</a></li>
                <li><a href="#" data-sort="desc" class="filter-price">Cao đến thấp</a></li>
                <li><a href="#" data-filter="below_1000000" class="filter-price">Dưới 1.000.000đ</a></li>
                <li><a href="#" data-filter="1000000_2000000" class="filter-price">Từ 1.000.000đ đến 2.000.000đ</a></li>
                <li><a href="#" data-filter="above_2000000" class="filter-price">Trên 2.000.000đ</a></li>
            </ul>
        </div>
        <div class="dsSanpham">
            <div class="item" id="product-list">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($product = mysqli_fetch_assoc($result)): ?>
                        
                        <div class="image">
                            <a href="ctsp.php?id=<?= htmlspecialchars($product['product_id']) ?>"><img
                                    src="../anh/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>"></a>
                            <div class="text">
                                <p class="name"><?= htmlspecialchars($product['product_name']) ?></p>
                                <p class="price">Giá: <?= htmlspecialchars(number_format($product['price'])) ?> VND</p>
                            </div>
                            <button class="add-to-cart" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"
                                data-product-name="<?= htmlspecialchars($product['product_name']) ?>"
                                data-price="<?= htmlspecialchars($product['price']) ?>" data-img="<?= htmlspecialchars($product['img']) ?>"
                                data-saleoff-id="<?= htmlspecialchars($product['saleoff_id']) ?>">
                                Đặt hàng
                            </button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào</p>
                <?php endif; ?>
            </div>
            <div class="page">
                <?php
                echo '<div style="text-align: center; margin-top: 20px;">';

                if ($page > 1) {
                    echo "<a class='pagination-border' href=" . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "><</a> ";
                }

                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $page) {
                        echo '<b class="pagination-border"> ' . $i . '</b> ';
                    } else {
                        echo "<a class='pagination-border' href=" . $_SERVER['PHP_SELF'] . "?page=" . $i . ">" . $i . "</a> ";
                    }
                }

                if ($page < $maxPage) {
                    echo "<a class='pagination-border' href=" . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . ">></a>";
                }

                echo '</div>';
                ?>
            </div>
        </div>
    </div>

</body>
<?php include '../Thanhgiaodien/footer.php'; ?>
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
