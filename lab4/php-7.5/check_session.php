<?php
// check_session.php - API kiểm tra trạng thái session
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode([
        'status' => 'not_logged_in',
        'message' => 'Chưa đăng nhập',
        'username' => null,
        'active_time' => 0
    ]);
    exit;
}

// Tính thời gian hoạt động của session
$login_time = strtotime($_SESSION['login_time']);
$current_time = time();
$active_time = $current_time - $login_time;

echo json_encode([
    'status' => 'logged_in',
    'message' => 'Đã đăng nhập',
    'username' => $_SESSION['username'],
    'login_time' => $_SESSION['login_time'],
    'active_time' => $active_time,
    'session_id' => session_id()
]);
?>