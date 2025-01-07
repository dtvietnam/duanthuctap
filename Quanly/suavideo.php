<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_GET['id'])) {
    $video_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM video WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $video = $result->fetch_assoc();
    } else {
        echo "Video không tồn tại.";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $note = trim($_POST['note']);
    $video_img = $_FILES['video_img']['name'];
    $video_img_tmp = $_FILES['video_img']['tmp_name'];
    if (!empty($video_img)) {
        $upload_dir = '../videos/';
        $upload_file = $upload_dir . basename($video_img);
        move_uploaded_file($video_img_tmp, $upload_file);
    } else {
        // Nếu không chọn video mới, giữ nguyên video cũ
        $video_img = $video['video_img'];
    }

    $stmt = $conn->prepare("UPDATE video SET note = ?, video_img = ? WHERE video_id = ?");
    $stmt->bind_param("ssi", $note, $video_img, $video_id);

    if ($stmt->execute()) {
        header("Location: video.php");
        exit();
    } else {
        echo "Lỗi cập nhật video: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa video</title>
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
            <div class="card-header">Sửa thông tin video</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề video</label>
                        <input type="text" name="note" value="<?= $video['note'] ?>" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video (giữ nguyên nếu không chọn mới)</label>
                        <input type="file" name="video_img" class="form-control" accept="video/*" />
                        <p>Video hiện tại:
                            <video width="320" height="240" controls>
                                <source src="../videos/<?= $video['video_img'] ?>" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ video.
                            </video>
                        </p>
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật video</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>