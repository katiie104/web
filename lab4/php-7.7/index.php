<?php
session_start();

require_once __DIR__ . '/includes/math_functions.php';
require_once __DIR__ . '/includes/string_functions.php';
require_once __DIR__ . '/includes/validation_functions.php';
require_once __DIR__ . '/includes/utilities.php';

// Xử lý form
$result = '';
$execution_time = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $function_type = $_POST['function_type'] ?? '';
    $start_time = microtime(true);
    
    switch ($function_type) {
        case 'factorial':
            $number = intval($_POST['number'] ?? 0);
            $result = "Giai thừa của $number là: " . factorial($number);
            break;
            
        case 'prime_check':
            $number = intval($_POST['number'] ?? 0);
            $result = "$number " . (isPrime($number) ? "là số nguyên tố" : "không phải số nguyên tố");
            break;
            
        case 'fibonacci':
            $number = intval($_POST['number'] ?? 0);
            $fib_sequence = fibonacci($number);
            $result = "Dãy Fibonacci $number số: " . implode(', ', $fib_sequence);
            break;
            
        case 'string_reverse':
            $text = $_POST['text'] ?? '';
            $result = "Chuỗi đảo ngược: " . reverseString($text);
            break;
            
        case 'word_count':
            $text = $_POST['text'] ?? '';
            $result = "Số từ: " . countWords($text);
            break;
            
        case 'format_currency':
            $amount = floatval($_POST['amount'] ?? 0);
            $result = "Số tiền: " . formatCurrency($amount);
            break;
            
        case 'array_max_min':
            $array_input = $_POST['array_input'] ?? '';
            $numbers = array_map('intval', explode(',', $array_input));
            $max_min = findMaxMin($numbers);
            $result = "Max: {$max_min['max']}, Min: {$max_min['min']}";
            break;
            
        case 'filter_even':
            $array_input = $_POST['array_input'] ?? '';
            $numbers = array_map('intval', explode(',', $array_input));
            $even_numbers = filterEvenNumbers($numbers);
            $result = "Số chẵn: " . implode(', ', $even_numbers);
            break;
            
        case 'validate_email':
            $email = $_POST['email'] ?? '';
            $result = "Email '$email' " . (isValidEmail($email) ? "hợp lệ" : "không hợp lệ");
            break;
            
        case 'validate_password':
            $password = $_POST['password'] ?? '';
            $validation = validatePassword($password);
            $result = $validation['valid'] ? "Mật khẩu hợp lệ" : "Lỗi: " . implode(', ', $validation['errors']);
            break;
            
        case 'vietnamese_date':
            $date = $_POST['date'] ?? date('Y-m-d');
            $result = "Ngày Việt Nam: " . formatVietnameseDate($date);
            break;
            
        case 'time_ago':
            $datetime = $_POST['datetime'] ?? date('Y-m-d H:i:s');
            $result = "Thời gian: " . timeAgo($datetime);
            break;
    }
    
    $execution_time = round((microtime(true) - $start_time) * 1000, 2); // milliseconds
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🚀 Bài 7.7 - PHP Functions & Modular Programming</title>
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
            max-width: 1200px;
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
        
        .nav-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .demo-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem 0;
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
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-info {
            background: #17a2b8;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .result {
            background: #e7f3ff;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #007bff;
            font-size: 1.1em;
        }
        
        .execution-time {
            background: #fff3cd;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin: 0.5rem 0;
            font-size: 0.9em;
            color: #856404;
        }
        
        .code-example {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
        
        .function-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .function-item {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            transition: transform 0.2s;
        }
        
        .function-item:hover {
            transform: translateX(5px);
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .demo-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin: 1rem 0;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .tab {
            padding: 10px 20px;
            background: #e9ecef;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .tab.active {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🚀 Bài 7.8 - PHP Functions & Modular Programming</h1>
            <p>Học về hàm trong PHP - Tái sử dụng code & Tổ chức chương trình</p>
            
            <div class="nav-buttons">
                <a href="../php-7.5/index.php" class="btn btn-success">🏠 Trang chủ</a>
                <a href="../php-7.5/admin/authorization.php" class="btn btn-primary">🔐 Bài 7.6</a>
                <a href="../php-7.5/cookie/cookie_demo.php" class="btn btn-warning">🍪 Bài 7.7</a>
            </div>

            <div class="demo-links">
                <a href="demos/calculator.php" class="btn btn-info">🧮 Máy Tính</a>
                <a href="demos/string_tools.php" class="btn btn-info">📝 Công Cụ Chuỗi</a>
                <a href="demos/array_manager.php" class="btn btn-info">🗂️ Quản Lý Mảng</a>
            </div>
        </div>

        <!-- Navigation Cards -->
        <div class="nav-cards">
            <div class="card">
                <h3>🧮 Math Functions</h3>
                <p>Hàm toán học: giai thừa, số nguyên tố, Fibonacci, tính tổng, trung bình...</p>
                <button class="btn btn-primary" onclick="showTab('math-tab')">Xem Demo</button>
            </div>
            
            <div class="card">
                <h3>📝 String Functions</h3>
                <p>Hàm xử lý chuỗi: đảo ngược, đếm từ, format tiền, chuyển đổi chữ hoa/thường...</p>
                <button class="btn btn-primary" onclick="showTab('string-tab')">Xem Demo</button>
            </div>
            
            <div class="card">
                <h3>🗂️ Array Functions</h3>
                <p>Hàm xử lý mảng: tìm max/min, sắp xếp, lọc số chẵn/lẻ, đếm giá trị...</p>
                <button class="btn btn-primary" onclick="showTab('array-tab')">Xem Demo</button>
            </div>
            
            <div class="card">
                <h3>✅ Validation Functions</h3>
                <p>Hàm kiểm tra dữ liệu: email, số điện thoại, mật khẩu, URL, ngày tháng...</p>
                <button class="btn btn-primary" onclick="showTab('validation-tab')">Xem Demo</button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('math-tab')">🧮 Toán Học</button>
            <button class="tab" onclick="showTab('string-tab')">📝 Chuỗi</button>
            <button class="tab" onclick="showTab('array-tab')">🗂️ Mảng</button>
            <button class="tab" onclick="showTab('validation-tab')">✅ Validation</button>
            <button class="tab" onclick="showTab('utilities-tab')">🛠️ Tiện Ích</button>
        </div>

        <!-- Results Section -->
        <?php if ($result): ?>
            <div class="demo-section">
                <h2>🎯 Kết Quả Thực Thi</h2>
                <div class="result">
                    <?= $result ?>
                </div>
                <div class="execution-time">
                    ⏱️ Thời gian thực thi: <?= $execution_time ?> ms
                </div>
            </div>
        <?php endif; ?>

        <!-- Math Functions Tab -->
        <div id="math-tab" class="tab-content active">
            <div class="demo-section">
                <h2>🧮 Math Functions Demo</h2>
                <form method="POST">
                    <input type="hidden" name="function_type" value="factorial">
                    
                    <div class="form-group">
                        <label>Chọn hàm toán học:</label>
                        <select name="math_function" onchange="showMathForm()" id="mathFunction">
                            <option value="factorial">Tính giai thừa</option>
                            <option value="prime_check">Kiểm tra số nguyên tố</option>
                            <option value="fibonacci">Dãy Fibonacci</option>
                        </select>
                    </div>

                    <div id="mathForm">
                        <div class="form-group">
                            <label>Nhập số:</label>
                            <input type="number" name="number" min="0" max="100" placeholder="Nhập số nguyên..." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Thực thi hàm</button>
                </form>
            </div>
        </div>

        <!-- String Functions Tab -->
        <div id="string-tab" class="tab-content">
            <div class="demo-section">
                <h2>📝 String Functions Demo</h2>
                <form method="POST">
                    <input type="hidden" name="function_type" value="string_reverse">
                    
                    <div class="form-group">
                        <label>Chọn hàm xử lý chuỗi:</label>
                        <select name="string_function" onchange="showStringForm()" id="stringFunction">
                            <option value="string_reverse">Đảo ngược chuỗi</option>
                            <option value="word_count">Đếm số từ</option>
                            <option value="format_currency">Format tiền tệ</option>
                        </select>
                    </div>

                    <div id="stringForm">
                        <div class="form-group">
                            <label>Nhập chuỗi/văn bản:</label>
                            <textarea name="text" rows="3" placeholder="Nhập chuỗi văn bản..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Thực thi hàm</button>
                </form>
            </div>
        </div>

        <!-- Array Functions Tab -->
        <div id="array-tab" class="tab-content">
            <div class="demo-section">
                <h2>🗂️ Array Functions Demo</h2>
                <form method="POST">
                    <input type="hidden" name="function_type" value="array_max_min">
                    
                    <div class="form-group">
                        <label>Chọn hàm xử lý mảng:</label>
                        <select name="array_function" onchange="showArrayForm()" id="arrayFunction">
                            <option value="array_max_min">Tìm Max/Min</option>
                            <option value="filter_even">Lọc số chẵn</option>
                        </select>
                    </div>

                    <div id="arrayForm">
                        <div class="form-group">
                            <label>Nhập mảng (phân cách bằng dấu phẩy):</label>
                            <input type="text" name="array_input" placeholder="VD: 1,5,3,9,2,8,4" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Thực thi hàm</button>
                </form>
            </div>
        </div>

        <!-- Validation Functions Tab -->
        <div id="validation-tab" class="tab-content">
            <div class="demo-section">
                <h2>✅ Validation Functions Demo</h2>
                <form method="POST">
                    <input type="hidden" name="function_type" value="validate_email">
                    
                    <div class="form-group">
                        <label>Chọn hàm validation:</label>
                        <select name="validation_function" onchange="showValidationForm()" id="validationFunction">
                            <option value="validate_email">Kiểm tra Email</option>
                            <option value="validate_password">Kiểm tra Mật khẩu</option>
                        </select>
                    </div>

                    <div id="validationForm">
                        <div class="form-group">
                            <label>Nhập email:</label>
                            <input type="email" name="email" placeholder="example@email.com">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Thực thi hàm</button>
                </form>
            </div>
        </div>

        <!-- Utilities Functions Tab -->
        <div id="utilities-tab" class="tab-content">
            <div class="demo-section">
                <h2>🛠️ Utility Functions Demo</h2>
                <form method="POST">
                    <input type="hidden" name="function_type" value="vietnamese_date">
                    
                    <div class="form-group">
                        <label>Chọn hàm tiện ích:</label>
                        <select name="utility_function" onchange="showUtilityForm()" id="utilityFunction">
                            <option value="vietnamese_date">Format ngày Việt Nam</option>
                            <option value="time_ago">Time Ago</option>
                        </select>
                    </div>

                    <div id="utilityForm">
                        <div class="form-group">
                            <label>Nhập ngày (YYYY-MM-DD):</label>
                            <input type="date" name="date" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🚀 Thực thi hàm</button>
                </form>
            </div>
        </div>

        <!-- Function Documentation -->
        <div class="demo-section">
            <h2>📚 Tài liệu Hàm</h2>
            
            <div class="function-grid">
                <div class="function-item">
                    <h4>🧮 factorial($n)</h4>
                    <p><strong>Mô tả:</strong> Tính giai thừa của số nguyên</p>
                    <p><strong>Tham số:</strong> $n (int)</p>
                    <p><strong>Trả về:</strong> int</p>
                </div>
                
                <div class="function-item">
                    <h4>🔢 isPrime($n)</h4>
                    <p><strong>Mô tả:</strong> Kiểm tra số nguyên tố</p>
                    <p><strong>Tham số:</strong> $n (int)</p>
                    <p><strong>Trả về:</strong> bool</p>
                </div>
                
                <div class="function-item">
                    <h4>📝 reverseString($str)</h4>
                    <p><strong>Mô tả:</strong> Đảo ngược chuỗi</p>
                    <p><strong>Tham số:</strong> $str (string)</p>
                    <p><strong>Trả về:</strong> string</p>
                </div>
                
                <div class="function-item">
                    <h4>✅ isValidEmail($email)</h4>
                    <p><strong>Mô tả:</strong> Kiểm tra định dạng email</p>
                    <p><strong>Tham số:</strong> $email (string)</p>
                    <p><strong>Trả về:</strong> bool</p>
                </div>
                
                <div class="function-item">
                    <h4>🛠️ formatVietnameseDate($date)</h4>
                    <p><strong>Mô tả:</strong> Format ngày tháng tiếng Việt</p>
                    <p><strong>Tham số:</strong> $date (string)</p>
                    <p><strong>Trả về:</strong> string</p>
                </div>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="demo-section">
            <h2>💻 Ví dụ về Function</h2>
            
            <div class="code-example">
                <h4>🔹 Hàm cơ bản với type hinting:</h4>
                <pre><code>
function calculateCircleArea(float $radius): float {
    return pi() * $radius * $radius;
}

// Sử dụng
$area = calculateCircleArea(5.5);
echo "Diện tích hình tròn: " . $area;
                </code></pre>
            </div>
            
            <div class="code-example">
                <h4>🔹 Hàm với tham số mặc định:</h4>
                <pre><code>
function greetUser(string $name, string $greeting = "Xin chào"): string {
    return "$greeting, $name!";
}

// Sử dụng
echo greetUser("John"); // Xin chào, John!
echo greetUser("Anna", "Hello"); // Hello, Anna!
                </code></pre>
            </div>

            <div class="code-example">
                <h4>🔹 Hàm với tham số không giới hạn:</h4>
                <pre><code>
function calculateSum(...$numbers): float {
    return array_sum($numbers);
}

// Sử dụng
echo calculateSum(1, 2, 3, 4, 5); // 15
echo calculateSum(10, 20, 30); // 60
                </code></pre>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabId).classList.add('active');
            
            // Add active class to clicked tab button
            event.target.classList.add('active');
        }

        // Math form show/hide
        function showMathForm() {
            const mathFunction = document.getElementById('mathFunction').value;
            document.querySelector('input[name="function_type"]').value = mathFunction;
        }

        // String form show/hide
        function showStringForm() {
            const stringFunction = document.getElementById('stringFunction').value;
            document.querySelector('input[name="function_type"]').value = stringFunction;
            
            const stringForm = document.getElementById('stringForm');
            if (stringFunction === 'format_currency') {
                stringForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập số tiền:</label>
                        <input type="number" name="amount" step="0.01" placeholder="Nhập số tiền...">
                    </div>
                `;
            } else {
                stringForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập chuỗi/văn bản:</label>
                        <textarea name="text" rows="3" placeholder="Nhập chuỗi văn bản..."></textarea>
                    </div>
                `;
            }
        }

        // Array form show/hide
        function showArrayForm() {
            const arrayFunction = document.getElementById('arrayFunction').value;
            document.querySelector('input[name="function_type"]').value = arrayFunction;
        }

        // Validation form show/hide
        function showValidationForm() {
            const validationFunction = document.getElementById('validationFunction').value;
            document.querySelector('input[name="function_type"]').value = validationFunction;
            
            const validationForm = document.getElementById('validationForm');
            if (validationFunction === 'validate_password') {
                validationForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập mật khẩu:</label>
                        <input type="password" name="password" placeholder="Nhập mật khẩu...">
                    </div>
                `;
            } else {
                validationForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập email:</label>
                        <input type="email" name="email" placeholder="example@email.com">
                    </div>
                `;
            }
        }

        // Utility form show/hide
        function showUtilityForm() {
            const utilityFunction = document.getElementById('utilityFunction').value;
            document.querySelector('input[name="function_type"]').value = utilityFunction;
            
            const utilityForm = document.getElementById('utilityForm');
            if (utilityFunction === 'time_ago') {
                utilityForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập thời gian (YYYY-MM-DD HH:MM:SS):</label>
                        <input type="datetime-local" name="datetime" value="<?= date('Y-m-d\TH:i') ?>">
                    </div>
                `;
            } else {
                utilityForm.innerHTML = `
                    <div class="form-group">
                        <label>Nhập ngày (YYYY-MM-DD):</label>
                        <input type="date" name="date" value="<?= date('Y-m-d') ?>">
                    </div>
                `;
            }
        }

        // Initialize forms
        window.onload = function() {
            showMathForm();
            showStringForm();
            showArrayForm();
            showValidationForm();
            showUtilityForm();
        };
    </script>
</body>
</html>