<?php
require_once '../includes/file_functions.php';
require_once '../includes/upload_functions.php';

$result = '';
$images = [];
$current_image = '';

// Tạo thư mục images nếu chưa tồn tại
createDirectory('files/images');
createDirectory('files/images/thumbs'); // Thư mục cho thumbnail

// Xử lý upload ảnh
if (isset($_FILES['upload_image'])) {
    $allowed_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg', 
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp'
    ];
    
    $upload_result = handleFileUpload($_FILES['upload_image'], 'files/images/', $allowed_types, 5 * 1024 * 1024); // 5MB max
    $result = $upload_result['message'];
    
    // Tạo thumbnail nếu upload thành công
    if ($upload_result['success']) {
        createThumbnail('files/images/' . $upload_result['filename'], 'files/images/thumbs/' . $upload_result['filename'], 200, 200);
    }
}

// Xử lý xóa ảnh
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'delete_image':
                $filename = $_POST['filename'] ?? '';
                $image_path = "files/images/{$filename}";
                $thumb_path = "files/images/thumbs/{$filename}";
                
                // Xóa ảnh gốc và thumbnail
                $deleted = false;
                if (file_exists($image_path)) {
                    $deleted = deleteFile($image_path);
                }
                if (file_exists($thumb_path)) {
                    deleteFile($thumb_path);
                }
                
                if ($deleted) {
                    $result = "✅ Đã xóa ảnh: {$filename}";
                } else {
                    $result = "❌ Lỗi khi xóa ảnh";
                }
                break;
                
            case 'view_image':
                $filename = $_POST['filename'] ?? '';
                if (file_exists("files/images/{$filename}")) {
                    $current_image = $filename;
                    $result = "👁️ Đang xem ảnh: {$filename}";
                }
                break;
        }
    } catch (Exception $e) {
        $result = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy danh sách ảnh
$image_files = listFilesInDirectory('files/images');
$images = array_filter($image_files, function($file) {
    return isImageFile("files/images/{$file}");
});

// Hàm tạo thumbnail
function createThumbnail($source_path, $dest_path, $max_width = 200, $max_height = 200) {
    if (!file_exists($source_path) || !isImageFile($source_path)) {
        return false;
    }
    
    $image_info = getimagesize($source_path);
    if (!$image_info) return false;
    
    list($width, $height, $type) = $image_info;
    
    // Tính toán kích thước mới
    $ratio = min($max_width / $width, $max_height / $height);
    $new_width = round($width * $ratio);
    $new_height = round($height * $ratio);
    
    // Tạo image resource từ file gốc
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($source_path);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_WEBP:
            $source = imagecreatefromwebp($source_path);
            break;
        default:
            return false;
    }
    
    if (!$source) return false;
    
    // Tạo image mới cho thumbnail
    $thumb = imagecreatetruecolor($new_width, $new_height);
    
    // Giữ transparency cho PNG và GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }
    
    // Resize ảnh
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Lưu thumbnail
    $success = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $success = imagejpeg($thumb, $dest_path, 85);
            break;
        case IMAGETYPE_PNG:
            $success = imagepng($thumb, $dest_path, 8);
            break;
        case IMAGETYPE_GIF:
            $success = imagegif($thumb, $dest_path);
            break;
        case IMAGETYPE_WEBP:
            $success = imagewebp($thumb, $dest_path, 85);
            break;
    }
    
    // Giải phóng bộ nhớ
    imagedestroy($source);
    imagedestroy($thumb);
    
    return $success;
}

// Hàm lấy thông tin ảnh
function getImageInfo($filepath) {
    if (!file_exists($filepath)) {
        return null;
    }
    
    $info = getimagesize($filepath);
    if (!$info) return null;
    
    return [
        'width' => $info[0],
        'height' => $info[1],
        'type' => $info[2],
        'mime' => $info['mime'],
        'size' => filesize($filepath),
        'modified' => filemtime($filepath)
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🖼️ Image Gallery - Bài 7.8</title>
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
        
        .gallery-container {
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
        
        .gallery {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .image-viewer {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 2rem;
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
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .image-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s;
            background: white;
        }
        
        .image-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .image-thumb {
            width: 100%;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
        }
        
        .image-info {
            padding: 0.75rem;
            font-size: 0.8em;
        }
        
        .image-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 500px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .image-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 1rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
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
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            padding: 2rem;
        }
        
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            margin: auto;
            display: block;
        }
        
        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🖼️ Image Gallery</h1>
            <p>Quản lý và xem ảnh - Bài 7.8 File Handling</p>
            
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

        <!-- Thống kê -->
        <div class="stats">
            <div class="stat-item">
                <h3>🖼️ Tổng ảnh</h3>
                <p><?= count($images) ?> ảnh</p>
            </div>
            <div class="stat-item">
                <h3>💾 Dung lượng</h3>
                <p>
                    <?php
                    $total_size = 0;
                    foreach ($images as $image) {
                        $total_size += filesize("files/images/{$image}");
                    }
                    echo formatFileSize($total_size);
                    ?>
                </p>
            </div>
            <div class="stat-item">
                <h3>📁 Thư mục</h3>
                <p>files/images/</p>
            </div>
        </div>

        <div class="gallery-container">
            <!-- Sidebar - Upload -->
            <div class="sidebar">
                <h2>📤 Upload Ảnh</h2>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="upload-area">
                        <div class="form-group">
                            <label>Chọn ảnh để upload:</label>
                            <input type="file" name="upload_image" accept="image/*" required>
                        </div>
                        
                        <div class="form-group">
                            <small>Cho phép: JPG, PNG, GIF, WEBP (Tối đa 5MB)</small>
                        </div>
                        
                        <button type="submit" class="btn btn-success">🚀 Upload Ảnh</button>
                    </div>
                </form>

                <!-- Thông tin hỗ trợ -->
                <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <h3>💡 Thông tin</h3>
                    <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                        <li>Ảnh sẽ được tự động tạo thumbnail</li>
                        <li>Hỗ trợ xem ảnh full size</li>
                        <li>Có thể xóa ảnh không cần thiết</li>
                        <li>Hiển thị thông tin chi tiết về ảnh</li>
                    </ul>
                </div>
            </div>

            <!-- Gallery -->
            <div class="gallery">
                <h2>🖼️ Thư Viện Ảnh</h2>
                
                <?php if (!empty($images)): ?>
                    <div class="gallery-grid">
                        <?php foreach ($images as $image): ?>
                            <?php
                            $image_path = "files/images/{$image}";
                            $thumb_path = "files/images/thumbs/{$image}";
                            $image_info = getImageInfo($image_path);
                            ?>
                            <div class="image-item">
                                <img src="<?= file_exists($thumb_path) ? $thumb_path : $image_path ?>" 
                                     alt="<?= $image ?>" 
                                     class="image-thumb"
                                     onclick="openModal('<?= $image_path ?>')">
                                
                                <div class="image-info">
                                    <strong><?= $image ?></strong>
                                    <div style="color: #666; margin: 0.25rem 0;">
                                        <?= $image_info ? "{$image_info['width']}×{$image_info['height']}" : 'N/A' ?> • 
                                        <?= formatFileSize(filesize($image_path)) ?>
                                    </div>
                                    
                                    <div class="image-actions">
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="view_image">
                                            <input type="hidden" name="filename" value="<?= $image ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">👁️ Xem</button>
                                        </form>
                                        
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete_image">
                                            <input type="hidden" name="filename" value="<?= $image ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa ảnh <?= $image ?>?')">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: #666;">
                        <h3>📭 Chưa có ảnh nào</h3>
                        <p>Hãy upload ảnh đầu tiên của bạn!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Image Viewer -->
        <?php if (!empty($current_image)): ?>
            <?php
            $current_path = "files/images/{$current_image}";
            $current_info = getImageInfo($current_path);
            ?>
            <div class="image-viewer">
                <h2>👁️ Xem Ảnh: <?= $current_image ?></h2>
                
                <img src="<?= $current_path ?>" alt="<?= $current_image ?>" class="image-preview">
                
                <!-- Thông tin chi tiết -->
                <?php if ($current_info): ?>
                    <div class="image-details">
                        <div class="detail-item">
                            <span><strong>Kích thước:</strong></span>
                            <span><?= $current_info['width'] ?> × <?= $current_info['height'] ?> pixels</span>
                        </div>
                        <div class="detail-item">
                            <span><strong>Loại file:</strong></span>
                            <span><?= $current_info['mime'] ?></span>
                        </div>
                        <div class="detail-item">
                            <span><strong>Dung lượng:</strong></span>
                            <span><?= formatFileSize($current_info['size']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span><strong>Sửa đổi lần cuối:</strong></span>
                            <span><?= date('d/m/Y H:i:s', $current_info['modified']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span><strong>Đường dẫn:</strong></span>
                            <span><?= $current_path ?></span>
                        </div>
                        <div class="detail-item">
                            <span><strong>Upload bằng:</strong></span>
                            <span>PHP File Handling</span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Actions -->
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="<?= $current_path ?>" download class="btn btn-success">📥 Tải Xuống</a>
                    <button onclick="openModal('<?= $current_path ?>')" class="btn btn-primary">🔍 Phóng To</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete_image">
                        <input type="hidden" name="filename" value="<?= $current_image ?>">
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc muốn xóa ảnh <?= $current_image ?>?')">
                            🗑️ Xóa Ảnh
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal xem ảnh full size -->
    <div id="imageModal" class="modal">
        <button class="modal-close" onclick="closeModal()">×</button>
        <img id="modalImage" class="modal-content">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        
        // Đóng modal khi click bên ngoài ảnh
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
        
        // Phím tắt
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        
        // Preview ảnh trước khi upload
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                if (fileSize > 5) {
                    alert('Ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 5MB.');
                    e.target.value = '';
                    return;
                }
                
                // Hiển thị preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.innerHTML = `
                        <div style="margin-top: 1rem; text-align: center;">
                            <h4>Preview:</h4>
                            <img src="${e.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                        </div>
                    `;
                    document.querySelector('.upload-area').appendChild(preview);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>