<?php
/**
 * 🧮 MATH FUNCTIONS - Các hàm toán học
 */

/**
 * Tính giai thừa của một số
 * @param int $n Số nguyên dương
 * @return int|string Giai thừa hoặc thông báo lỗi
 */
function factorial(int $n) {
    if ($n < 0) return "❌ Không tính được giai thừa số âm";
    if ($n == 0 || $n == 1) return 1;
    
    $result = 1;
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

/**
 * Kiểm tra số nguyên tố
 * @param int $n Số cần kiểm tra
 * @return bool True nếu là số nguyên tố
 */
function isPrime(int $n): bool {
    if ($n < 2) return false;
    if ($n == 2) return true;
    if ($n % 2 == 0) return false;
    
    for ($i = 3; $i <= sqrt($n); $i += 2) {
        if ($n % $i == 0) return false;
    }
    return true;
}

/**
 * Tính dãy Fibonacci
 * @param int $n Số phần tử
 * @return array Dãy Fibonacci
 */
function fibonacci(int $n): array {
    if ($n <= 0) return [];
    if ($n == 1) return [0];
    if ($n == 2) return [0, 1];
    
    $fib = [0, 1];
    for ($i = 2; $i < $n; $i++) {
        $fib[] = $fib[$i-1] + $fib[$i-2];
    }
    return $fib;
}

/**
 * Tính tổng các số trong mảng
 * @param array $numbers Mảng số
 * @return float Tổng
 */
function sumArray(array $numbers): float {
    return array_sum($numbers);
}

/**
 * Tính trung bình cộng
 * @param array $numbers Mảng số
 * @return float Trung bình cộng
 */
function average(array $numbers): float {
    if (empty($numbers)) return 0;
    return array_sum($numbers) / count($numbers);
}

/**
 * Tìm ước chung lớn nhất (GCD)
 * @param int $a Số thứ nhất
 * @param int $b Số thứ hai
 * @return int GCD
 */
function gcd(int $a, int $b): int {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

/**
 * Tìm bội chung nhỏ nhất (LCM)
 * @param int $a Số thứ nhất
 * @param int $b Số thứ hai
 * @return int LCM
 */
function lcm(int $a, int $b): int {
    return ($a * $b) / gcd($a, $b);
}

/**
 * Kiểm tra số hoàn hảo (Perfect Number)
 * @param int $n Số cần kiểm tra
 * @return bool True nếu là số hoàn hảo
 */
function isPerfectNumber(int $n): bool {
    if ($n < 2) return false;
    
    $sum = 0;
    for ($i = 1; $i <= $n / 2; $i++) {
        if ($n % $i == 0) {
            $sum += $i;
        }
    }
    return $sum == $n;
}

/**
 * Tính lũy thừa
 * @param float $base Cơ số
 * @param float $exponent Số mũ
 * @return float Kết quả
 */
function power(float $base, float $exponent): float {
    return pow($base, $exponent);
}

/**
 * Làm tròn số theo số chữ số thập phân
 * @param float $number Số cần làm tròn
 * @param int $decimals Số chữ số thập phân
 * @return float Số đã làm tròn
 */
function roundNumber(float $number, int $decimals = 2): float {
    return round($number, $decimals);
}
?>