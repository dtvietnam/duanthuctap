<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_GET['id'])) {
    $type_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM type WHERE type_id = ?");
    $stmt->bind_param("i", $type_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $type = $result->fetch_assoc();
    } else {
        echo "Loại sản phẩm không tồn tại.";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $type_name = trim($_POST['type_name']);
    $type_img = $_FILES['type_img']['name'];
    $type_img_tmp = $_FILES['type_img']['tmp_name'];
    if (!empty($type_img)) {
        $upload_dir = '../anh/';
        $upload_file = $upload_dir . basename($type_img);
        move_uploaded_file($type_img_tmp, $upload_file);
    } else {
        // Nếu không chọn ảnh mới, giữ nguyên ảnh cũ
        $type_img = $type['type_img'];
    }
    // Cập nhật sản phẩm vào CSDL
    $stmt = $conn->prepare("UPDATE type SET type_name = ?, type_img = ? WHERE type_id = ?");
    $stmt->bind_param("ssi", $type_name, $type_img, $type_id);

    if ($stmt->execute()) {
        header("Location: loaisp.php");
        exit();
    } else {
        echo "Lỗi cập nhật loại sản phẩm: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa loại Sản Phẩm</title>
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
            background: #218838
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Sửa thông tin loại sản phẩm</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tên loại sản phẩm</label>
                        <input type="text" name="type_name" value="<?= $type['type_name'] ?>" class="form-control"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh sản phẩm (giữ nguyên nếu không chọn mới)</label>
                        <input type="file" name="type_img" class="form-control" />
                        <p>Ảnh hiện tại: <img src="../anh/<?= $product['type_img'] ?>" alt="" width="100"></p>
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật thông tin loại sản
                        phẩm</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>