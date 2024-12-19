<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_GET['id'])) {
    $oder_id = $_GET['id'];

    // Truy vấn đơn hàng theo ID
    $stmt = $conn->prepare("SELECT * FROM oder WHERE oder_id = ?");
    $stmt->bind_param("i", $oder_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $oder = $result->fetch_assoc();
    } else {
        echo "Đơn hàng không tồn tại.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID không hợp lệ.";
    exit();
}

if (isset($_POST['submit'])) {
    $address = trim($_POST['address']);
    $oder_date = trim($_POST['oder_date']);
    $phone = trim($_POST['phone']);

    // Cập nhật đơn hàng vào CSDL
    $stmt = $conn->prepare("UPDATE oder SET address = ?, oder_date = ?, phone = ? WHERE oder_id = ?");
    $stmt->bind_param("sssi", $address, $oder_date, $phone, $oder_id);

    if ($stmt->execute()) {
        header("Location: donhang.php");
        exit();
    } else {
        echo "Lỗi cập nhật đơn hàng: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đơn hàng</title>
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
            <div class="card-header">Sửa thông tin đơn hàng</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($oder['address']) ?>"
                            class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày đặt hàng</label>
                        <input type="date" name="oder_date" value="<?= htmlspecialchars($oder['oder_date']) ?>"
                            class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SĐT</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($oder['phone']) ?>"
                            class="form-control" required />
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật thông tin đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php include '../Thanhgiaodien/footer.php'; ?>