<?php
/**
 * 🛠️ UTILITY FUNCTIONS - Các hàm tiện ích
 */

/**
 * Format ngày tháng tiếng Việt
 * @param string $date Ngày cần format
 * @return string Ngày đã format
 */
function formatVietnameseDate(string $date): string {
    $timestamp = strtotime($date);
    if ($timestamp === false) return $date;
    
    $days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
    $dayOfWeek = $days[date('w', $timestamp)];
    
    return $dayOfWeek . ', ngày ' . date('d', $timestamp) . ' tháng ' . date('m', $timestamp) . ' năm ' . date('Y', $timestamp);
}

/**
 * Tạo mã màu ngẫu nhiên
 * @return string Mã màu hex
 */
function generateRandomColor(): string {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

/**
 * Tính khoảng cách giữa 2 ngày
 * @param string $startDate Ngày bắt đầu
 * @param string $endDate Ngày kết thúc
 * @return int Số ngày
 */
function daysBetween(string $startDate, string $endDate): int {
    try {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = $start->diff($end);
        return $interval->days;
    } catch (Exception $e) {
        return -1;
    }
}

/**
 * Chuyển đổi số thành chữ tiếng Việt
 * @param int $number Số cần chuyển
 * @return string Số bằng chữ
 */
function numberToWords(int $number): string {
    if ($number == 0) return 'không';
    if ($number < 0) return 'âm ' . numberToWords(abs($number));
    
    $units = ['', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
    $tens = ['', 'mười', 'hai mươi', 'ba mươi', 'bốn mươi', 'năm mươi', 
             'sáu mươi', 'bảy mươi', 'tám mươi', 'chín mươi'];
    
    if ($number < 10) {
        return $units[$number];
    }
    
    if ($number < 20) {
        return 'mười ' . ($number % 10 == 5 ? 'lăm' : $units[$number % 10]);
    }
    
    $result = $tens[floor($number / 10)];
    $unit = $number % 10;
    
    if ($unit > 0) {
        if ($unit == 1) {
            $result .= ' mốt';
        } elseif ($unit == 5) {
            $result .= ' lăm';
        } else {
            $result .= ' ' . $units[$unit];
        }
    }
    
    return $result;
}

/**
 * Tạo slug từ chuỗi
 * @param string $str Chuỗi cần tạo slug
 * @return string Slug
 */
function generateSlug(string $str): string {
    $str = mb_strtolower($str, 'UTF-8');
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
    $str = preg_replace('/[\s-]+/', ' ', $str);
    $str = preg_replace('/\s/', '-', $str);
    return $str;
}

/**
 * Đếm thời gian đã trôi qua (time ago)
 * @param string $datetime Thời gian cần tính
 * @return string Chuỗi thời gian
 */
function timeAgo(string $datetime): string {
    $time = strtotime($datetime);
    if ($time === false) return 'Thời gian không hợp lệ';
    
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return 'vài giây trước';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' phút trước';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' giờ trước';
    } elseif ($diff < 2592000) {
        $days = floor($diff / 86400);
        return $days . ' ngày trước';
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return $months . ' tháng trước';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' năm trước';
    }
}

/**
 * Format kích thước file
 * @param int $bytes Kích thước tính bằng bytes
 * @return string Kích thước đã format
 */
function formatFileSize(int $bytes): string {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}

/**
 * Tạo mã xác nhận ngẫu nhiên
 * @param int $length Độ dài mã
 * @return string Mã xác nhận
 */
function generateVerificationCode(int $length = 6): string {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $code;
}

/**
 * Kiểm tra xem có phải là ngày làm việc không
 * @param string $date Ngày cần kiểm tra
 * @return bool True nếu là ngày làm việc
 */
function isWorkday(string $date): bool {
    $timestamp = strtotime($date);
    if ($timestamp === false) return false;
    
    $dayOfWeek = date('N', $timestamp); // 1 (Monday) to 7 (Sunday)
    return $dayOfWeek >= 1 && $dayOfWeek <= 5; // Monday to Friday
}

/**
 * Lấy thông tin phiên bản PHP
 * @return array Thông tin PHP
 */
function getPHPInfo(): array {
    return [
        'version' => PHP_VERSION,
        'os' => PHP_OS,
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'upload_max_filesize' => ini_get('upload_max_filesize')
    ];
}
?>