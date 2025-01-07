<?php
$title = "Giảm giá";
include '../Thanhgiaodien/header.php';
include '../database/connect.php';

$query = "SELECT * FROM saleoff";
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
if (isset($_POST['add_saleoff'])) {
    $sale = $_POST['saleoff'];
    $sql = "INSERT INTO saleoff (sale_name) VALUES ('$sale')";
    $add = mysqli_query($conn, $sql);
    if ($add) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Lỗi khi thêm giảm giá: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, $query);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin giảm giá</title>
    <link rel="stylesheet" href="../csspage/manage.css">
    <style>
        .form-wrapper {
            width: 220px;
            background-color: black;
            position: relative;
            left: 1000px;

        }

        .ct {
            display: flex;
            align-items: center;
        }

        .ct input.form-control {
            width: auto;
            margin-right: 10px;

        }

        .ct button {
            margin-top: 0;

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
            <div>
                <h1 class="h1">Thông Tin giảm giá</h1>
                <div class="form-wrapper">
                    <form id="form" action="" method="post">
                        <div class="ct">
                            <table>
                                <tr>
                                    <td><input required type="text" class="form-control" name="saleoff"
                                            placeholder="% giảm giá"></td>
                                    <td><button type="submit" name="add_saleoff">Thêm</button></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>




            <div class="bang ">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Id giảm giá</th>
                            <th>% giảm giá</th>
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $row['saleoff_id'] ?></td>
                                    <td><?= $row['sale_name'] ?> %</td>
                                    <td>
                                        <button class="btn">
                                            <a href="suagiamgia.php?id=<?= $row['saleoff_id'] ?>"
                                                style="text-decoration:none; color:inherit;">Sửa</a>
                                        </button>

                                        <button class="btn">
                                            <a onclick="return Delete('<?= $row['sale_name']; ?>')"
                                                href="xoagiamgia.php?id=<?= $row['saleoff_id']; ?>"
                                                style="text-decoration:none; color:inherit;">Xóa</a>
                                        </button>
                                    </td>
                                </tr>

                        <?php }
                        } else {
                            // Nếu không có dữ liệu
                            echo "<tr>
                    <td colspan='4'>Không có giảm giá nào</td>
                    </tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    function Delete(name) {
        return confirm(" Bạn có chắc muốn xóa đơn giảm giá: " + name + " không?");
    }
</script>

</html>