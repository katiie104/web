<?php
require_once '../includes/math_functions.php';

$result = '';
$history = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = floatval($_POST['num1'] ?? 0);
    $num2 = floatval($_POST['num2'] ?? 0);
    $operation = $_POST['operation'] ?? 'add';
    
    switch ($operation) {
        case 'add':
            $result = $num1 + $num2;
            $symbol = '+';
            break;
        case 'subtract':
            $result = $num1 - $num2;
            $symbol = '-';
            break;
        case 'multiply':
            $result = $num1 * $num2;
            $symbol = '×';
            break;
        case 'divide':
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = 'Lỗi: Chia cho 0';
            }
            $symbol = '÷';
            break;
        case 'power':
            $result = pow($num1, $num2);
            $symbol = '^';
            break;
        case 'modulo':
            $result = $num1 % $num2;
            $symbol = '%';
            break;
        default:
            $result = 0;
            $symbol = '';
    }
    
    // Thêm vào lịch sử
    if (is_numeric($result)) {
        $history[] = [
            'expression' => "$num1 $symbol $num2",
            'result' => $result
        ];
    }
}

// Xử lý các hàm toán học đặc biệt
if (isset($_POST['special_operation'])) {
    $number = floatval($_POST['special_number'] ?? 0);
    $special_op = $_POST['special_operation'];
    
    switch ($special_op) {
        case 'factorial':
            $result = factorial(intval($number));
            $history[] = [
                'expression' => "$number!",
                'result' => $result
            ];
            break;
        case 'square_root':
            $result = $number >= 0 ? sqrt($number) : 'Lỗi: Số âm';
            $history[] = [
                'expression' => "√$number",
                'result' => $result
            ];
            break;
        case 'sin':
            $result = sin(deg2rad($number));
            $history[] = [
                'expression' => "sin($number°)",
                'result' => round($result, 4)
            ];
            break;
        case 'cos':
            $result = cos(deg2rad($number));
            $history[] = [
                'expression' => "cos($number°)",
                'result' => round($result, 4)
            ];
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🧮 Máy Tính - Bài 7.8</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            background: rgba(255,255,255,0.95);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .calculator-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .calculator, .special-calculator {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin: 1rem 0;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            width: 100%;
            margin: 5px 0;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .result {
            background: #e7f3ff;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #007bff;
            font-size: 1.2em;
            text-align: center;
        }
        
        .history {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .history-item {
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .operation-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .operation-btn {
            padding: 10px;
            border: 2px solid #007bff;
            background: white;
            color: #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .operation-btn:hover {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🧮 Máy Tính Toán Học</h1>
            <p>Demo sử dụng các hàm toán học từ Bài 7.8</p>
            
            <div class="nav-buttons">
                <a href="../index.php" class="btn btn-primary">🏠 Về Trang Chính</a>
                <a href="string_tools.php" class="btn btn-success">📝 Công Cụ Chuỗi</a>
                <a href="array_manager.php" class="btn btn-success">🗂️ Quản Lý Mảng</a>
            </div>
        </div>

        <div class="calculator-grid">
            <!-- Máy tính cơ bản -->
            <div class="calculator">
                <h2>🧮 Máy Tính Cơ Bản</h2>
                
                <?php if ($result !== ''): ?>
                    <div class="result">
                        <strong>Kết quả:</strong> <?= $result ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Số thứ nhất:</label>
                        <input type="number" name="num1" step="any" placeholder="Nhập số thứ nhất" required value="<?= $_POST['num1'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label>Phép tính:</label>
                        <select name="operation">
                            <option value="add" <?= ($_POST['operation'] ?? '') == 'add' ? 'selected' : '' ?>>Cộng (+)</option>
                            <option value="subtract" <?= ($_POST['operation'] ?? '') == 'subtract' ? 'selected' : '' ?>>Trừ (-)</option>
                            <option value="multiply" <?= ($_POST['operation'] ?? '') == 'multiply' ? 'selected' : '' ?>>Nhân (×)</option>
                            <option value="divide" <?= ($_POST['operation'] ?? '') == 'divide' ? 'selected' : '' ?>>Chia (÷)</option>
                            <option value="power" <?= ($_POST['operation'] ?? '') == 'power' ? 'selected' : '' ?>>Lũy thừa (^)</option>
                            <option value="modulo" <?= ($_POST['operation'] ?? '') == 'modulo' ? 'selected' : '' ?>>Chia lấy dư (%)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Số thứ hai:</label>
                        <input type="number" name="num2" step="any" placeholder="Nhập số thứ hai" required value="<?= $_POST['num2'] ?? '' ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Tính Toán</button>
                </form>

                <!-- Lịch sử tính toán -->
                <?php if (!empty($history)): ?>
                    <div class="history">
                        <h3>📊 Lịch sử tính toán:</h3>
                        <?php foreach (array_slice($history, -5) as $item): ?>
                            <div class="history-item">
                                <strong><?= $item['expression'] ?></strong> = <?= $item['result'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Máy tính đặc biệt -->
            <div class="special-calculator">
                <h2>🔢 Máy Tính Đặc Biệt</h2>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Nhập số:</label>
                        <input type="number" name="special_number" step="any" placeholder="Nhập số" required value="<?= $_POST['special_number'] ?? '' ?>">
                    </div>

                    <div class="operation-grid">
                        <button type="submit" name="special_operation" value="factorial" class="operation-btn">
                            n! (Giai thừa)
                        </button>
                        <button type="submit" name="special_operation" value="square_root" class="operation-btn">
                            √ (Căn bậc 2)
                        </button>
                        <button type="submit" name="special_operation" value="sin" class="operation-btn">
                            sin(x)
                        </button>
                        <button type="submit" name="special_operation" value="cos" class="operation-btn">
                            cos(x)
                        </button>
                        <button type="submit" name="special_operation" value="prime_check" class="operation-btn">
                            Số nguyên tố?
                        </button>
                        <button type="submit" name="special_operation" value="fibonacci" class="operation-btn">
                            Fibonacci(10)
                        </button>
                    </div>
                </form>

                <!-- Kết quả hàm đặc biệt -->
                <?php if (isset($_POST['special_operation'])): ?>
                    <div class="result">
                        <strong>Kết quả:</strong><br>
                        <?php
                        $special_op = $_POST['special_operation'];
                        $number = floatval($_POST['special_number'] ?? 0);
                        
                        switch ($special_op) {
                            case 'prime_check':
                                echo "$number " . (isPrime(intval($number)) ? "là số nguyên tố" : "không phải số nguyên tố");
                                break;
                            case 'fibonacci':
                                $fib_sequence = fibonacci(10);
                                echo "10 số Fibonacci đầu tiên: " . implode(', ', $fib_sequence);
                                break;
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Thông tin hàm toán học -->
                <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h3>📚 Hàm Toán Học Được Sử Dụng:</h3>
                    <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                        <li><code>factorial($n)</code> - Tính giai thừa</li>
                        <li><code>isPrime($n)</code> - Kiểm tra số nguyên tố</li>
                        <li><code>fibonacci($n)</code> - Dãy Fibonacci</li>
                        <li><code>gcd($a, $b)</code> - Ước chung lớn nhất</li>
                        <li><code>lcm($a, $b)</code> - Bội chung nhỏ nhất</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Demo các hàm toán học khác -->
        <div class="calculator" style="grid-column: 1 / -1; margin-top: 2rem;">
            <h2>🎯 Demo Các Hàm Toán Học Khác</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Ước chung lớn nhất</h4>
                    <p>GCD(48, 18) = <?= gcd(48, 18) ?></p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Bội chung nhỏ nhất</h4>
                    <p>LCM(12, 18) = <?= lcm(12, 18) ?></p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Số hoàn hảo</h4>
                    <p>28 <?= isPerfectNumber(28) ? 'là' : 'không phải' ?> số hoàn hảo</p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Làm tròn số</h4>
                    <p>roundNumber(3.14159, 2) = <?= roundNumber(3.14159, 2) ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>