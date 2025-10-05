<?php
/**
 * 📝 STRING FUNCTIONS - Các hàm xử lý chuỗi
 */

/**
 * Đảo ngược chuỗi
 * @param string $str Chuỗi cần đảo ngược
 * @return string Chuỗi đảo ngược
 */
function reverseString(string $str): string {
    return strrev($str);
}

/**
 * Đếm số từ trong chuỗi
 * @param string $str Chuỗi cần đếm
 * @return int Số từ
 */
function countWords(string $str): int {
    $str = trim($str);
    if (empty($str)) return 0;
    
    $words = preg_split('/\s+/', $str);
    return count($words);
}

/**
 * Chuyển chuỗi thành chữ hoa
 * @param string $str Chuỗi cần chuyển
 * @return string Chuỗi chữ hoa
 */
function toUpperCase(string $str): string {
    return mb_strtoupper($str, 'UTF-8');
}

/**
 * Chuyển chuỗi thành chữ thường
 * @param string $str Chuỗi cần chuyển
 * @return string Chuỗi chữ thường
 */
function toLowerCase(string $str): string {
    return mb_strtolower($str, 'UTF-8');
}

/**
 * Format tiền tệ Việt Nam
 * @param float $amount Số tiền
 * @return string Chuỗi định dạng tiền
 */
function formatCurrency(float $amount): string {
    return number_format($amount, 0, ',', '.') . ' ₫';
}

/**
 * Giới hạn độ dài chuỗi
 * @param string $str Chuỗi cần giới hạn
 * @param int $length Độ dài tối đa
 * @return string Chuỗi đã giới hạn
 */
function truncateString(string $str, int $length = 50): string {
    if (mb_strlen($str, 'UTF-8') <= $length) {
        return $str;
    }
    return mb_substr($str, 0, $length, 'UTF-8') . '...';
}

/**
 * Xóa khoảng trắng thừa
 * @param string $str Chuỗi cần xử lý
 * @return string Chuỗi đã được làm sạch
 */
function removeExtraSpaces(string $str): string {
    return preg_replace('/\s+/', ' ', trim($str));
}

/**
 * Đếm số ký tự (không tính khoảng trắng)
 * @param string $str Chuỗi cần đếm
 * @return int Số ký tự
 */
function countCharacters(string $str): int {
    $str = preg_replace('/\s+/', '', $str);
    return mb_strlen($str, 'UTF-8');
}

/**
 * Kiểm tra chuỗi có phải là palindrome không
 * @param string $str Chuỗi cần kiểm tra
 * @return bool True nếu là palindrome
 */
function isPalindrome(string $str): bool {
    $str = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($str));
    return $str === strrev($str);
}

/**
 * Tách chuỗi thành mảng các từ
 * @param string $str Chuỗi cần tách
 * @return array Mảng các từ
 */
function splitIntoWords(string $str): array {
    return preg_split('/\s+/', trim($str));
}

/**
 * Thay thế nhiều từ trong chuỗi
 * @param string $str Chuỗi gốc
 * @param array $replacements Mảng thay thế ['từ_cũ' => 'từ_mới']
 * @return string Chuỗi đã thay thế
 */
function replaceMultiple(string $str, array $replacements): string {
    return str_replace(array_keys($replacements), array_values($replacements), $str);
}

/**
 * Mã hóa chuỗi thành Base64
 * @param string $str Chuỗi cần mã hóa
 * @return string Chuỗi đã mã hóa
 */
function base64Encode(string $str): string {
    return base64_encode($str);
}

/**
 * Giải mã chuỗi từ Base64
 * @param string $str Chuỗi cần giải mã
 * @return string Chuỗi đã giải mã
 */
function base64Decode(string $str): string {
    return base64_decode($str);
}
?>