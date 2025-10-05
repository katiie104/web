<?php
// refresh_session.php - Làm mới session
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Không thể làm mới session: chưa đăng nhập'
    ]);
    exit;
}

// Làm mới session bằng cách cập nhật thời gian
$_SESSION['last_activity'] = time();

echo json_encode([
    'success' => true,
    'message' => 'Session đã được làm mới',
    'new_lifetime' => ini_get('session.gc_maxlifetime'),
    'last_activity' => $_SESSION['last_activity']
]);
?>