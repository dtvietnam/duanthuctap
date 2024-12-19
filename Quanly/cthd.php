<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .hd {
        position: relative;
        top: 120px;
    }

    .nd {
        width: 80%;
        margin: 30px auto;
        padding: 20px;
        max-width: 500px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    .nd h2 {
        margin: 0 0 15px 0;
        font-size: 30px;
        color: #4CAF50;
        font-weight: bold;
        text-align: center;
    }

    .nd h3 {
        margin: 10px 0;
        font-size: 18px;
        color: #555;
        line-height: 1.5;
    }

    .nd h3 span {
        color: #000;
        font-weight: bold;
    }

    .hoadon {
        position: relative;
        top: 20%;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .colum {
        width: 80%;
        margin: 30px auto;
        border: 1px solid #ddd;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .row-header,
    .row-item {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .row-header {
        background-color: rgb(97, 227, 101);
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }

    .row-header h4,
    .row-item h5 {
        margin: 5px 0;
        padding: 10px;
    }

    .row-item:nth-child(odd) {
        background-color: #f9f9f9;
    }

    a:hover {
        color: white;
        background-color: blue;
    }
    </style>


</head>
<?php include '../Thanhgiaodien/header.php' ?>

<body>

    <div class="hd">
        <div class="nd">
            <h2>Thông tin chi tiết</h2>
            <h3>Mã Hóa Đơn: <?php echo "hd-001"; ?></h3>
            <h3>Ngày đặt hàng<?php echo "27 tháng 4"; ?> </h3>
        </div>


        <div class="hoadon">
            <div class="colum">
                <div class="row-header">
                    <h4>Tên sản phẩm</h4>
                    <h4>Số lượng </h4>
                    <h4>Loại sản phẩm</h4>
                    <h4>Giá sản phẩm </h4>
                    <h4>Trạng thái đơn hàng</h4>

                </div>
                <div class="row-item">
                    <h5>kẹo</h5>
                    <h5>4 </h5>
                    <h5>loại</h5>
                    <h5>200000</h5>
                    <h5>Đã giao</h5>
                </div>
                <div class="row-item">
                    <h5>kẹo</h5>
                    <h5>4 </h5>
                    <h5>loại</h5>
                    <h5>200000</h5>
                    <h5>chưa giao</h5>
                </div>
            </div>
        </div>
    </div>
</body>

</html>