<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';
if (isset($_POST['submit'])) {
    $note_name = trim($_POST['note_name']);
    $description = trim($_POST['description']);
    $note_img = $_FILES['note_img']['name'];
    $note_img_tmp = $_FILES['note_img']['tmp_name'];
    // Kiểm tra nếu ảnh tải lên thành công
    if ($note_img && move_uploaded_file($note_img_tmp, '../anh/' . $note_img)) {
        $stmt = $conn->prepare("INSERT INTO note (note_id, note_name, description, note_img) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $note_id, $note_name, $description, $note_img);
        if ($stmt->execute()) {
            header("Location: tintuc.php");
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
            <div class="card-header">Thêm tin tức</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-grid">

                        <label for="note_name" class="form-label">Tiêu đề tin tức</label>
                        <input type="text" name="note_name" id="note_name" class="form-control" required />

                        <label for="description" class="form-label">Mô tả</label>
                        <textarea style="height:150px;resize:none" type="text" class="form-control" name="description"
                            id="description" required></textarea>

                        <label for="note_img" class="form-label">Ảnh tin tức</label>
                        <input type="file" name="note_img" id="note_img" class="form-control" required />

                        <button name="submit" type="submit" class="btn btn-success">Thêm sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>