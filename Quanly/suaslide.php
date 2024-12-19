<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

// Check if `id` is provided in the query string
if (isset($_GET['id'])) {
    $slide_id = $_GET['id'];

    // Fetch the slide data
    $stmt = $conn->prepare("SELECT * FROM slide WHERE slide_id = ?");
    $stmt->bind_param("i", $slide_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $slide = $result->fetch_assoc();
    } else {
        echo "Slide không tồn tại.";
        exit();
    }
    $stmt->close();
}

// Handle the form submission
if (isset($_POST['submit'])) {
    $slide_img = $_FILES['slide_img']['name'];
    $slide_img_tmp = $_FILES['slide_img']['tmp_name'];
    $upload_dir = '../anh/';

    // If a new file is uploaded, validate and move it
    if (!empty($slide_img)) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($slide_img, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            $upload_file = $upload_dir . basename($slide_img);
            if (move_uploaded_file($slide_img_tmp, $upload_file)) {
                // New file uploaded successfully
            } else {
                echo "Lỗi khi tải ảnh.";
                exit();
            }
        } else {
            echo "Chỉ chấp nhận các định dạng: " . implode(", ", $allowed_extensions);
            exit();
        }
    } else {
        // Use the existing image if no new file is uploaded
        $slide_img = $slide['slide_img'];
    }

    // Update the slide record in the database
    $stmt = $conn->prepare("UPDATE slide SET slide_img = ? WHERE slide_id = ?");
    $stmt->bind_param("si", $slide_img, $slide_id);

    if ($stmt->execute()) {
        header("Location: slide.php");
        exit();
    } else {
        echo "Lỗi cập nhật slide: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Slide</title>
    <link rel="stylesheet" href="../csspage/manage.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 500px;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            width: 100%;
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

        .image-preview {
            display: block;
            margin-top: 10px;
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">Sửa Slide</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Ảnh Slide</label>
                    <input type="file" name="slide_img" class="form-control" />
                    <p>Ảnh hiện tại:</p>
                    <img src="../anh/<?= htmlspecialchars($slide['slide_img']) ?>" alt="Slide Image" class="image-preview">
                </div>
                <button name="submit" type="submit" class="btn">Cập nhật Slide</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php include '../Thanhgiaodien/footer.php'; ?>
