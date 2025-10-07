<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: ../pages/login.php');
    exit;
}
 
// Thiết lập role - lẽ ra phải lấy từ database nhưng chưa làm đến bài đấy
$user_role = $_SESSION['role'] ?? 'user';

$allowed_pages = [
    'dashboard' => ['user', 'manager', 'admin', 'super_admin'],
    'admin' => ['admin', 'super_admin'],
    'manager' => ['manager', 'admin', 'super_admin'], 
    'user' => ['user', 'manager', 'admin', 'super_admin'],
    'profile' => ['user', 'manager', 'admin', 'super_admin'],
    'upload' => ['user', 'manager', 'admin', 'super_admin']
];

// Lấy trang hiện tại
$current_page = $_GET['page'] ?? 'dashboard';

// Kiểm tra quyền truy cập
function checkPermission($page, $role, $allowed_pages) {
    return in_array($role, $allowed_pages[$page] ?? ['user']);
}

// Xử lý không có quyền
if (!checkPermission($current_page, $user_role, $allowed_pages)) {
    http_response_code(403);
    die("
        <div style='text-align: center; padding: 50px; font-family: Arial;'>
            <h1 style='color: #dc3545;'>🚫 403 - Truy Cập Bị Từ Chối</h1>
            <p>Bạn không có quyền truy cập trang này.</p>
            <a href='authorization.php?page=dashboard' style='color: #007bff;'>Quay về Dashboard</a>
        </div>
    ");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.6 - Authorization System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        
        .header { background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: white; padding: 1.5rem; }
        .user-info { float: right; text-align: right; }
        
        .nav { background: #343a40; overflow: hidden; }
        .nav a { float: left; color: white; text-align: center; padding: 16px 20px; text-decoration: none; transition: background 0.3s; }
        .nav a:hover { background: #495057; }
        .nav a.active { background: #007bff; }
        
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        
        .card { background: white; padding: 25px; margin: 20px 0; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 4px solid #007bff; }
        
        .role-badge { 
            display: inline-block; 
            padding: 5px 12px; 
            border-radius: 20px; 
            font-size: 0.8em; 
            font-weight: bold; 
            margin-left: 10px; 
        }
        .admin { background: #dc3545; color: white; }
        .manager { background: #fd7e14; color: white; }
        .user { background: #28a745; color: white; }
        .super_admin { background: #6f42c1; color: white; }
        
        .permission-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 25px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .permission-table th, 
        .permission-table td { 
            padding: 15px; 
            text-align: center; 
            border: 1px solid #dee2e6; 
        }
        .permission-table th { 
            background: #343a40; 
            color: white; 
            font-weight: bold;
        }
        .permission-table tr:nth-child(even) { 
            background: #f8f9fa; 
        }
        
        .btn { 
            padding: 10px 20px; 
            margin: 5px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-primary:hover { background: #0056b3; }
        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #1e7e34; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        
        .demo-tool { 
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 25px; 
            border-radius: 10px; 
            margin: 25px 0; 
            border: 2px dashed #007bff;
        }
        
        .access-denied { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 20px; 
            border-radius: 8px; 
            margin: 15px 0;
            border-left: 4px solid #dc3545;
        }
        
        .access-granted { 
            background: #d4edda; 
            color: #155724; 
            padding: 20px; 
            border-radius: 8px; 
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Bài 7.6 - Authorization & Access Control</h1>
        <div class="user-info">
            👤 <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
            <span class="role-badge <?= $user_role ?>"><?= strtoupper($user_role) ?></span>
            <br>
            <a href="../index.php" class="btn btn-success" style="margin-top: 10px; padding: 8px 15px;">🏠 Trang chủ</a>
            <a href="pages/logout.php" class="btn btn-danger" style="margin-top: 10px; padding: 8px 15px;">🚪 Đăng xuất</a>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="nav">
        <a href="?page=dashboard" class="<?= $current_page == 'dashboard' ? 'active' : '' ?>">📊 Dashboard</a>
        <a href="?page=admin" class="<?= $current_page == 'admin' ? 'active' : '' ?>">👨‍💼 Admin Panel</a>
        <a href="?page=manager" class="<?= $current_page == 'manager' ? 'active' : '' ?>">📈 Manager Area</a>
        <a href="?page=user" class="<?= $current_page == 'user' ? 'active' : '' ?>">👤 User Area</a>
        <a href="upload.php" class="<?= $current_page == 'upload' ? 'active' : '' ?>">📤 Upload Area</a>
        <a href="?page=profile" class="<?= $current_page == 'profile' ? 'active' : '' ?>">⚙️ Profile</a>
    </div>

    <div class="container">
        <?php
        // Hiển thị nội dung theo trang
        switch ($current_page) {
            case 'dashboard':
                echo '<h2>📊 Dashboard - Tổng quan hệ thống</h2>';
                echo '<div class="card">';
                echo '<div class="access-granted">';
                echo '✅ <strong>Bạn có quyền truy cập trang này!</strong>';
                echo '</div>';
                echo '<h3>Chào mừng, ' . htmlspecialchars($_SESSION['username']) . '!</h3>';
                echo '<p><strong>Vai trò:</strong> <span class="role-badge ' . $user_role . '">' . strtoupper($user_role) . '</span></p>';
                echo '<p><strong>Thời gian đăng nhập:</strong> ' . ($_SESSION['login_time'] ?? 'N/A') . '</p>';
                echo '<p><strong>IP address:</strong> ' . ($_SESSION['ip_address'] ?? 'N/A') . '</p>';
                echo '</div>';
                break;
                
            case 'admin':
                echo '<h2>👨‍💼 Admin Panel</h2>';
                echo '<div class="card">';
                if (in_array($user_role, ['admin', 'super_admin'])) {
                    echo '<div class="access-granted">';
                    echo '✅ <strong>Bạn có quyền truy cập trang Admin!</strong>';
                    echo '</div>';
                    echo '<p>Đây là khu vực dành cho Administrator. Chỉ có Admin và Super Admin mới có quyền truy cập.</p>';
                    echo '<button class="btn btn-primary">Quản lý người dùng</button>';
                    echo '<button class="btn btn-primary">Cấu hình hệ thống</button>';
                    echo '<button class="btn btn-primary">Xem logs hệ thống</button>';
                } else {
                    echo '<div class="access-denied">';
                    echo '❌ <strong>Bạn không có quyền truy cập trang Admin!</strong>';
                    echo '</div>';
                }
                echo '</div>';
                break;
                
            case 'manager':
                echo '<h2>📈 Khu vực Quản lý</h2>';
                echo '<div class="card">';
                if (in_array($user_role, ['manager', 'admin', 'super_admin'])) {
                    echo '<div class="access-granted">';
                    echo '✅ <strong>Bạn có quyền truy cập trang Manager!</strong>';
                    echo '</div>';
                    echo '<p>Khu vực dành cho Manager và các role cao hơn.</p>';
                    echo '<button class="btn btn-success">Quản lý dự án</button>';
                    echo '<button class="btn btn-success">Báo cáo hiệu suất</button>';
                } else {
                    echo '<div class="access-denied">';
                    echo '❌ <strong>Bạn không có quyền truy cập trang Manager!</strong>';
                    echo '</div>';
                }
                echo '</div>';
                break;
                
            case 'user':
                echo '<h2>👤 Khu vực Người dùng</h2>';
                echo '<div class="card">';
                echo '<div class="access-granted">';
                echo '✅ <strong>Bạn có quyền truy cập trang User!</strong>';
                echo '</div>';
                echo '<p>Khu vực dành cho tất cả người dùng đã đăng nhập.</p>';
                echo '<button class="btn">Cập nhật hồ sơ</button>';
                echo '<button class="btn">Đổi mật khẩu</button>';
                echo '</div>';
                break;
                
            case 'profile':
                echo '<h2>⚙️ Quản lý Hồ sơ</h2>';
                echo '<div class="card">';
                echo '<div class="access-granted">';
                echo '✅ <strong>Bạn có quyền truy cập trang Profile!</strong>';
                echo '</div>';
                echo '<form>';
                echo '<div style="margin: 15px 0;"><label><strong>Username:</strong></label> ';
                echo '<input type="text" value="' . htmlspecialchars($_SESSION['username']) . '" readonly style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 200px;"></div>';
                echo '<div style="margin: 15px 0;"><label><strong>Role:</strong></label> ';
                echo '<span class="role-badge ' . $user_role . '">' . strtoupper($user_role) . '</span></div>';
                echo '<button type="submit" class="btn btn-primary">💾 Cập nhật thông tin</button>';
                echo '</form>';
                echo '</div>';
                break;
        }
        ?>

        <div class="card">
            <h3>📋 Ma trận Phân quyền Hệ thống</h3>
            <table class="permission-table">
                <thead>
                    <tr>
                        <th>Trang/Chức năng</th>
                        <th>User</th>
                        <th>Manager</th>
                        <th>Admin</th>
                        <th>Super Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Dashboard</strong></td>
                        <td>✅</td><td>✅</td><td>✅</td><td>✅</td>
                    </tr>
                    <tr>
                        <td><strong>User Area</strong></td>
                        <td>✅</td><td>✅</td><td>✅</td><td>✅</td>
                    </tr>
                    <tr>
                        <td><strong>Manager Area</strong></td>
                        <td>❌</td><td>✅</td><td>✅</td><td>✅</td>
                    </tr>
                    <tr>
                        <td><strong>Admin Panel</strong></td>
                        <td>❌</td><td>❌</td><td>✅</td><td>✅</td>
                    </tr>
                    <tr>
                        <td><strong>Upload Area</strong></td>
                        <td>✅</td><td>✅</td><td>✅</td><td>✅</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="demo-tool">
            <h4>🔧 Công cụ Kiểm tra Quyền (Demo)</h4>
            <p>Thử nghiệm các role khác nhau để kiểm tra phân quyền:</p>
            <form method="post" style="margin: 15px 0;">
                <label><strong>Chọn role demo:</strong></label>
                <select name="demo_role" style="padding: 8px; margin: 0 15px; border: 2px solid #007bff; border-radius: 5px;">
                    <option value="user" <?= $user_role == 'user' ? 'selected' : '' ?>>User</option>
                    <option value="manager" <?= $user_role == 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="admin" <?= $user_role == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="super_admin" <?= $user_role == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                </select>
                <button type="submit" name="change_demo_role" class="btn btn-primary">🔄 Áp dụng Role</button>
                <small style="display: block; margin-top: 8px; color: #666;">* Thay đổi này chỉ có tác dụng trong phiên làm việc hiện tại</small>
            </form>
            
            <?php
            if (isset($_POST['change_demo_role'])) {
                $_SESSION['role'] = $_POST['demo_role'];
                echo '<div style="color: green; margin-top: 15px; padding: 10px; background: #d4edda; border-radius: 5px;">';
                echo '✅ Đã thay đổi role thành: <strong>' . $_POST['demo_role'] . '</strong>';
                echo '</div>';
                echo '<meta http-equiv="refresh" content="2;url=?page=' . $current_page . '">';
            }
            ?>
        </div>
    </div>

    <script>
    // Ẩn các menu không có quyền truy cập
    document.addEventListener('DOMContentLoaded', function() {
        const currentRole = '<?= $user_role ?>';
        const allowedPages = <?= json_encode($allowed_pages) ?>;
        
        document.querySelectorAll('.nav a').forEach(link => {
            const href = link.getAttribute('href');
            if (href.includes('page=')) {
                const page = href.split('page=')[1];
                if (page && !allowedPages[page]?.includes(currentRole)) {
                    link.style.opacity = '0.5';
                    link.style.pointerEvents = 'none';
                    link.title = 'Không có quyền truy cập';
                }
            }
        });
    });
    </script>
</body>
</html>