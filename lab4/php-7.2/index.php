<?php
// php-7.2/index.php - Bài 7.2: Sử dụng template
$page = isset($_GET['page']) ? $_GET['page'] : 'center';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.2 - Sử dụng Template - Trần Hồng Khang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Bài 7.2 - Sử dụng Template - Trần Hồng Khang</h1>
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="index.php?page=center">Trang Chủ</a>
        <a href="index.php?page=calculate">Calculate</a>
        <a href="index.php?page=drawtable">DrawTable</a>
        <a href="index.php?page=register">Register</a>
        <a href="index.php?page=contact">Contact</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Left Sidebar -->
        <div class="left">
            <h3>Menu Chức Năng</h3>
            <ul>
                <li><a href="index.php?page=center">🏠 Trang chủ</a></li>
                <li><a href="index.php?page=calculate">🧮 Tính toán</a></li>
                <li><a href="index.php?page=drawtable">📊 Vẽ bảng</a></li>
                <li><a href="index.php?page=register">📝 Đăng ký</a></li>
                <li><a href="index.php?page=contact">📞 Liên hệ</a></li>
            </ul>
            
            <h3>Thông tin SV</h3>
            <p><strong>Họ tên:</strong> Trần Hồng Khang</p>
            <p><strong>MSSV:</strong> 29_TRANHONGKHANG</p>
        </div>

        <!-- Center Content -->
        <div class="center">
            <?php
            // Include nội dung trang tương ứng
            switch ($page) {
                case 'calculate':
                    include 'pages/Calculate.php';
                    break;
                
                case 'drawtable':
                    include 'pages/DrawTable.php';
                    break;
                
                case 'register':
                    include 'pages/Register.php';
                    break;
                
                case 'contact':
                    include 'pages/Contact.php';
                    break;
                
                case 'center':
                default:
                    echo '<h2>Trang Chủ - Bài 7.2: Sử dụng Template</h2>';
                    echo '<p>Chào mừng đến với bài tập 7.2 - Sử dụng template trong PHP</p>';
                    
                    echo '<h3>Các chức năng có sẵn:</h3>';
                    echo '<ul>';
                    echo '<li><strong>Calculate:</strong> Tính toán cơ bản</li>';
                    echo '<li><strong>DrawTable:</strong> Vẽ bảng động</li>';
                    echo '<li><strong>Register:</strong> Form đăng ký</li>';
                    echo '<li><strong>Contact:</strong> Form liên hệ</li>';
                    echo '</ul>';
                    
                    echo '<h3>Hướng dẫn sử dụng:</h3>';
                    echo '<p>Chọn chức năng từ menu trên hoặc menu trái để bắt đầu.</p>';
                    break;
            }
            ?>
        </div>

        <!-- Right Sidebar -->
        <div class="right">
            <h3>Thông tin Bài 7.2</h3>
            <p><strong>Mục tiêu:</strong> Sử dụng template</p>
            <p><strong>Template:</strong> Có sẵn từ bài 7.1</p>
            <p><strong>Chức năng:</strong> Đa dạng</p>
            
            <h3>Trạng thái</h3>
            <ul>
                <li>Template hoàn chỉnh</li>
                <li>Tính toán động</li>
                <li>Form đăng ký</li>
                <li>Xử lý dữ liệu</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 - HVKTMM - Bài 7.2: Sử dụng Template</p>
    </div>
</body>
</html>