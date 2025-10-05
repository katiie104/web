<?php
// php-7.3/index.php - Bài 7.3: Lấy và gửi dữ liệu
$page = $_GET['page'] ?? 'home'; // Trang mặc định là 'home'

// Xử lý upload nếu có
if ($page == 'uploadprocess' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'pages/uploadprocess.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.3 - Lấy và gửi dữ liệu - Trần Hồng Khang</title>
    <link rel="stylesheet" href="/lab4/php-7.4/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }
        .header {
            background: #3c97e7ff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .menu {
            background: #1a3f5fff;
            padding: 15px;
            text-align: center;
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .menu a:hover {
            background: #2c513dff;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .content {
            min-height: 400px;
            padding: 20px;
        }
        .footer {
            background: #34495e;
            color: white;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        input, select, textarea {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 8px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: #2980b9;
        }
        .result {
            background: #e8f6f3;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Bài 7.3 - Lấy và gửi dữ liệu</h1>
        <p>Mọi page được chạy trên nền trang Index.php</p>
    </div>

    <!-- Menu Navigation -->
    <div class="menu">
        <a href="index.php?page=home">🏠 Home</a>
        <a href="index.php?page=drawTable">📊 DrawTable</a>
        <a href="index.php?page=loop">🔄 Loop</a>
        <a href="index.php?page=calculate1">🧮 Calculate1</a>
        <a href="index.php?page=calculate2">📐 Calculate2</a>
        <a href="index.php?page=array1">📋 Array1</a>
        <a href="index.php?page=uploadform">📁 UploadForm</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="content">
            <?php
            // Include trang tương ứng
            switch ($page) {
                case 'drawTable':
                    include 'pages/drawTable.php';
                    break;
                case 'loop':
                    include 'pages/loop.php';
                    break;
                case 'calculate1':
                    include 'pages/calculate1.php';
                    break;
                case 'calculate2':
                    include 'pages/calculate2.php';
                    break;
                case 'array1':
                    include 'pages/array1.php';
                    break;
                case 'uploadform':
                    include 'pages/uploadform.php';
                    break;
                case 'uploadprocess':
                    include 'pages/uploadprocess.php';
                    break;
                case 'home':
                default:
                    include 'pages/home.php';
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2025 - Trần Hồng Khang - 29_TRANHONGKHANG - Bài 7.3</p>
    </div>
</body>
</html>