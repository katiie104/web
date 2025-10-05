<?php
// php-7.5/index.php - Bài 7.5: Session (End User)
session_start();

// Chuyển hướng nếu đã đăng nhập
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    header('Location: admin/index.php');
    exit;
}

$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.5 - Session - Trần Hồng Khang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            color: #2c3e50;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .menu {
            background: rgba(44, 62, 80, 0.95);
            padding: 18px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .menu a:hover {
            background: #e74c3c;
            transform: translateY(-2px);
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            backdrop-filter: blur(10px);
        }
        .footer {
            background: rgba(44, 62, 80, 0.95);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 5px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.3s ease;
        }
        .form-group input:focus {
            border-color: #e74c3c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 500;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .session-info {
            background: #d6eaf8;
            color: #1b4f72;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🔐 Bài 7.5 - Session & Authentication</h1>
        <p>MSSV: 29_TRANHONGKHANG - Xử lý phiên đăng nhập</p>
    </div>

    <!-- Menu Navigation -->
    <div class="menu">
        <a href="index.php?page=home">🏠 Home</a>
        <a href="index.php?page=login">🔐 Login</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="admin/index.php">⚙️ Admin Panel</a>
            <a href="admin/logout.php">🚪 Logout</a>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="content">
            <?php
            // Hiển thị thông báo từ session
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-' . ($_SESSION['message_type'] ?? 'success') . '">';
                echo $_SESSION['message'];
                echo '</div>';
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }

            // Include trang tương ứng
            switch ($page) {
                case 'login':
                    include 'pages/login.php';
                    break;
                case 'home':
                default:
                    include 'pages/home.php';
                    break;
            }
            ?>
        </div>
    </div>
 
    <div style="text-align: center; margin: 20px;">
        <a href="cookie/cookie_demo.php" class="btn btn-warning" style="padding: 12px 24px; font-size: 1.1em;">
        🍪 Bài 7.6 - Cookie Management
        </a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2025 - Trần Hồng Khang - 29_TRANHONGKHANG - Bài 7.5: Session</p>
    </div>

    <script>
        // Auto-focus vào input đầu tiên của form
        document.querySelector('input')?.focus();

        // Hiệu ứng cho form inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>