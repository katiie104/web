<?php
session_start();
require_once 'includes/file_functions.php';
require_once 'includes/upload_functions.php';
require_once 'includes/csv_functions.php';

// Tạo thư mục nếu chưa tồn tại
createDirectory('files/documents');
createDirectory('files/uploads');
createDirectory('files/data');

$result = '';
$current_file = '';

// Xử lý các thao tác với file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'create_file':
                $filename = sanitizeFilename($_POST['filename'] ?? '');
                $content = $_POST['content'] ?? '';
                $filepath = "files/documents/{$filename}.txt";
                
                if (createFile($filepath, $content)) {
                    $result = "✅ Đã tạo file: {$filename}.txt";
                } else {
                    $result = "❌ Lỗi khi tạo file";
                }
                break;
                
            case 'read_file':
                $filename = $_POST['read_filename'] ?? '';
                $filepath = "files/documents/{$filename}";
                
                if (file_exists($filepath)) {
                    $content = readFileContent($filepath);
                    $result = "📖 Nội dung file {$filename}:\n\n{$content}";
                    $current_file = $filename;
                } else {
                    $result = "❌ File không tồn tại";
                }
                break;
                
            case 'write_file':
                $filename = $_POST['write_filename'] ?? '';
                $content = $_POST['write_content'] ?? '';
                $filepath = "files/documents/{$filename}";
                
                if (file_exists($filepath)) {
                    if (writeFileContent($filepath, $content)) {
                        $result = "✅ Đã ghi nội dung vào file: {$filename}";
                    } else {
                        $result = "❌ Lỗi khi ghi file";
                    }
                } else {
                    $result = "❌ File không tồn tại";
                }
                break;
                
            case 'file_info':
                $filename = $_POST['info_filename'] ?? '';
                $filepath = "files/documents/{$filename}";
                
                if (file_exists($filepath)) {
                    $info = getFileInfo($filepath);
                    $result = "📊 Thông tin file {$filename}:\n";
                    $result .= "Kích thước: " . formatFileSize($info['size']) . "\n";
                    $result .= "Loại file: {$info['type']}\n";
                    $result .= "Thời gian sửa đổi: " . date('Y-m-d H:i:s', $info['modified']) . "\n";
                    $result .= "Quyền: {$info['permissions']}";
                } else {
                    $result = "❌ File không tồn tại";
                }
                break;
                
            case 'list_files':
                $files = listFilesInDirectory('files/documents');
                $result = "📁 Danh sách file trong thư mục documents:\n";
                foreach ($files as $file) {
                    $filepath = "files/documents/{$file}";
                    $size = formatFileSize(filesize($filepath));
                    $result .= "• {$file} ({$size})\n";
                }
                break;
        }
    } catch (Exception $e) {
        $result = "❌ Lỗi: " . $e->getMessage();
    }
}

// Xử lý upload file
if (isset($_FILES['upload_file'])) {
    $upload_result = handleFileUpload($_FILES['upload_file'], 'files/uploads/');
    $result = $upload_result['message'];
}

// Lấy danh sách file
$document_files = listFilesInDirectory('files/documents');
$upload_files = listFilesInDirectory('files/uploads');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📁 Bài 7.8 - File Handling</title>
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
        
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
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
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
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
            white-space: pre-wrap;
        }
        
        .file-list {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .file-item {
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        
        .upload-area {
            border: 2px dashed #007bff;
            padding: 2rem;
            text-align: center;
            border-radius: 8px;
            margin: 1rem 0;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📁 Bài 7.8 - File Handling (Đọc/Ghi File)</h1>
            <p>Làm việc với file system trong PHP - Đọc, ghi, upload và quản lý file</p>
            
            <div class="nav-buttons">
                <a href="../php-7.7/index.php" class="btn btn-success">🔙 Bài 7.7 - Functions</a>
                <a href="../php-7.5/index.php" class="btn btn-primary">🏠 Trang Chủ</a>
            </div>

            <div class="demo-links">
                <a href="demos/text_editor.php" class="btn btn-warning">📝 Text Editor</a>
                <a href="demos/file_manager.php" class="btn btn-warning">🗂️ File Manager</a>
                <a href="demos/csv_processor.php" class="btn btn-warning">📊 CSV Processor</a>
                <a href="demos/image_gallery.php" class="btn btn-warning">🖼️ Image Gallery</a>
            </div>
        </div>

        <!-- Results Section -->
        <?php if ($result): ?>
            <div class="card">
                <h2>🎯 Kết Quả</h2>
                <div class="result">
                    <?= htmlspecialchars($result) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tabs Navigation -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('file-operations')">📄 Thao Tác File</button>
            <button class="tab" onclick="showTab('file-upload')">📤 Upload File</button>
            <button class="tab" onclick="showTab('file-list')">📁 Danh Sách File</button>
        </div>

        <!-- File Operations Tab -->
        <div id="file-operations" class="tab-content active">
            <div class="dashboard">
                <!-- Tạo file mới -->
                <div class="card">
                    <h2>🆕 Tạo File Mới</h2>
                    <form method="POST">
                        <input type="hidden" name="action" value="create_file">
                        
                        <div class="form-group">
                            <label>Tên file (không cần .txt):</label>
                            <input type="text" name="filename" placeholder="ten_file" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Nội dung:</label>
                            <textarea name="content" placeholder="Nhập nội dung file..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">📝 Tạo File</button>
                    </form>
                </div>

                <!-- Đọc file -->
                <div class="card">
                    <h2>📖 Đọc File</h2>
                    <form method="POST">
                        <input type="hidden" name="action" value="read_file">
                        
                        <div class="form-group">
                            <label>Chọn file để đọc:</label>
                            <select name="read_filename" required>
                                <option value="">-- Chọn file --</option>
                                <?php foreach ($document_files as $file): ?>
                                    <option value="<?= $file ?>" <?= $current_file == $file ? 'selected' : '' ?>>
                                        <?= $file ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">👁️ Đọc Nội Dung</button>
                    </form>
                </div>

                <!-- Ghi file -->
                <div class="card">
                    <h2>✏️ Ghi File</h2>
                    <form method="POST">
                        <input type="hidden" name="action" value="write_file">
                        
                        <div class="form-group">
                            <label>Chọn file để ghi:</label>
                            <select name="write_filename" required>
                                <option value="">-- Chọn file --</option>
                                <?php foreach ($document_files as $file): ?>
                                    <option value="<?= $file ?>"><?= $file ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Nội dung mới:</label>
                            <textarea name="write_content" placeholder="Nhập nội dung mới..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">💾 Lưu Thay Đổi</button>
                    </form>
                </div>

                <!-- Thông tin file -->
                <div class="card">
                    <h2>📊 Thông Tin File</h2>
                    <form method="POST">
                        <input type="hidden" name="action" value="file_info">
                        
                        <div class="form-group">
                            <label>Chọn file để xem thông tin:</label>
                            <select name="info_filename" required>
                                <option value="">-- Chọn file --</option>
                                <?php foreach ($document_files as $file): ?>
                                    <option value="<?= $file ?>"><?= $file ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-info">🔍 Xem Thông Tin</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- File Upload Tab -->
        <div id="file-upload" class="tab-content">
            <div class="card">
                <h2>📤 Upload File</h2>
                
                <div class="upload-area">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Chọn file để upload:</label>
                            <input type="file" name="upload_file" required 
                                   accept=".txt,.pdf,.jpg,.jpeg,.png,.gif,.doc,.docx">
                        </div>
                        
                        <div class="form-group">
                            <small>Cho phép: TXT, PDF, JPG, PNG, GIF, DOC (Tối đa 2MB)</small>
                        </div>
                        
                        <button type="submit" class="btn btn-success">🚀 Upload File</button>
                    </form>
                </div>

                <!-- Danh sách file đã upload -->
                <h3>📁 File Đã Upload</h3>
                <div class="file-list">
                    <?php if (!empty($upload_files)): ?>
                        <?php foreach ($upload_files as $file): ?>
                            <div class="file-item">
                                <span>📄 <?= $file ?></span>
                                <span>
                                    <?= formatFileSize(filesize("files/uploads/{$file}")) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Chưa có file nào được upload</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- File List Tab -->
        <div id="file-list" class="tab-content">
            <div class="card">
                <h2>📁 Quản Lý File</h2>
                
                <form method="POST">
                    <input type="hidden" name="action" value="list_files">
                    <button type="submit" class="btn btn-primary">🔄 Hiển Thị Danh Sách File</button>
                </form>

                <!-- Danh sách file documents -->
                <h3>📝 File Văn Bản</h3>
                <div class="file-list">
                    <?php if (!empty($document_files)): ?>
                        <?php foreach ($document_files as $file): ?>
                            <div class="file-item">
                                <span>📄 <?= $file ?></span>
                                <span>
                                    <?= formatFileSize(filesize("files/documents/{$file}")) ?>
                                    - <?= date('d/m/Y H:i', filemtime("files/documents/{$file}")) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Chưa có file văn bản nào</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- File Functions Documentation -->
        <div class="card">
            <h2>📚 Các Hàm File Handling</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin: 1rem 0;">
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📄 createFile($path, $content)</h4>
                    <p>Tạo file mới với nội dung</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>👁️ readFileContent($path)</h4>
                    <p>Đọc toàn bộ nội dung file</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>✏️ writeFileContent($path, $content)</h4>
                    <p>Ghi nội dung vào file</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📊 getFileInfo($path)</h4>
                    <p>Lấy thông tin chi tiết về file</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📁 listFilesInDirectory($directory)</h4>
                    <p>Liệt kê tất cả file trong thư mục</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h4>📤 handleFileUpload($file, $target_dir)</h4>
                    <p>Xử lý upload file an toàn</p>
                </div>
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

        // File upload preview
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                if (fileSize > 2) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 2MB.');
                    e.target.value = '';
                }
            }
        });
    </script>
</body>
</html>