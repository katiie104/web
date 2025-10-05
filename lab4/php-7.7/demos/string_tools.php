<?php
require_once '../includes/string_functions.php';
require_once '../includes/validation_functions.php';

$result = '';
$input_text = '';
$operation = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_text = $_POST['text'] ?? '';
    $operation = $_POST['operation'] ?? '';
    
    switch ($operation) {
        case 'reverse':
            $result = reverseString($input_text);
            break;
        case 'word_count':
            $result = "Số từ: " . countWords($input_text);
            break;
        case 'char_count':
            $result = "Số ký tự (không khoảng trắng): " . countCharacters($input_text);
            break;
        case 'uppercase':
            $result = toUpperCase($input_text);
            break;
        case 'lowercase':
            $result = toLowerCase($input_text);
            break;
        case 'remove_spaces':
            $result = removeExtraSpaces($input_text);
            break;
        case 'truncate':
            $length = intval($_POST['truncate_length'] ?? 50);
            $result = truncateString($input_text, $length);
            break;
        case 'palindrome_check':
            $is_palindrome = isPalindrome($input_text);
            $result = "Chuỗi '" . $input_text . "' " . ($is_palindrome ? "là" : "không phải") . " palindrome";
            break;
        case 'slug':
            $result = generateSlug($input_text);
            break;
        case 'base64_encode':
            $result = base64Encode($input_text);
            break;
        case 'base64_decode':
            $result = base64Decode($input_text);
            break;
    }
}

// Xử lý validation
if (isset($_POST['validate'])) {
    $validate_type = $_POST['validate_type'] ?? '';
    $validate_value = $_POST['validate_value'] ?? '';
    
    switch ($validate_type) {
        case 'email':
            $is_valid = isValidEmail($validate_value);
            $result = "Email '$validate_value' " . ($is_valid ? "hợp lệ ✅" : "không hợp lệ ❌");
            break;
        case 'phone':
            $is_valid = isValidVietnamesePhone($validate_value);
            $result = "Số điện thoại '$validate_value' " . ($is_valid ? "hợp lệ ✅" : "không hợp lệ ❌");
            break;
        case 'password':
            $validation = validatePassword($validate_value);
            if ($validation['valid']) {
                $result = "Mật khẩu hợp lệ ✅";
            } else {
                $result = "Mật khẩu không hợp lệ: " . implode(', ', $validation['errors']);
            }
            break;
        case 'url':
            $is_valid = isValidURL($validate_value);
            $result = "URL '$validate_value' " . ($is_valid ? "hợp lệ ✅" : "không hợp lệ ❌");
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📝 Công Cụ Chuỗi - Bài 7.8</title>
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
            max-width: 1000px;
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
        
        .tools-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .tool-section {
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
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            margin: 5px;
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
            word-break: break-all;
        }
        
        .operation-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .operation-btn {
            padding: 10px;
            border: 2px solid #28a745;
            background: white;
            color: #28a745;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9em;
        }
        
        .operation-btn:hover {
            background: #28a745;
            color: white;
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .function-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📝 Công Cụ Xử Lý Chuỗi</h1>
            <p>Demo sử dụng các hàm xử lý chuỗi từ Bài 7.8</p>
            
            <div class="nav-buttons">
                <a href="../index.php" class="btn btn-primary">🏠 Về Trang Chính</a>
                <a href="calculator.php" class="btn btn-success">🧮 Máy Tính</a>
                <a href="array_manager.php" class="btn btn-success">🗂️ Quản Lý Mảng</a>
            </div>
        </div>

        <div class="tools-grid">
            <!-- Xử lý chuỗi cơ bản -->
            <div class="tool-section">
                <h2>📝 Xử Lý Chuỗi Cơ Bản</h2>
                
                <?php if ($result && !isset($_POST['validate'])): ?>
                    <div class="result">
                        <strong>Kết quả:</strong><br>
                        <?= htmlspecialchars($result) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Nhập chuỗi/văn bản:</label>
                        <textarea name="text" placeholder="Nhập chuỗi văn bản cần xử lý..." required><?= htmlspecialchars($input_text) ?></textarea>
                    </div>

                    <div class="operation-grid">
                        <button type="submit" name="operation" value="reverse" class="operation-btn">
                            Đảo ngược
                        </button>
                        <button type="submit" name="operation" value="word_count" class="operation-btn">
                            Đếm từ
                        </button>
                        <button type="submit" name="operation" value="char_count" class="operation-btn">
                            Đếm ký tự
                        </button>
                        <button type="submit" name="operation" value="uppercase" class="operation-btn">
                            CHỮ HOA
                        </button>
                        <button type="submit" name="operation" value="lowercase" class="operation-btn">
                            chữ thường
                        </button>
                        <button type="submit" name="operation" value="remove_spaces" class="operation-btn">
                            Xóa khoảng trắng thừa
                        </button>
                        <button type="submit" name="operation" value="palindrome_check" class="operation-btn">
                            Kiểm tra Palindrome
                        </button>
                        <button type="submit" name="operation" value="slug" class="operation-btn">
                            Tạo Slug
                        </button>
                    </div>

                    <div class="form-group">
                        <label>Độ dài tối đa (cho truncate):</label>
                        <input type="number" name="truncate_length" value="50" min="1" max="500">
                    </div>

                    <div class="operation-grid">
                        <button type="submit" name="operation" value="truncate" class="operation-btn">
                            Giới hạn độ dài
                        </button>
                        <button type="submit" name="operation" value="base64_encode" class="operation-btn">
                            Base64 Encode
                        </button>
                        <button type="submit" name="operation" value="base64_decode" class="operation-btn">
                            Base64 Decode
                        </button>
                    </div>
                </form>
            </div>

            <!-- Validation Tools -->
            <div class="tool-section">
                <h2>✅ Công Cụ Validation</h2>
                
                <?php if ($result && isset($_POST['validate'])): ?>
                    <div class="result">
                        <strong>Kết quả:</strong><br>
                        <?= htmlspecialchars($result) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Chọn loại validation:</label>
                        <select name="validate_type" id="validateType" onchange="updateValidationPlaceholder()">
                            <option value="email">Email</option>
                            <option value="phone">Số điện thoại VN</option>
                            <option value="password">Mật khẩu</option>
                            <option value="url">URL</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Giá trị cần kiểm tra:</label>
                        <input type="text" name="validate_value" id="validateValue" 
                               placeholder="example@email.com" required>
                    </div>

                    <button type="submit" name="validate" value="1" class="btn btn-primary" style="width: 100%;">
                        🚀 Kiểm Tra
                    </button>
                </form>

                <!-- Demo các hàm chuỗi -->
                <div class="function-info">
                    <h3>🎯 Demo Các Hàm Chuỗi</h3>
                    <?php
                    $sample_text = "   Xin chào   thế giới PHP   ";
                    ?>
                    <div style="margin: 0.5rem 0;">
                        <strong>Chuỗi mẫu:</strong> "<?= $sample_text ?>"
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin: 0.5rem 0;">
                        <div style="padding: 0.5rem; background: #e7f3ff; border-radius: 5px;">
                            <small>removeExtraSpaces():</small><br>
                            "<?= removeExtraSpaces($sample_text) ?>"
                        </div>
                        <div style="padding: 0.5rem; background: #e7f3ff; border-radius: 5px;">
                            <small>countWords():</small><br>
                            <?= countWords($sample_text) ?> từ
                        </div>
                        <div style="padding: 0.5rem; background: #e7f3ff; border-radius: 5px;">
                            <small>toUpperCase():</small><br>
                            "<?= toUpperCase($sample_text) ?>"
                        </div>
                        <div style="padding: 0.5rem; background: #e7f3ff; border-radius: 5px;">
                            <small>generateSlug():</small><br>
                            "<?= generateSlug($sample_text) ?>"
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Format và tiện ích -->
        <div class="tool-section" style="grid-column: 1 / -1; margin-top: 2rem;">
            <h2>💰 Format & Tiện Ích</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Format tiền tệ</h4>
                    <p>1,000,000 = <?= formatCurrency(1000000) ?></p>
                    <p>2,500.75 = <?= formatCurrency(2500.75) ?></p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Kiểm tra Palindrome</h4>
                    <p>"radar" = <?= isPalindrome('radar') ? '✅' : '❌' ?></p>
                    <p>"hello" = <?= isPalindrome('hello') ? '✅' : '❌' ?></p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Base64 Encode/Decode</h4>
                    <p>"Hello" → "<?= base64Encode('Hello') ?>"</p>
                    <p>"SGVsbG8=" → "<?= base64Decode('SGVsbG8=') ?>"</p>
                </div>
                
                <div style="padding: 1rem; background: #e7f3ff; border-radius: 8px;">
                    <h4>Thay thế nhiều từ</h4>
                    <?php
                    $text = "Tôi thích táo và chuối";
                    $replacements = ['táo' => 'cam', 'chuối' => 'xoài'];
                    ?>
                    <p>"<?= $text ?>" → "<?= replaceMultiple($text, $replacements) ?>"</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateValidationPlaceholder() {
            const type = document.getElementById('validateType').value;
            const input = document.getElementById('validateValue');
            
            const placeholders = {
                'email': 'example@email.com',
                'phone': '0912345678',
                'password': 'Nhập mật khẩu...',
                'url': 'https://example.com'
            };
            
            input.placeholder = placeholders[type] || '';
        }
        
        // Khởi tạo placeholder
        window.onload = updateValidationPlaceholder;
    </script>
</body>
</html>