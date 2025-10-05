<?php
require_once '../includes/file_functions.php';
require_once '../includes/upload_functions.php';

$result = '';
$current_directory = 'files/documents';

// Xử lý các thao tác quản lý file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'delete_file':
                $filename = $_POST['filename'] ?? '';
                $filepath = "{$current_directory}/{$filename}";
                
                if (deleteFile($filepath)) {
                    $result = "✅ Đã xóa file: {$filename}";
                } else {
                    $result = "❌ Lỗi khi xóa file";
                }
                break;
                
            case 'rename_file':
                $old_name = $_POST['old_name'] ?? '';
                $new_name = sanitizeFilename($_POST['new_name'] ?? '');
                $old_path = "{$current_directory}/{$old_name}";
                $new_path = "{$current_directory}/{$new_name}";
                
                if (renameFile($old_path, $new_path)) {
                    $result = "✅ Đã đổi tên: {$old_name} → {$new_name}";
                } else {
                    $result = "❌ Lỗi khi đổi tên file";
                }
                break;
                
            case 'copy_file':
                $filename = $_POST['filename'] ?? '';
                $copy_name = "copy_" . $filename;
                $source_path = "{$current_directory}/{$filename}";
                $dest_path = "{$current_directory}/{$copy_name}";
                
                if (copyFile($source_path, $dest_path)) {
                    $result = "✅ Đã sao chép: {$filename} → {$copy_name}";
                } else {
                    $result = "❌ Lỗi khi sao chép file";
                }
                break;
                
            case 'create_directory':
                $dir_name = sanitizeFilename($_POST['dir_name'] ?? '');
                $dir_path = "{$current_directory}/{$dir_name}";
                
                if (createDirectory($dir_path)) {
                    $result = "✅ Đã tạo thư mục: {$dir_name}";
                } else {
                    $result = "❌ Lỗi khi tạo thư mục";
                }
                break;
                
            case 'change_directory':
                $new_dir = $_POST['directory'] ?? '';
                if (is_dir($new_dir)) {
                    $current_directory = $new_dir;
                    $result = "✅ Đã chuyển đến thư mục: {$new_dir}";
                } else {
                    $result = "❌ Thư mục không tồn tại";
                }
                break;
        }
    } catch (Exception $e) {
        $result = "❌ Lỗi: " . $e->getMessage();
    }
}

// Xử lý upload file
if (isset($_FILES['upload_file'])) {
    $upload_result = handleFileUpload($_FILES['upload_file'], $current_directory . '/');
    $result = $upload_result['message'];
}

// Lấy danh sách file và thư mục
$files = [];
$directories = [];

if (is_dir($current_directory)) {
    $items = scandir($current_directory);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $full_path = $current_directory . '/' . $item;
        if (is_dir($full_path)) {
            $directories[] = $item;
        } else {
            $files[] = $item;
        }
    }
}

// Lấy thông tin thư mục
$dir_info = [
    'total_files' => count($files),
    'total_dirs' => count($directories),
    'total_size' => 0
];

foreach ($files as $file) {
    $dir_info['total_size'] += filesize($current_directory . '/' . $file);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🗂️ File Manager - Bài 7.8</title>
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
        
        .manager-grid {
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
        
        .main-content {
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
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
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
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .result {
            background: #e7f3ff;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #007bff;
        }
        
        .file-list, .directory-list {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .file-item, .directory-item {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .file-item:hover, .directory-item:hover {
            background: #e9ecef;
        }
        
        .file-actions, .directory-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .nav-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .upload-area {
            border: 2px dashed #007bff;
            padding: 2rem;
            text-align: center;
            border-radius: 8px;
            margin: 1rem 0;
            background: #f8f9fa;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .stat-item {
            background: #e7f3ff;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .breadcrumb {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-family: monospace;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🗂️ File Manager</h1>
            <p>Quản lý file và thư mục - Bài 7.8 File Handling</p>
            
            <div class="nav-buttons">
                <a href="../index.php" class="btn btn-primary">🏠 Về Trang Chính</a>
                <a href="text_editor.php" class="btn btn-success">📝 Text Editor</a>
                <a href="csv_processor.php" class="btn btn-success">📊 CSV Processor</a>
            </div>
        </div>

        <?php if ($result): ?>
            <div class="result">
                <?= htmlspecialchars($result) ?>
            </div>
        <?php endif; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            📁 Đường dẫn hiện tại: <?= $current_directory ?>
        </div>

        <!-- Thống kê -->
        <div class="stats">
            <div class="stat-item">
                <h3>📄 Files</h3>
                <p><?= $dir_info['total_files'] ?> file</p>
            </div>
            <div class="stat-item">
                <h3>📁 Thư mục</h3>
                <p><?= $dir_info['total_dirs'] ?> thư mục</p>
            </div>
            <div class="stat-item">
                <h3>💾 Dung lượng</h3>
                <p><?= formatFileSize($dir_info['total_size']) ?></p>
            </div>
        </div>

        <div class="manager-grid">
            <!-- Sidebar - Công cụ -->
            <div class="sidebar">
                <h2>🛠️ Công Cụ</h2>
                
                <!-- Upload file -->
                <div class="form-group">
                    <h3>📤 Upload File</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="upload-area">
                            <input type="file" name="upload_file" required>
                            <button type="submit" class="btn btn-success" style="margin-top: 1rem;">
                                🚀 Upload
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tạo thư mục -->
                <div class="form-group">
                    <h3>🆕 Tạo Thư Mục</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="create_directory">
                        <input type="text" name="dir_name" placeholder="Tên thư mục" required>
                        <button type="submit" class="btn btn-primary">📁 Tạo Thư Mục</button>
                    </form>
                </div>

                <!-- Chuyển thư mục -->
                <div class="form-group">
                    <h3>🔀 Chuyển Thư Mục</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="change_directory">
                        <select name="directory">
                            <option value="files/documents">files/documents</option>
                            <option value="files/uploads">files/uploads</option>
                            <option value="files/data">files/data</option>
                        </select>
                        <button type="submit" class="btn btn-warning">🔄 Chuyển</button>
                    </form>
                </div>
            </div>

            <!-- Main Content - Danh sách file -->
            <div class="main-content">
                <h2>📁 Nội Dung Thư Mục</h2>
                
                <!-- Danh sách thư mục -->
                <?php if (!empty($directories)): ?>
                    <h3>📂 Thư Mục</h3>
                    <div class="directory-list">
                        <?php foreach ($directories as $dir): ?>
                            <div class="directory-item">
                                <span>📁 <?= $dir ?></span>
                                <div class="directory-actions">
                                    <button class="btn btn-primary btn-sm" onclick="changeDir('<?= $current_directory . '/' . $dir ?>')">
                                        📂 Mở
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Danh sách file -->
                <?php if (!empty($files)): ?>
                    <h3>📄 Files</h3>
                    <div class="file-list">
                        <?php foreach ($files as $file): ?>
                            <?php
                            $filepath = $current_directory . '/' . $file;
                            $fileinfo = getFileInfo($filepath);
                            ?>
                            <div class="file-item">
                                <div>
                                    <strong>📄 <?= $file ?></strong>
                                    <div style="font-size: 0.8em; color: #666;">
                                        <?= formatFileSize($fileinfo['size']) ?> • 
                                        <?= date('d/m/Y H:i', $fileinfo['modified']) ?>
                                    </div>
                                </div>
                                <div class="file-actions">
                                    <?php if (strpos($fileinfo['type'], 'text') !== false): ?>
                                        <button class="btn btn-success btn-sm" onclick="editFile('<?= $file ?>')">
                                            ✏️ Sửa
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-warning btn-sm" onclick="renameFile('<?= $file ?>')">
                                        📝 Đổi tên
                                    </button>
                                    <button class="btn btn-primary btn-sm" onclick="copyFile('<?= $file ?>')">
                                        📋 Copy
                                    </button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_file">
                                        <input type="hidden" name="filename" value="<?= $file ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc muốn xóa file <?= $file ?>?')">
                                            🗑️ Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>📭 Thư mục trống</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal đổi tên file -->
    <div id="renameModal" class="modal">
        <div class="modal-content">
            <h3>📝 Đổi Tên File</h3>
            <form method="POST" id="renameForm">
                <input type="hidden" name="action" value="rename_file">
                <input type="hidden" name="old_name" id="oldName">
                
                <div class="form-group">
                    <label>Tên mới:</label>
                    <input type="text" name="new_name" id="newName" required>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">💾 Lưu</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('renameModal')">❌ Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal copy file -->
    <div id="copyModal" class="modal">
        <div class="modal-content">
            <h3>📋 Sao Chép File</h3>
            <form method="POST" id="copyForm">
                <input type="hidden" name="action" value="copy_file">
                <input type="hidden" name="filename" id="copyFileName">
                
                <p>Bạn có chắc muốn sao chép file <strong id="copyFileDisplay"></strong>?</p>
                
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">✅ Copy</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('copyModal')">❌ Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function changeDir(newDir) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'change_directory';
            
            const dirInput = document.createElement('input');
            dirInput.type = 'hidden';
            dirInput.name = 'directory';
            dirInput.value = newDir;
            
            form.appendChild(actionInput);
            form.appendChild(dirInput);
            document.body.appendChild(form);
            form.submit();
        }
        
        function editFile(filename) {
            window.open(`text_editor.php?file=${encodeURIComponent(filename)}`, '_blank');
        }
        
        function renameFile(filename) {
            document.getElementById('oldName').value = filename;
            document.getElementById('newName').value = filename;
            document.getElementById('renameModal').style.display = 'block';
        }
        
        function copyFile(filename) {
            document.getElementById('copyFileName').value = filename;
            document.getElementById('copyFileDisplay').textContent = filename;
            document.getElementById('copyModal').style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
        
        // Phím tắt
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('renameModal');
                closeModal('copyModal');
            }
        });
    </script>
</body>
</html>