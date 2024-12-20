<?php
global $conn;
require '../database/connect.php';

$type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;

$queryCondition = "";

if ($type_id) {
    $queryCondition .= "WHERE type_id = $type_id";
}

if ($filter == "below_1000000") {
    $queryCondition .= $queryCondition ? " AND price < 1000000" : "WHERE price < 1000000";
} elseif ($filter == "1000000_2000000") {
    $queryCondition .= $queryCondition ? " AND price BETWEEN 1000000 AND 2000000" : "WHERE price BETWEEN 1000000 AND 2000000";
} elseif ($filter == "above_2000000") {
    $queryCondition .= $queryCondition ? " AND price > 2000000" : "WHERE price BETWEEN 1000000 AND 2000000";
}

$orderBy = "";
if ($sort == "asc") {
    $orderBy = "ORDER BY price ASC";
} elseif ($sort == "desc") {
    $orderBy = "ORDER BY price DESC";
}

$sql = "SELECT * FROM product $queryCondition $orderBy";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        $product_name = $product['product_name'];
        $price = number_format($product['price']);
        $img = $product['img'];
        echo "
        <div class='image'>
            <img src='../anh/{$img}' alt='{$product_name}'>
            <div class='text'>
                <p class='name'>{$product_name}</p>
                <p class='price'>Giá: {$price} VND</p>
            </div>
        </div>";
    }
} else {
    echo "<p>Không có sản phẩm nào phù hợp.</p>";
}
