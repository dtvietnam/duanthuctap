<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .footer {
        margin-top: auto;
        background-color: rgb(9, 86, 10);
        padding: 20px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        border-top: 1px solid #ddd;
    }

    .rv,
    .contact,
    .support {
        flex: 1 1 300px;
        margin: 10px;
        padding: 10px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .review {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    h3 {
        margin-bottom: 10px;
        color: #333;
    }

    p {
        margin-bottom: 5px;
        color: #555;
    }

    @media (max-width: 768px) {
        .review {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .review {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="footer">
        <div class="rv">
            <h3>Review về chúng tôi</h3>
            <div class="review">
                <p>Sản phẩm chất lượng</p>
                <p>Giá cả hợp lý</p>
                <p>Đóng gói cẩn thận</p>
                <p>Dịch vụ tốt</p>
                <p>Nhân viên thân thiện</p>
                <p>Giao hàng nhanh</p>
                <p>Nhiều ưu đãi hấp dẫn</p>
            </div>
        </div>
        <div class="contact">
            <h3>Thông tin về chúng tôi</h3>
            <p>Địa chỉ: 50 Đoàn trần nghiệp</p>
            <p>Số điện thoại: 0123 456 789</p>
            <p>Email: info@thophuc.com</p>
        </div>
        <div class="support">
            <h3>Hỗ trợ</h3>
            <p>Mọi thông tin xin liên hệ với chúng tôi thông qua</p>
        </div>
    </div>
</body>

</html>