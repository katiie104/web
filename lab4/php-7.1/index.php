<?php
// php-7.1/index.php - Bài 7.1: Tạo template
$page = isset($_GET['page']) ? $_GET['page'] : 'center';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.1 - Tạo Template - Trần Hồng Khang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .menu {
            background: #34495e;
            padding: 10px;
            text-align: center;
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .menu a:hover {
            background: #1abc9c;
        }
        .container {
            display: flex;
            min-height: 500px;
        }
        .left {
            width: 20%;
            background: #ecf0f1;
            padding: 15px;
        }
        .center {
            width: 60%;
            background: white;
            padding: 20px;
            min-height: 400px;
        }
        .right {
            width: 20%;
            background: #ecf0f1;
            padding: 15px;
        }
        .footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        input, select, textarea {
            padding: 5px;
            margin: 5px 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Thông tin sinh viên: Trần Hồng Khang - 29_TRANHONGKHANG</h1>
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="index.php?page=center">Trang Chủ</a>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=contact">Contact</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Left Sidebar -->
        <div class="left">
            <h3>Menu Trái</h3>
            <ul>
                <li><a href="index.php?page=center">🏠 Trang chủ</a></li>
                <li><a href="index.php?page=login">🔐 Đăng nhập</a></li>
                <li><a href="index.php?page=contact">📞 Liên hệ</a></li>
            </ul>
            
            <h3>Thông tin</h3>
            <p><strong>Họ tên:</strong> Trần Hồng Khang</p>
            <p><strong>MSSV:</strong> 29_TRANHONGKHANG</p>
            <p><strong>Lớp:</strong> 19C</p>
        </div>

        <!-- Center Content -->
        <div class="center">
            <?php
            // Include nội dung trang tương ứng
            switch ($page) {
                case 'login':
                    echo '<h2>Trang Đăng Nhập</h2>';
                    echo '<form method="post">';
                    echo '<table>';
                    echo '<tr><td>Username:</td><td><input type="text" name="username"></td></tr>';
                    echo '<tr><td>Password:</td><td><input type="password" name="password"></td></tr>';
                    echo '<tr><td></td><td><input type="submit" value="Login"> <input type="reset" value="Reset"></td></tr>';
                    echo '</table>';
                    echo '</form>';
                    break;
                
                case 'contact':
                    echo '<h2>Trang Liên Hệ</h2>';
                    echo '<form method="post">';
                    echo '<table>';
                    echo '<tr><td>Họ tên:</td><td><input type="text" name="hoten"></td></tr>';
                    echo '<tr><td>Email:</td><td><input type="email" name="email"></td></tr>';
                    echo '<tr><td>Nội dung:</td><td><textarea name="noidung" rows="4"></textarea></td></tr>';
                    echo '<tr><td></td><td><input type="submit" value="Gửi"> <input type="reset" value="Xóa"></td></tr>';
                    echo '</table>';
                    echo '</form>';
                    break;
                
                case 'center':
                default:
                    echo '<h2>Trang Chủ - Bài 7.1: Tạo Template</h2>';
                    echo '<p><strong>Company name:</strong> TLA</p>';
                    echo '<p><strong>Address:</strong> Thanh Xuân - Hà Nội</p>';
                    echo '<p><strong>Description:</strong> Software company</p>';
                    
                    echo '<h3>Hướng dẫn sử dụng:</h3>';
                    echo '<ul>';
                    echo '<li>Chọn menu để chuyển trang</li>';
                    echo '<li>Template được tạo bằng PHP include</li>';
                    echo '<li>CSS responsive cho các thiết bị</li>';
                    echo '</ul>';
                    break;
            }
            ?>
        </div>

        <!-- Right Sidebar -->
        <div class="right">
            <h3>Thông tin thêm</h3>
            <p><strong>Bài tập:</strong> 7.1 - Tạo template</p>
            <p><strong>Môn:</strong> Công nghệ Web An toàn</p>
            <p><strong>Năm:</strong> 2025</p>
            
            <h3>Chức năng</h3>
            <ul>
                <li>✅ Template hoàn chỉnh</li>
                <li>✅ Menu điều hướng</li>
                <li>✅ Layout responsive</li>
                <li>✅ Xử lý PHP cơ bản</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 - Học viện Kỹ thuật Mật mã - Lab4 - PHP Template</p>
    </div>
</body>
</html>