<?php
// admin/index.php - Trang quản trị (bảo mật)
session_start();

// Kiểm tra đăng nhập - BẢO MẬT QUAN TRỌNG
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    $_SESSION['message'] = "❌ Bạn chưa đăng nhập! Vui lòng đăng nhập để truy cập khu vực quản trị.";
    $_SESSION['message_type'] = 'error';
    header('Location: ../index.php?page=login');
    exit;
}

// Kiểm tra thông tin đăng nhập (thêm lớp bảo mật)
if ($_SESSION['username'] !== 'admin' || $_SESSION['password'] !== 'admin') {
    session_destroy();
    header('Location: ../index.php?page=login');
    exit;
}

$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Bài 7.5 Session</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
        }
        .admin-header {
            background: rgba(231, 76, 60, 0.95);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .admin-nav {
            background: rgba(44, 62, 80, 0.95);
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .admin-nav a:hover {
            background: #e74c3c;
            transform: translateY(-2px);
        }
        .admin-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .admin-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            min-height: 500px;
        }
        .admin-footer {
            background: rgba(44, 62, 80, 0.95);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
        .user-info {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-logout {
            background: #e74c3c;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <h1>⚙️ Admin Panel - Khu Vực Quản Trị</h1>
        <p>Xin chào, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | IP: <?= $_SESSION['ip_address'] ?? 'Unknown' ?></p>
    </div>

    <!-- Admin Navigation -->
    <div class="admin-nav">
        <a href="index.php?page=home">🏠 Admin Home</a>
        <a href="index.php?page=upload">📁 Upload Files</a>
        <a href="pages/logout.php" class="btn-logout">🚪 Logout</a>
        <a href="../index.php">🌐 Return Home</a>
    </div>
    <!-- Thêm nút này vào somewhere trong admin/index.php -->
    <div style="text-align: center; margin: 20px;">
        <a href="authorization.php" class="btn btn-success" style="padding: 12px 24px; font-size: 1.1em;">
            🔐 Bài 7.6 - Authorization System
        </a>
    </div>

    <!-- Admin Content -->
    <div class="admin-container">
        <div class="admin-content">
            <!-- User Information -->
            <div class="user-info">
                <h3>👤 Thông Tin Phiên Đăng Nhập</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin-top: 10px;">
                    <div><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></div>
                    <div><strong>Login Time:</strong> <?= $_SESSION['login_time'] ?></div>
                    <div><strong>Session ID:</strong> <?= session_id() ?></div>
                    <div><strong>IP Address:</strong> <?= $_SESSION['ip_address'] ?? 'Unknown' ?></div>
                </div>
            </div>

            <!-- Hiển thị thông báo -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success' ?>">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>

            <!-- Nội dung trang -->
            <?php
            switch ($page) {
                case 'upload':
                    include 'pages/upload.php';
                    break;
                case 'home':
                default:
                    include 'pages/home.php';
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Admin Footer -->
    <div class="admin-footer">
        <p>© 2025 - Admin Panel - Bài 7.5 Session - Đăng nhập lúc: <?= $_SESSION['login_time'] ?? 'Unknown' ?></p>
    </div>
</body>
</html>