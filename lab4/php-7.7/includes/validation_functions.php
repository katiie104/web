<?php
/**
 * ✅ VALIDATION FUNCTIONS - Các hàm kiểm tra dữ liệu
 */

/**
 * Kiểm tra định dạng email
 * @param string $email Email cần kiểm tra
 * @return bool True nếu hợp lệ
 */
function isValidEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Kiểm tra số điện thoại Việt Nam
 * @param string $phone Số điện thoại
 * @return bool True nếu hợp lệ
 */
function isValidVietnamesePhone(string $phone): bool {
    $pattern = '/^(0[3|5|7|8|9])+([0-9]{8})$/';
    return preg_match($pattern, $phone) === 1;
}

/**
 * Kiểm tra mật khẩu mạnh
 * @param string $password Mật khẩu
 * @return array Kết quả kiểm tra
 */
function validatePassword(string $password): array {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "Mật khẩu phải có ít nhất 8 ký tự";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Mật khẩu phải có ít nhất 1 chữ hoa";
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Mật khẩu phải có ít nhất 1 chữ thường";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Mật khẩu phải có ít nhất 1 số";
    }
    
    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        $errors[] = "Mật khẩu phải có ít nhất 1 ký tự đặc biệt";
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Kiểm tra tuổi hợp lệ (18-100)
 * @param mixed $age Tuổi
 * @return bool True nếu hợp lệ
 */
function isValidAge($age): bool {
    return is_numeric($age) && $age >= 18 && $age <= 100;
}

/**
 * Kiểm tra URL hợp lệ
 * @param string $url URL cần kiểm tra
 * @return bool True nếu hợp lệ
 */
function isValidURL(string $url): bool {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Kiểm tra ngày tháng hợp lệ
 * @param string $date Ngày cần kiểm tra (YYYY-MM-DD)
 * @return bool True nếu hợp lệ
 */
function isValidDate(string $date): bool {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Làm sạch dữ liệu input
 * @param string $data Dữ liệu cần làm sạch
 * @return string Dữ liệu đã làm sạch
 */
function sanitizeInput(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Kiểm tra số nguyên dương
 * @param mixed $number Số cần kiểm tra
 * @return bool True nếu là số nguyên dương
 */
function isPositiveInteger($number): bool {
    return filter_var($number, FILTER_VALIDATE_INT) !== false && $number > 0;
}

/**
 * Kiểm tra số thực dương
 * @param mixed $number Số cần kiểm tra
 * @return bool True nếu là số thực dương
 */
function isPositiveFloat($number): bool {
    return filter_var($number, FILTER_VALIDATE_FLOAT) !== false && $number > 0;
}

/**
 * Kiểm tra chuỗi không rỗng
 * @param string $str Chuỗi cần kiểm tra
 * @return bool True nếu không rỗng
 */
function isNotEmpty(string $str): bool {
    return !empty(trim($str));
}

/**
 * Kiểm tra độ dài chuỗi trong khoảng cho phép
 * @param string $str Chuỗi cần kiểm tra
 * @param int $min Độ dài tối thiểu
 * @param int $max Độ dài tối đa
 * @return bool True nếu hợp lệ
 */
function isValidLength(string $str, int $min = 1, int $max = 255): bool {
    $length = mb_strlen($str, 'UTF-8');
    return $length >= $min && $length <= $max;
}
?>