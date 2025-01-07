<?php
$title = "Quản lý đơn hàng";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<?php

$sql1 = "SELECT *
          FROM `oder`
          JOIN customer ON `oder`.customer_id = customer.customer_id
          JOIN status ON `oder`.status_id = status.status_id";
$query = mysqli_query($conn, $sql1);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Đơn Hàng</title>
    <link rel="stylesheet" href="../csspage/manage.css">
    <style>
        /* Styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Quản Lý</h2>
            <ul>
                <?php
                include 'sidebar.php';
                ?>
            </ul>
        </div>

        <div class="main-content">
            <h1>Thông Tin Đơn Hàng</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>SĐT khách hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Ghi chú</th>
                        <th>Tình trạng</th>
                        <th>Quản lý đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $row['phone_number'] ?></td>
                                <td><?= $row['customer_name'] ?></td>
                                <td><?= $row['oder_id'] ?></td>
                                <td><?= $row['oder_date'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td><?= $row['status_name'] ?></td>
                                <td>
                                    <button class="btn">
                                        <a href="suahd.php?id=<?= $row['oder_id'] ?>"
                                            style="text-decoration:none; color:inherit;">Sửa</a>
                                    </button>
                                    <button class="btn">
                                        <a onclick="return Delete('hóa đơn')" href="xoadh.php?id=<?= $row['oder_id']; ?>"
                                            style="text-decoration:none; color:inherit;">Xóa</a>
                                    </button>
                                    <button class="btn">
                                        <a href="cthd.php?id=<?= $row['oder_id'] ?>"
                                            onclick="openModal(<?= $row['oder_id'] ?>)">Chi
                                            tiết</a>
                                    </button>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='8'>Không có sản phẩm nào</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
        function Delete(name) {
            return confirm("Bạn có chắc muốn xóa " + name + " này không?");
        }

        function openModal(oder_id) {
            const modal = document.getElementById('orderModal');
            const modalBody = document.getElementById('modal-body');

            fetch(`cthd.php?id=${oder_id}`)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                    modal.style.display = "block";
                })
                .catch(error => {
                    modalBody.innerHTML = "Không thể tải thông tin chi tiết đơn hàng.";
                    console.error(error);
                });
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>