<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';
$error = "";
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Sản phẩm không tồn tại.";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $product_name = trim($_POST['product_name']);
    $price = $_POST['price'];
    $type_id = $_POST['type_id'];
    $saleoff_id = $_POST['saleoff_id'];
    $quantity = $_POST['quantity'];
    $img = $_FILES['img']['name'];
    $img_tmp = $_FILES['img']['tmp_name'];
    if (!is_numeric($price) || $price < 0) {
        $error = "Giá sản phẩm phải là một số dương.";
    } else {
    }
    // Kiểm tra xem có ảnh mới không
    if (!empty($img)) {
        $upload_dir = '../anh/';
        $upload_file = $upload_dir . basename($img);
        move_uploaded_file($img_tmp, $upload_file);
    } else {
        // Nếu không chọn ảnh mới, giữ nguyên ảnh cũ
        $img = $product['img'];
    }

    // Cập nhật sản phẩm vào CSDL
    $stmt = $conn->prepare("UPDATE product SET product_name = ?, price = ?, quantity = ?, img = ?, type_id = ?, saleoff_id = ? WHERE product_id = ?");
    $stmt->bind_param("sddsiii", $product_name, $price, $quantity, $img, $type_id, $saleoff_id, $product_id);

    if ($stmt->execute()) {
        header("Location: sanpham.php");
        exit();
    } else {
        echo "Lỗi cập nhật sản phẩm: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="../path/to/your/css/bootstrap.min.css">
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
            <div class="card-header">Sửa sản phẩm</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" value="<?= $product['product_name'] ?>"
                            class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại sản phẩm</label>
                        <select class="form-select" name="type_id" required>
                            <?php
                            $result_types = mysqli_query($conn, "SELECT * FROM type");
                            while ($row = mysqli_fetch_assoc($result_types)) {
                                $selected = ($row['type_id'] == $product['type_id']) ? "selected" : "";
                                echo "<option value='{$row['type_id']}' $selected>{$row['type_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giảm giá</label>
                        <select class="form-select" name="saleoff_id" required>
                            <?php
                            $result_saleoff = mysqli_query($conn, "SELECT * FROM saleoff");
                            while ($row1 = mysqli_fetch_assoc($result_saleoff)) {
                                $selected = ($row1['saleoff_id'] == $product['saleoff_id']) ? "selected" : "";
                                echo "<option value='{$row1['saleoff_id']}' $selected>{$row1['sale']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá sản phẩm</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="<?= $product['price'] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng kho</label>
                        <input type="number" name="quantity" id="quantity" class="form-control"
                            value="<?= $product['quantity'] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh sản phẩm (giữ nguyên nếu không chọn mới)</label>
                        <input type="file" name="img" class="form-control" />
                        <p>Ảnh hiện tại: <img src="../anh/<?= $product['img'] ?>" alt="" width="100"></p>
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
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