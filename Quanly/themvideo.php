<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_POST['submit'])) {
    $note = trim($_POST['note']);
    $link = $_FILES['link']['name'];
    $link_tmp = $_FILES['link']['tmp_name'];

    // Kiểm tra định dạng file tải lên
    $allowed_formats = ['mp4', 'avi', 'mkv'];
    $file_extension = pathinfo($link, PATHINFO_EXTENSION);

    if (!in_array(strtolower($file_extension), $allowed_formats)) {
        echo "File tải lên phải là video định dạng mp4, avi hoặc mkv.";
    } else if ($link && move_uploaded_file($link_tmp, '../anh/' . $link)) {
        $stmt = $conn->prepare("INSERT INTO video (video_id, note, link) VALUES (NULL, ?, ?)");
        $stmt->bind_param("ss", $note, $link);
        if ($stmt->execute()) {
            header("Location: video.php");
            exit();
        } else {
            echo "Lỗi thêm video: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Lỗi khi tải video lên máy chủ.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Video</title>
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
            <div class="card-header">Thêm Video</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-grid">

                        <label for="note" class="form-label">Tiêu đề video</label>
                        <input type="text" name="note" id="note" class="form-control" required />

                        <label for="link" class="form-label">Tải lên video</label>
                        <input type="file" name="link" id="link" class="form-control" required />

                        <button name="submit" type="submit" class="btn btn-success">Thêm Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>