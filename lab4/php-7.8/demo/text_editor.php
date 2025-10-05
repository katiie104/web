<?php
require_once '../includes/file_functions.php';

$result = '';
$current_file = '';
$file_content = '';

// Xử lý tạo/tải file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'load_file':
                $filename = $_POST['filename'] ?? '';
                $filepath = "files/documents/{$filename}";
                
                if (file_exists($filepath)) {
                    $file_content = readFileContent($filepath);
                    $current_file = $filename;
                    $result = "✅ Đã tải file: {$filename}";
                } else {
                    $result = "❌ File không tồn tại";
                }
                break;
                
            case 'save_file':
                $filename = $_POST['filename'] ?? '';
                $content = $_POST['content'] ?? '';
                $filepath = "files/documents/{$filename}";
                
                if (writeFileContent($filepath, $content)) {
                    $result = "✅ Đã lưu file: {$filename}";
                    $current_file = $filename;
                    $file_content = $content;
                } else {
                    $result = "❌ Lỗi khi lưu file";
                }
                break;
                
            case 'new_file':
                $filename = sanitizeFilename($_POST['new_filename'] ?? '');
                $content = $_POST['new_content'] ?? '';
                $filepath = "files/documents/{$filename}.txt";
                
                if (createFile($filepath, $content)) {
                    $result = "✅ Đã tạo file mới: {$filename}.txt";
                    $current_file = "{$filename}.txt";
                    $file_content = $content;
                } else {
                    $result = "❌ Lỗi khi tạo file";
                }
                break;
        }
    } catch (Exception $e) {
        $result = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy danh sách file
$files = listFilesInDirectory('files/documents');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>📝 Text Editor - Bài 7.8</title>
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
        
        .editor-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }
        
        .sidebar {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .editor {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
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
            min-height: 400px;
            resize: vertical;
            font-family: 'Courier New', monospace;
            line-height: 1.5;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            margin: 5px 0;
            width: 100%;
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
        
        .file-list {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .file-item {
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .file-item:hover {
            background: #e9ecef;
        }
        
        .file-item.active {
            background: #007bff;
            color: white;
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .editor-toolbar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📝 Text Editor</h1>
            <p>Trình soạn thảo văn bản đơn giản - Bài 7.8 File Handling</p>
            
            <div class="nav-buttons">
                <a href="../index.php" class="btn btn-primary">🏠 Về Trang Chính</a>
                <a href="file_manager.php" class="btn btn-success">🗂️ File Manager</a>
                <a href="csv_processor.php" class="btn btn-success">📊 CSV Processor</a>
            </div>
        </div>

        <?php if ($result): ?>
            <div class="result">
                <?= htmlspecialchars($result) ?>
            </div>
        <?php endif; ?>

        <div class="editor-container">
            <!-- Sidebar -->
            <div class="sidebar">
                <h2>📁 Quản lý File</h2>
                
                <!-- Tạo file mới -->
                <div class="form-group">
                    <h3>🆕 Tạo File Mới</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="new_file">
                        
                        <div class="form-group">
                            <label>Tên file:</label>
                            <input type="text" name="new_filename" placeholder="ten_file_moi" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Nội dung:</label>
                            <textarea name="new_content" placeholder="Nội dung file mới..." rows="5"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">📝 Tạo File</button>
                    </form>
                </div>

                <!-- Danh sách file -->
                <div class="form-group">
                    <h3>📂 File Hiện Có</h3>
                    <div class="file-list">
                        <?php if (!empty($files)): ?>
                            <?php foreach ($files as $file): ?>
                                <div class="file-item <?= $current_file == $file ? 'active' : '' ?>" 
                                     onclick="loadFile('<?= $file ?>')">
                                    📄 <?= $file ?>
                                    <small style="display: block; color: #666;">
                                        <?= formatFileSize(filesize("files/documents/{$file}")) ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Chưa có file nào</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Editor -->
            <div class="editor">
                <h2>✏️ Soạn Thảo</h2>
                
                <form method="POST" id="editorForm">
                    <input type="hidden" name="action" value="save_file">
                    
                    <div class="form-group">
                        <label>File đang chỉnh sửa:</label>
                        <input type="text" name="filename" value="<?= htmlspecialchars($current_file) ?>" 
                               placeholder="Chọn file từ danh sách bên trái" readonly
                               style="background: #f8f9fa;">
                    </div>
                    
                    <div class="form-group">
                        <label>Nội dung:</label>
                        <textarea name="content" id="editorContent" placeholder="Nhập nội dung..." 
                                  <?= empty($current_file) ? 'readonly' : '' ?>><?= htmlspecialchars($file_content) ?></textarea>
                    </div>
                    
                    <div class="editor-toolbar">
                        <button type="submit" class="btn btn-primary" <?= empty($current_file) ? 'disabled' : '' ?>>
                            💾 Lưu File
                        </button>
                        <button type="button" class="btn btn-warning" onclick="clearEditor()">
                            🗑️ Xóa Nội Dung
                        </button>
                        <button type="button" class="btn btn-info" onclick="insertTimestamp()">
                            ⏰ Chèn Thời Gian
                        </button>
                    </div>
                </form>

                <!-- Thông tin file -->
                <?php if (!empty($current_file)): ?>
                    <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <h3>📊 Thông Tin File</h3>
                        <?php
                        $filepath = "files/documents/{$current_file}";
                        $info = getFileInfo($filepath);
                        ?>
                        <p><strong>Tên file:</strong> <?= $info['name'] ?></p>
                        <p><strong>Kích thước:</strong> <?= formatFileSize($info['size']) ?></p>
                        <p><strong>Sửa đổi lần cuối:</strong> <?= date('d/m/Y H:i:s', $info['modified']) ?></p>
                        <p><strong>Số dòng:</strong> <?= count(explode("\n", $file_content)) ?></p>
                        <p><strong>Số từ:</strong> <?= str_word_count($file_content) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function loadFile(filename) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'load_file';
            
            const filenameInput = document.createElement('input');
            filenameInput.type = 'hidden';
            filenameInput.name = 'filename';
            filenameInput.value = filename;
            
            form.appendChild(input);
            form.appendChild(filenameInput);
            document.body.appendChild(form);
            form.submit();
        }
        
        function clearEditor() {
            if (confirm('Bạn có chắc muốn xóa toàn bộ nội dung?')) {
                document.getElementById('editorContent').value = '';
            }
        }
        
        function insertTimestamp() {
            const now = new Date();
            const timestamp = now.toLocaleString('vi-VN');
            const editor = document.getElementById('editorContent');
            const cursorPos = editor.selectionStart;
            const textBefore = editor.value.substring(0, cursorPos);
            const textAfter = editor.value.substring(cursorPos);
            
            editor.value = textBefore + '\n[Thời gian: ' + timestamp + ']\n' + textAfter;
        }
        
        // Auto-save every 30 seconds
        setInterval(() => {
            const filename = document.querySelector('input[name="filename"]').value;
            const content = document.getElementById('editorContent').value;
            
            if (filename && content) {
                // Tạo auto-save indicator
                const indicator = document.createElement('div');
                indicator.style.cssText = 'position: fixed; top: 10px; right: 10px; background: #28a745; color: white; padding: 5px 10px; border-radius: 5px; z-index: 1000;';
                indicator.textContent = '💾 Auto-saving...';
                document.body.appendChild(indicator);
                
                setTimeout(() => {
                    document.body.removeChild(indicator);
                }, 2000);
            }
        }, 30000);
    </script>
</body>
</html>