<?php
include '../database/connect.php';
include '../thanhgiaodien/header.php';

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "người dùng không tồn tại.";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $customer_name = trim($_POST['customer_name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $gmail = trim($_POST['gmail']);

    // Cập nhật sản phẩm vào CSDL
    $stmt = $conn->prepare("UPDATE customer SET customer_name = ?, username = ?, password = ?, gmail = ? WHERE customer_id = ?");
    $stmt->bind_param("ssssi", $customer_name, $username, $password, $gmail, $customer_id);

    if ($stmt->execute()) {
        header("Location: nguoidung.php");
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
    <title>Sửa Sản Phẩm</title>
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
            <div class="card-header">Sửa thông tin người dùng</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tên người dùng</label>
                        <input type="text" name="customer_name" value="<?= $customer['customer_name'] ?>"
                            class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Đăng Nhập</label>
                        <input type="text" name="username" value="<?= $customer['username'] ?>" class="form-control"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" value="<?= $customer['password'] ?>" class="form-control"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="gmail" value="<?= $customer['gmail'] ?>" class="form-control"
                            required />
                    </div>
                    <button name="submit" type="submit" class="btn btn-success">Cập nhật thông tin người dùng</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../Thanhgiaodien/footer.php'; ?>