<h2>📋 UploadProcess - Danh Sách File Đã Upload</h2>

<?php
// Tạo thư mục uploads nếu chưa tồn tại
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Xử lý upload file
$upload_results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['files'])) {
    
    foreach ($_FILES['files']['name'] as $i => $filename) {
        if ($filename && $_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['files']['tmp_name'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $file_type = $_FILES['files']['type'][$i];
            
            // Kiểm tra kích thước file (tối đa 2MB)
            if ($file_size > 2 * 1024 * 1024) {
                $upload_results[] = [
                    'status' => 'error',
                    'filename' => $filename,
                    'message' => 'File vượt quá 2MB'
                ];
                continue;
            }
            
            // Kiểm tra loại file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain'];
            if (!in_array($file_type, $allowed_types)) {
                $upload_results[] = [
                    'status' => 'error',
                    'filename' => $filename,
                    'message' => 'Định dạng file không được hỗ trợ'
                ];
                continue;
            }
            
            // Tạo tên file an toàn
            $safe_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename);
            $target_path = $upload_dir . $safe_filename;
            
            // Upload file
            if (move_uploaded_file($tmp_name, $target_path)) {
                $upload_results[] = [
                    'status' => 'success',
                    'filename' => $safe_filename,
                    'path' => $target_path,
                    'size' => formatFileSize($file_size),
                    'type' => $file_type
                ];
            } else {
                $upload_results[] = [
                    'status' => 'error',
                    'filename' => $filename,
                    'message' => 'Lỗi khi upload file'
                ];
            }
        }
    }
    
    // Chuyển hướng về trang uploadform với thông báo
    if (!empty($upload_results)) {
        $success_count = count(array_filter($upload_results, function($item) {
            return $item['status'] === 'success';
        }));
        
        if ($success_count > 0) {
            header('Location: index.php?page=uploadform&upload_status=success');
            exit;
        } else {
            header('Location: index.php?page=uploadform&upload_status=error');
            exit;
        }
    }
}

// Hàm định dạng kích thước file
function formatFileSize($bytes) {
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Lấy danh sách file đã upload
$existing_files = [];
if (is_dir($upload_dir)) {
    $files = scandir($upload_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $file_path = $upload_dir . $file;
            $existing_files[] = [
                'name' => $file,
                'path' => $file_path,
                'size' => formatFileSize(filesize($file_path)),
                'modified' => date('d/m/Y H:i:s', filemtime($file_path))
            ];
        }
    }
}
?>

<!-- Hiển thị kết quả upload (nếu có từ POST) -->
<?php if (!empty($upload_results)): ?>
<div class="result">
    <h3>📊 Kết Quả Upload</h3>
    <table style="width: 100%;">
        <tr>
            <th>File Name</th>
            <th>Status</th>
            <th>Message</th>
            <th>Size</th>
        </tr>
        <?php foreach ($upload_results as $result): ?>
        <tr>
            <td><?= htmlspecialchars($result['filename']) ?></td>
            <td>
                <?php if ($result['status'] === 'success'): ?>
                <span style="color: #27ae60;">✅ Thành công</span>
                <?php else: ?>
                <span style="color: #e74c3c;">❌ Lỗi</span>
                <?php endif; ?>
            </td>
            <td><?= $result['message'] ?? 'OK' ?></td>
            <td><?= $result['size'] ?? '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

<!-- Hiển thị danh sách file đã upload -->
<div class="result">
    <h3>📁 Danh Sách File Đã Upload</h3>
    
    <?php if (empty($existing_files)): ?>
    <p style="color: #7f8c8d; text-align: center; padding: 20px;">
        📭 Chưa có file nào được upload
    </p>
    <?php else: ?>
    <table style="width: 100%;">
        <tr>
            <th>STT</th>
            <th>Tên File</th>
            <th>Kích thước</th>
            <th>Ngày upload</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($existing_files as $index => $file): ?>
        <tr>
            <td style="text-align: center;"><?= $index + 1 ?></td>
            <td>
                <?php
                $icon = '📄';
                if (strpos($file['name'], '.jpg') !== false || strpos($file['name'], '.png') !== false) {
                    $icon = '🖼️';
                } elseif (strpos($file['name'], '.pdf') !== false) {
                    $icon = '📕';
                } elseif (strpos($file['name'], '.txt') !== false) {
                    $icon = '📝';
                }
                echo $icon . ' ' . htmlspecialchars($file['name']);
                ?>
            </td>
            <td style="text-align: center;"><?= $file['size'] ?></td>
            <td style="text-align: center;"><?= $file['modified'] ?></td>
            <td style="text-align: center;">
                <a href="<?= $file['path'] ?>" download class="btn" style="padding: 5px 10px; font-size: 0.9em;">
                    ⬇️ Download
                </a>
                <a href="<?= $file['path'] ?>" target="_blank" class="btn" style="padding: 5px 10px; font-size: 0.9em;">
                    👁️ Xem
                </a>
                <button onclick="deleteFile('<?= $file['name'] ?>')" class="btn" style="padding: 5px 10px; font-size: 0.9em; background: #e74c3c;">
                    🗑️ Xóa
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div style="margin-top: 15px; text-align: center;">
        <p><strong>Tổng số file:</strong> <?= count($existing_files) ?></p>
        <a href="index.php?page=uploadform" class="btn">📤 Upload Thêm File</a>
        <button onclick="clearAllFiles()" class="btn" style="background: #e74c3c;">🗑️ Xóa Tất Cả</button>
    </div>
    <?php endif; ?>
</div>

<script>
// Xóa file
function deleteFile(filename) {
    if (confirm('Bạn có chắc muốn xóa file "' + filename + '"?')) {
        window.location.href = 'index.php?page=uploadprocess&delete=' + encodeURIComponent(filename);
    }
}

// Xóa tất cả file
function clearAllFiles() {
    if (confirm('Bạn có chắc muốn xóa TẤT CẢ file?')) {
        window.location.href = 'index.php?page=uploadprocess&clear_all=1';
    }
}
</script>

<?php
// Xử lý xóa file (nếu có tham số delete)
if (isset($_GET['delete'])) {
    $file_to_delete = $_GET['delete'];
    $file_path = $upload_dir . $file_to_delete;
    
    if (file_exists($file_path) && unlink($file_path)) {
        echo '<script>alert("✅ Đã xóa file thành công!"); window.location.href = "index.php?page=uploadprocess";</script>';
    } else {
        echo '<script>alert("❌ Lỗi khi xóa file!");</script>';
    }
}

// Xử lý xóa tất cả file
if (isset($_GET['clear_all'])) {
    $files = scandir($upload_dir);
    $deleted_count = 0;
    
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $file_path = $upload_dir . $file;
            if (unlink($file_path)) {
                $deleted_count++;
            }
        }
    }
    
    echo '<script>alert("✅ Đã xóa ' . $deleted_count . ' file!"); window.location.href = "index.php?page=uploadprocess";</script>';
}
?>