<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';
$sql = "SELECT * FROM type";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
$sql1 = "SELECT * FROM saleoff";
$query1 = mysqli_query($conn, $sql1);
if (!$query1) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
if (isset($_POST['submit'])) {
    $product_name = trim($_POST['product_name']);
    $price = $_POST['price'];
    $img = $_FILES['img']['name'];
    $quantity = $_POST['quantity'];
    $describe_product = $_POST['describe_product'];
    $img_tmp = $_FILES['img']['tmp_name'];
    $type_id = $_POST['type_id'];
    $saleoff_id = $_POST['saleoff_id'];
    // Kiểm tra nếu ảnh tải lên thành công
    if ($img && move_uploaded_file($img_tmp, '../anh/' . $img)) {
        // Sử dụng prepared statement để tránh SQL Injection
        $stmt = $conn->prepare("INSERT INTO product (product_name, price, quantity, describe_product, img, type_id, saleoff_id) VALUES (?,?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddssii", $product_name, $price, $quantity, $describe_product, $img, $type_id, $saleoff_id);

        if ($stmt->execute()) {
            header("Location: sanpham.php");
            exit();
        } else {
            echo "Lỗi thêm sản phẩm: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Lỗi khi tải ảnh.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            position: relative;
            top: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 600px;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 100%;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-grid {
            width: 600px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px 20px;
            align-items: center;
        }

        .form-label {
            font-weight: bold;
            text-align: right;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            grid-column: 1 / -1;
            padding: 10px;
            font-size: 16px;
            background: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Thêm sản phẩm</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-grid">
                        <label for="product_name" class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required />

                        <label for="type_id" class="form-label">Loại sản phẩm</label>
                        <select class="form-control" name="type_id" id="type_id">
                            <?php
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <option value="<?= $row['type_id']; ?>"><?= $row['type_name']; ?></option>
                            <?php }
                            } ?>
                        </select>

                        <label for="saleoff_id" class="form-label">Giảm giá</label>
                        <select class="form-control" name="saleoff_id" id="saleoff_id">
                            <?php
                            if (mysqli_num_rows($query1) > 0) {
                                while ($row1 = mysqli_fetch_assoc($query1)) { ?>
                                    <option value="<?= $row1['saleoff_id']; ?>"><?= $row1['sale_name']; ?></option>
                            <?php }
                            } ?>
                        </select>

                        <label for="price" class="form-label">Giá sản phẩm</label>
                        <input type="number" name="price" id="price" class="form-control" required />

                        <label for="quantity" class="form-label">số lượng sản phẩm</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required />
                        <label for="describe_product" class="form-label">Ghi chú</label>
                        <input type="text" name="describe_product" id="describe_product" class="form-control"
                            required />
                        <label for="img" class="form-label">Ảnh sản phẩm</label>
                        <input type="file" name="img" id="img" class="form-control" required />

                        <button name="submit" type="submit" class="btn btn-success">Thêm sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const price = document.getElementById('price').value;
        if (price < 0) {
            alert("Giá sản phẩm không được âm!");
            e.preventDefault(); // Ngăn chặn gửi form
        }
    });
</script>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>