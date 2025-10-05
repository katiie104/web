<?php
// admin/pages/logout.php - Xử lý đăng xuất
session_start();

// Ghi log đăng xuất
$username = $_SESSION['username'] ?? 'Unknown';
$login_time = $_SESSION['login_time'] ?? 'Unknown';
$logout_time = date('Y-m-d H:i:s');

// Tính thời gian đăng nhập
$session_duration = 'Unknown';
if ($login_time !== 'Unknown') {
    $duration = strtotime($logout_time) - strtotime($login_time);
    $session_duration = gmdate('H:i:s', $duration);
}

// Hủy toàn bộ session data
$_SESSION = array(); // Xóa tất cả biến session

// Xóa cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Bắt đầu session mới để hiển thị thông báo
session_start();
$_SESSION['message'] = "👋 Đã đăng xuất thành công! Tạm biệt <strong>$username</strong>.";
$_SESSION['message_type'] = 'success';
$_SESSION['logout_info'] = [
    'username' => $username,
    'login_time' => $login_time,
    'logout_time' => $logout_time,
    'session_duration' => $session_duration
];

// Chuyển hướng về trang chủ
header('Location: ../../index.php?page=home');
exit;
?>