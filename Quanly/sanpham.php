<?php
$title = "Sản Phẩm";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
?>

<?php
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}
$sql = "SELECT product.*, type.type_name, saleoff.sale_name
        FROM product 
        INNER JOIN type ON product.type_id = type.type_id
        INNER JOIN saleoff ON product.saleoff_id = saleoff.saleoff_id";
if (!empty($search)) {
    $sql .= " WHERE product.product_name LIKE '%$search%'";
}

$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin sản phẩm</title>
    <link rel="stylesheet" href="../csspage/manage.css">

</head>
<style>
    form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    form input {
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    form button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #45a049;
    }
</style>

<body>
    <div class="container">

        <div class="sidebar">
            <h2>Quản Lý</h2>
            <ul>
                <?php
                include 'sidebar.php';
                ?>
            </ul>
        </div>

        <div class="main-content">
            <tr>
                <td colspan="2">
                    <h1 class="h2">Thông Tin sản phẩm</h1>
                </td>

                <td colspan="2">
                    <a class="btn" href="themsp.php"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
                </td>
            </tr>
            <form action="sanpham.php" method="GET" style="margin-bottom: 20px;">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" style="padding: 8px; width: 300px;">
                <button type="submit" class="btn">Tìm kiếm</button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>Id sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại Sản Phẩm</th>
                        <th>Giá Sản Phẩm</th>
                        <th>số lượng kho</th>
                        <th>Ghi chú</th>
                        <th>giảm giá</th>
                        <th>Ảnh Sản Phẩm</th>
                        <th>Quản Lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {

                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $row['product_id'] ?></td>
                                <td><?= $row['product_name']; ?></td>
                                <td><?= $row['type_name']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td><?= $row['describe_product']; ?></td>
                                <td><?= $row['sale_name']; ?></td>
                                <td><img src="../anh/<?= $row['img'] ?>" alt="Product Image" width="80" height="80"></td>

                                <td>
                                    <div class="but"></div>
                                    <button class="btn">
                                        <a href="suasp.php?id=<?= $row['product_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>

                                    <button class="btn">
                                        <a onclick="return Delete('<?= $row['product_name']; ?>')"
                                            href="xoasp.php?id=<?= $row['product_id']; ?>"
                                            style="text-decoration:none; color:inherit;">Xóa</a>
                                    </button>

                                </td>

                            </tr>
                    <?php }
                    } else {
                        echo "<tr>
                    <td colspan='8'>Không có sản phẩm nào</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function Delete(name) {
        return confirm("Bạn có chắc muốn xóa sản phẩm: " + name + " không?");
    }
</script>

</html>