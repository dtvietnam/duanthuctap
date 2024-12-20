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
    $phone_number = trim($_POST['phone_number']);
    $customer_id = $_POST['customer_id'];
    $description = trim($_POST['description']);
    $status_name = $_POST['status_name'];
    $status_id = $_POST['status_id'];
    // Cập nhật đơn hàng vào CSDL
    $stmt = $conn->prepare("UPDATE oder SET address = ?, oder_date = ?, phone_number = ?, customer_id = ? WHERE oder_id = ?");
    $stmt->bind_param("ssiii", $address, $oder_date, $phone_number, $customer_id, $customer_name, $oder_id);

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
                        <?php
                        if (isset($oder['customer_id'])) {
                            $stmt = $conn->prepare("SELECT phone_number FROM customer WHERE customer_id = ?");
                            $stmt->bind_param("i", $oder['customer_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $phone_number = ($result->num_rows > 0) ? $result->fetch_assoc()['phone_number'] : '';
                            $stmt->close();
                        } else {
                            $phone_number = '';
                        }
                        ?>
                        <input type="text" name="phone_number" value="<?= htmlspecialchars($phone_number) ?>"
                            class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên khách hàng</label>
                        <?php
                        if (isset($oder['customer_id'])) {
                            $stmt = $conn->prepare("SELECT customer_name FROM customer WHERE customer_id = ?");
                            $stmt->bind_param("i", $oder['customer_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $customer_name = ($result->num_rows > 0) ? $result->fetch_assoc()['customer_name'] : '';
                            $stmt->close();
                        } else {
                            $customer_name = '';
                        }
                        ?>
                        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>"
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