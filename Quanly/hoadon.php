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
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .row-header {
            background-color: rgb(97, 227, 101);
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        .row-header h3,
        .row-item h4 {
            margin: 5px 0;
            font-size: 14px;
            padding: 10px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
            white-space: normal;
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
            <h2>Thông tin hóa đơn</h2>
        </div>
        <div class="hoadon">
            <div class="colum">
                <div class="row-header">
                    <h3>Họ Tên</h3>
                    <h3>Mã đơn Hàng </h3>
                    <h3>Giá Tiền Đơn Hàng</h3>
                    <h3>Ngày Mua hàng</h3>
                    <h3>Trạng thái đơn hàng</h3>
                    <h3></h3>

                </div>
                <div class="row-item">
                    <h4>N v A</h4>
                    <h4>Tên đơn Hàng </h4>
                    <h4>Giá Tiền Tổng Đơn Hàng 300k</h4>
                    <h4>Ngày Mua hàng 29/10/2024</h4>
                    <h4>chưa giao</h4>
                    <h4><a href="#">Chi tiết hóa đơn</a></h4>
                </div>
                <div class="row-item">
                    <h4>N v As</h4>
                    <h4>Tên đơn Hàng </h4>
                    <h4>Giá Tiền Tổng Đơn Hàng 300k</h4>
                    <h4>Ngày Mua hàng 29/10/2024</h4>
                    <h4>đã giao</h4>
                    <h4><a href="#">Chi tiết hóa đơn</a></h4>
                </div>
            </div>
        </div>
    </div>
</body>

</html>