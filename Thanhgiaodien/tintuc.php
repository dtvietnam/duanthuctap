<!DOCTYPE html>
<html lang="en">
<?php
include '../database/connect.php';

// Lấy 4 tin tức mới nhất
$sql = "SELECT * FROM note ORDER BY note_id DESC LIMIT 4";
$query = mysqli_query($conn, $sql);
if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            background-color: white;
            color: rgb(26, 89, 23);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .news {
            background-color: rgb(24, 68, 21);
            padding: 20px;
        }

        .news-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }

        .form {
            background-color: white;
            width: 23%;
            border-radius: 5px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .news-item img {
            align-items: center;
            width: 100%;
            height: auto;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .news-item h2 {
            font-size: 18px;
            color: rgb(26, 89, 23);
            margin: 10px 0;
            text-align: center;
        }

        .news-item p {
            font-size: 14px;
            margin: 10px 0;
            height: 50px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            position: relative;
            cursor: pointer;
        }

        .news-item p:hover {
            overflow-y: auto;
            white-space: normal;
            max-height: 150px;
        }

        .news-item p::-webkit-scrollbar {
            width: 5px;
        }

        .news-item p::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .btn {
            text-align: center;
            margin-top: 10px;
        }

        .read-more {
            display: inline-block;
            background-color: rgb(9, 162, 9);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .read-more:hover {
            background-color: rgb(202, 55, 48);
            transform: scale(1.1);
        }

        @media (max-width: 1024px) {
            .form {
                width: 48%;
            }
        }

        @media (max-width: 768px) {
            .form {
                width: 100%;
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="news">
            <div class="news-grid">
                <?php
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <div class="form">
                            <div class="news-item">
                                <div class="anh">
                                    <img src="../anh/<?= htmlspecialchars($row['note_img']) ?>"
                                        alt="<?= htmlspecialchars($row['note_name']) ?>">
                                </div>
                                <h2><?= htmlspecialchars($row['note_name']) ?></h2>
                                <p class="description">
                                    <?= htmlspecialchars($row['description']) ?>
                                </p>
                            </div>
                            <div class="btn">
                                <a class="read-more" href="contact.php">
                                    Xem thêm
                                </a>
                            </div>
                        </div>
                <?php }
                } else {
                    echo "<p>Không có tin tức để hiển thị.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>