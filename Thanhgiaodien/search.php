<html>

<head>
    <style>
        .search {
            position: relative;
            left: 80%;
            display: flex;
            width: 200px;
            max-width: 200px;
        }

        .search-container {
            background-color: white;
            display: flex;
            align-items: center;
            border: 2px solid #00b300;
            border-radius: 25px;
            padding: 5px 10px;
            width: 100%;
        }

        .search-container input {
            border: none;
            outline: none;
            font-size: 16px;
            color: #666;
            padding: 5px;
            flex-grow: 1;
            width: 100%;

        }

        .search-container i {
            color: #000;
            font-size: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="search">
        <div class="search-container">
            <input type="text" placeholder="Search...">
            <i class="fas fa-search"></i>
        </div>
    </div>
</body>

</html>