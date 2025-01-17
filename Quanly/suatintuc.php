<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_GET['id'])) {
    $note_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM note WHERE note_id = ?");
    $stmt->bind_param("i", $note_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $note = $result->fetch_assoc();
    } else {
        echo "Tin tức không tồn tại.";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $note_name = trim($_POST['note_name']);
    $description = trim($_POST['description']);
    $note_img = $_FILES['img']['name'];
    $note_img_tmp = $_FILES['img']['tmp_name'];
    if (!empty($note_img)) {
        $upload_dir = '../anh/';
        $upload_file = $upload_dir . basename($note_img);
        move_uploaded_file($note_img_tmp, $upload_file);
    } else {
        // Nếu không chọn ảnh mới, giữ nguyên ảnh cũ
        $note_img = $note['note_img'];
    }

    $stmt = $conn->prepare("UPDATE note SET note_name = ?, description = ?, note_img = ? WHERE note_id = ?");
    $stmt->bind_param("sssi", $note_name, $description, $note_img, $note_id);

    if ($stmt->execute()) {
        header("Location: tintuc.php");
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
    <title>Sửa người dùng</title>
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
            <div class="card-header">Sửa thông tin tin tức</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề tin tức</label>
                        <input type="text" name="note_name" value="<?= $note['note_name'] ?>" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="description" value="<?= $note['description'] ?>"
                            class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh sản phẩm (giữ nguyên nếu không chọn mới)</label>
                        <input type="file" name="note_img" class="form-control" />
                        <p>Ảnh hiện tại: <img src="../anh/<?= $note['note_img'] ?>" alt="" width="100"></p>
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật tin tức</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>