<?php
require_once '../includes/csv_functions.php';
require_once '../includes/file_functions.php';

$result = '';
$csv_data = [];
$csv_info = [];

// Xử lý CSV operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'read_csv':
                $filename = $_POST['csv_file'] ?? '';
                $filepath = "files/data/{$filename}";
                $has_header = isset($_POST['has_header']);
                
                $csv_data = readCSV($filepath, $has_header);
                $csv_info = getCSVInfo($filepath);
                $result = "✅ Đã đọc file CSV: {$filename}";
                break;
                
            case 'create_csv':
                $filename = sanitizeFilename($_POST['new_csv_name'] ?? '') . '.csv';
                $headers = explode(',', $_POST['headers'] ?? '');
                $sample_data = $_POST['sample_data'] ?? '';
                
                // Tạo dữ liệu mẫu
                $data = [];
                if (!empty($sample_data)) {
                    $rows = explode("\n", $sample_data);
                    foreach ($rows as $row) {
                        $data[] = explode(',', trim($row));
                    }
                }
                
                $filepath = "files/data/{$filename}";
                if (writeCSV($filepath, $data, $headers)) {
                    $result = "✅ Đã tạo file CSV: {$filename}";
                } else {
                    $result = "❌ Lỗi khi tạo file CSV";
                }
                break;
                
            case 'search_csv':
                $filename = $_POST['search_file'] ?? '';
                $search_term = $_POST['search_term'] ?? '';
                $filepath = "files/data/{$filename}";
                
                $search_results = searchInCSV($filepath, $search_term);
                $result = "🔍 Tìm thấy " . count($search_results) . " kết quả cho '{$search_term}'";
                $csv_data = array_column($search_results, 'data');
                break;
                
            case 'export_csv':
                $filename = "export_" . date('Y-m-d_H-i-s') . '.csv';
                $headers = $_POST['export_headers'] ? explode(',', $_POST['export_headers']) : [];
                $data = [];
                
                // Tạo dữ liệu mẫu để export
                for ($i = 1; $i <= 10; $i++) {
                    $data[] = [
                        "ID" => $i,
                        "Name" => "User " . $i,
                        "Email" => "user{$i}@example.com",
                        "Age" => rand(20, 50),
                        "City" => ["Hanoi", "HCMC", "Danang"][rand(0, 2)]
                    ];
                }
                
                $filepath = "files/data/{$filename}";
                if (writeCSV($filepath, $data, $headers)) {
                    $result = "✅ Đã export file CSV: {$filename}";
                    $csv_data = $data;
                    $csv_info = ['total_rows' => count($data), 'total_columns' => count($headers)];
                }
                break;
        }
    } catch (Exception $e) {
        $result = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy danh sách file CSV
$csv_files = listFilesInDirectory('files/data', '*.csv');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📊 CSV Processor - Bài 7.8</title>
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
            max-width: 1400px;
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
        
        .processor-grid {
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
        
        .data-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            grid-column: 1 / -1;
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
            font-family: 'Courier New', monospace;
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
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .result {
            background: #e7f3ff;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #007bff;
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .csv-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9em;
        }
        
        .csv-table th,
        .csv-table td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
        }
        
        .csv-table th {
            background: #343a40;
            color: white;
            font-weight: bold;
        }
        
        .csv-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .csv-table tr:hover {
            background: #e9ecef;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .stat-item {
            background: #e7f3ff;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .tool-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 CSV Processor</h1>
            <p>Xử lý và phân tích file CSV - Bài 7.8 File Handling</p>
            
            <div class="nav-buttons">
                <a href="../index.php" class="btn btn-primary">🏠 Về Trang Chính</a>
                <a href="text_editor.php" class="btn btn-success">📝 Text Editor</a>
                <a href="file_manager.php" class="btn btn-success">🗂️ File Manager</a>
            </div>
        </div>

        <?php if ($result): ?>
            <div class="result">
                <?= htmlspecialchars($result) ?>
            </div>
        <?php endif; ?>

        <div class="processor-grid">
            <!-- Đọc CSV -->
            <div class="tool-section">
                <h2>📖 Đọc CSV</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="read_csv">
                    
                    <div class="form-group">
                        <label>Chọn file CSV:</label>
                        <select name="csv_file" required>
                            <option value="">-- Chọn file --</option>
                            <?php foreach ($csv_files as $file): ?>
                                <option value="<?= $file ?>"><?= $file ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="has_header" checked> 
                            Có dòng header
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">👁️ Đọc CSV</button>
                </form>
            </div>

            <!-- Tạo CSV -->
            <div class="tool-section">
                <h2>🆕 Tạo CSV</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="create_csv">
                    
                    <div class="form-group">
                        <label>Tên file (không cần .csv):</label>
                        <input type="text" name="new_csv_name" placeholder="ten_file" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Headers (phân cách bằng dấu phẩy):</label>
                        <input type="text" name="headers" placeholder="ID,Name,Email,Age" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Dữ liệu mẫu (mỗi dòng một bản ghi):</label>
                        <textarea name="sample_data" placeholder="1,John,john@email.com,25
2,Jane,jane@email.com,30"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success">📝 Tạo CSV</button>
                </form>
            </div>

            <!-- Tìm kiếm CSV -->
            <div class="tool-section">
                <h2>🔍 Tìm Kiếm CSV</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="search_csv">
                    
                    <div class="form-group">
                        <label>Chọn file CSV:</label>
                        <select name="search_file" required>
                            <option value="">-- Chọn file --</option>
                            <?php foreach ($csv_files as $file): ?>
                                <option value="<?= $file ?>"><?= $file ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Từ khóa tìm kiếm:</label>
                        <input type="text" name="search_term" placeholder="Nhập từ khóa..." required>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">🔍 Tìm Kiếm</button>
                </form>
            </div>

            <!-- Export CSV -->
            <div class="tool-section">
                <h2>📤 Export CSV</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="export_csv">
                    
                    <div class="form-group">
                        <label>Headers (phân cách bằng dấu phẩy):</label>
                        <input type="text" name="export_headers" value="ID,Name,Email,Age,City" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">🚀 Export Dữ Liệu Mẫu</button>
                </form>
                
                <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>💡 Ghi chú:</h4>
                    <p>Export sẽ tạo file CSV với 10 bản ghi mẫu về users.</p>
                </div>
            </div>
        </div>

        <!-- Hiển thị dữ liệu CSV -->
        <?php if (!empty($csv_data)): ?>
            <div class="data-section">
                <h2>📊 Dữ Liệu CSV</h2>
                
                <!-- Thống kê -->
                <?php if (!empty($csv_info)): ?>
                    <div class="stats">
                        <div class="stat-item">
                            <h3>Tổng số dòng</h3>
                            <p><?= $csv_info['total_rows'] ?></p>
                        </div>
                        <div class="stat-item">
                            <h3>Tổng số cột</h3>
                            <p><?= $csv_info['total_columns'] ?></p>
                        </div>
                        <div class="stat-item">
                            <h3>Kích thước file</h3>
                            <p><?= $csv_info['file_size'] ?? 'N/A' ?></p>
                        </div>
                        <div class="stat-item">
                            <h3>Hiển thị</h3>
                            <p><?= count($csv_data) ?> dòng</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Bảng dữ liệu -->
                <div style="overflow-x: auto;">
                    <table class="csv-table">
                        <thead>
                            <tr>
                                <?php if (!empty($csv_data[0]) && is_array($csv_data[0])): ?>
                                    <?php foreach (array_keys($csv_data[0]) as $header): ?>
                                        <th><?= htmlspecialchars($header) ?></th>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php for ($i = 0; $i < ($csv_info['total_columns'] ?? 5); $i++): ?>
                                        <th>Column <?= $i + 1 ?></th>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($csv_data, 0, 50) as $row): ?>
                                <tr>
                                    <?php if (is_array($row)): ?>
                                        <?php foreach ($row as $cell): ?>
                                            <td><?= htmlspecialchars($cell) ?></td>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td colspan="<?= $csv_info['total_columns'] ?? 5 ?>">
                                            <?= htmlspecialchars($row) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (count($csv_data) > 50): ?>
                    <p style="text-align: center; margin-top: 1rem; color: #666;">
                        ⚠️ Chỉ hiển thị 50 dòng đầu tiên. Tổng cộng <?= count($csv_data) ?> dòng.
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Hướng dẫn sử dụng -->
        <div class="tool-section" style="grid-column: 1 / -1;">
            <h2>📚 Hướng Dẫn Sử Dụng</h2>
            
            <div class="tool-grid">
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📖 Đọc CSV</h4>
                    <p>Chọn file CSV từ thư mục data để đọc và hiển thị nội dung.</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>🆕 Tạo CSV</h4>
                    <p>Tạo file CSV mới với headers và dữ liệu mẫu.</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>🔍 Tìm Kiếm</h4>
                    <p>Tìm kiếm từ khóa trong nội dung file CSV.</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📤 Export</h4>
                    <p>Xuất dữ liệu mẫu ra file CSV để thử nghiệm.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>