<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';
if (isset($_POST['submit'])) {
    $type_name = trim($_POST['type_name']);
    $type_img = $_FILES['type_img']['name'];
    $type_img_tmp = $_FILES['type_img']['tmp_name'];
    // Kiểm tra nếu ảnh tải lên thành công
    if ($type_img && move_uploaded_file($type_img_tmp, '../anh/' . $type_img)) {
        $stmt = $conn->prepare("INSERT INTO type (type_id, type_name, type_img) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $type_id, $type_name, $type_img);
        if ($stmt->execute()) {
            header("Location: loaisp.php");
            exit();
        } else {
            echo "Lỗi thêm tin tức: " . $conn->error;
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
            <div class="card-header">Thêm loại sản phẩm</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-grid">

                        <label for="type_name" class="form-label">Tiêu đề tin tức</label>
                        <input type="text" name="type_name" id="type_name" class="form-control" required />

                        <label for="type_img" class="form-label">Ảnh loại sản phẩm</label>
                        <input type="file" name="type_img" id="type_img" class="form-control" required />

                        <button name="submit" type="submit" class="btn btn-success">Thêm loại sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>