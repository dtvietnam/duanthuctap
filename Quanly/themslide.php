<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slide_img = $_FILES['slide_img']['name'];
    $slide_img_tmp = $_FILES['slide_img']['tmp_name'];
    $upload_dir = '../anh/';

    // Validate the uploaded file
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_file_size = 10 * 1024 * 1024;
    if (!in_array($_FILES['slide_img']['type'], $allowed_types)) {
        $error = "Chỉ cho phép các định dạng ảnh JPG, PNG.";
    } elseif ($_FILES['slide_img']['size'] > $max_file_size) {
        $error = "Dung lượng ảnh vượt quá giới hạn 2MB.";
    } else {
        $target_file = $upload_dir . basename($slide_img);
        if (move_uploaded_file($slide_img_tmp, $target_file)) {
            // Insert into the database
            $stmt = $conn->prepare("INSERT INTO slide (slide_img) VALUES (?)");
            $stmt->bind_param("s", $slide_img);
            if ($stmt->execute()) {
                header("Location: slide.php");
                exit();
            } else {
                $error = "Lỗi thêm slide: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Lỗi khi tải ảnh lên thư mục.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Slide</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header text-center text-white bg-success">
                <h3>Thêm Slide</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="slide_img" class="form-label">Ảnh slide</label>
                        <input type="file" name="slide_img" id="slide_img" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Thêm Slide</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>