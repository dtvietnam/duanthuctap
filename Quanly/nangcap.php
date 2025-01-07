<?php
include '../database/connect.php'; // Kết nối database

if (isset($_GET['id'])) {
    $customer_id = intval($_GET['id']); // Lấy ID của người dùng từ URL

    // Lấy role_id hiện tại của người dùng
    $sql_get_role = "SELECT role_id FROM customer WHERE customer_id = $customer_id";
    $result = mysqli_query($conn, $sql_get_role);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_role_id = $row['role_id'];

        // Tăng role_id lên 1
        $new_role_id = $current_role_id + 1;

        // Cập nhật role_id trong database
        $sql_update = "UPDATE customer SET role_id = $new_role_id WHERE customer_id = $customer_id";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>
                alert('Nâng cấp người dùng thành công!');
                window.location.href = 'nguoidung.php'; // Quay lại trang danh sách người dùng
            </script>";
        } else {
            echo "Lỗi cập nhật: " . mysqli_error($conn);
        }
    } else {
        echo "Không tìm thấy người dùng.";
    }
} else {
    echo "ID người dùng không hợp lệ.";
}

mysqli_close($conn);
