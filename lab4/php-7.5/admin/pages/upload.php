<h2>📁 Upload Files - Khu Vực Bảo Mật</h2>

<?php
// Tạo thư mục uploads nếu chưa tồn tại
$upload_dir = "../uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Xử lý upload file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['uploadedFile'])) {
    $file = $_FILES['uploadedFile'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = basename($file['name']);
        $target_path = $upload_dir . $filename;
        
        // Kiểm tra loại file (bảo mật)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain'];
        $file_type = mime_content_type($file['tmp_name']);
        
        if (!in_array($file_type, $allowed_types)) {
            $upload_message = "❌ Loại file không được hỗ trợ!";
            $message_type = "error";
        } elseif ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
            $upload_message = "❌ File quá lớn! Tối đa 5MB.";
            $message_type = "error";
        } elseif (move_uploaded_file($file['tmp_name'], $target_path)) {
            $upload_message = "✅ Upload file thành công: " . htmlspecialchars($filename);
            $message_type = "success";
            
            // Lưu thông tin file vào session
            $_SESSION['uploaded_files'][] = [
                'filename' => $filename,
                'upload_time' => date('Y-m-d H:i:s'),
                'size' => $file['size']
            ];
        } else {
            $upload_message = "❌ Lỗi khi upload file!";
            $message_type = "error";
        }
    } else {
        $upload_message = "❌ Lỗi upload: " . $file['error'];
        $message_type = "error";
    }
    
    // Hiển thị thông báo
    echo '<div class="alert alert-' . $message_type . '">' . $upload_message . '</div>';
}
?>

<!-- Form upload file -->
<form method="post" action="" enctype="multipart/form-data" style="background: #f8f9fa; padding: 25px; border-radius: 10px;">
    <h3>📤 Upload File Mới</h3>
    
    <div style="margin: 15px 0;">
        <label><strong>Chọn file để upload:</strong></label>
        <input type="file" name="uploadedFile" required 
               accept=".jpg,.jpeg,.png,.gif,.pdf,.txt" 
               style="width: 100%; padding: 10px; margin: 10px 0; border: 2px dashed #3498db; border-radius: 5px;">
    </div>
    
    <div style="background: #e8f6f3; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <h4>📋 Thông Tin Upload:</h4>
        <ul>
            <li><strong>Định dạng cho phép:</strong> JPG, PNG, GIF, PDF, TXT</li>
            <li><strong>Kích thước tối đa:</strong> 5MB</li>
            <li><strong>Thư mục lưu trữ:</strong> <code><?= realpath($upload_dir) ?></code></li>
        </ul>
    </div>
    
    <button type="submit" class="btn" style="background: #27ae60;">🚀 Upload File</button>
    <button type="reset" class="btn">🔄 Reset</button>
</form>

<!-- Danh sách file đã upload -->
<div style="margin-top: 30px;">
    <h3>📂 File Đã Upload</h3>
    
    <?php
    $files = scandir($upload_dir);
    $uploaded_files = array_diff($files, ['.', '..']);
    
    if (empty($uploaded_files)) {
        echo '<p style="text-align: center; color: #7f8c8d; padding: 20px;">📭 Chưa có file nào được upload</p>';
    } else {
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-top: 15px;">';
        
        foreach ($uploaded_files as $file) {
            $file_path = $upload_dir . $file;
            $file_size = filesize($file_path);
            $file_time = date('Y-m-d H:i:s', filemtime($file_path));
            
            echo '<div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">';
            echo '<div style="font-size: 2em; text-align: center;">📄</div>';
            echo '<h4>' . htmlspecialchars($file) . '</h4>';
            echo '<p><strong>Size:</strong> ' . formatFileSize($file_size) . '</p>';
            echo '<p><strong>Upload:</strong> ' . $file_time . '</p>';
            echo '<div style="display: flex; gap: 10px; margin-top: 10px;">';
            echo '<a href="' . $file_path . '" download class="btn" style="flex: 1; text-align: center;">⬇️ Download</a>';
            echo '<a href="' . $file_path . '" target="_blank" class="btn" style="flex: 1; text-align: center;">👁️ View</a>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
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
    ?>
</div>

<!-- Session upload history -->
<?php if (!empty($_SESSION['uploaded_files'])): ?>
<div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin-top: 25px;">
    <h3>📊 Lịch Sử Upload (Session)</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr style="background: #f39c12; color: white;">
            <th style="padding: 10px; text-align: left;">File Name</th>
            <th style="padding: 10px; text-align: left;">Upload Time</th>
            <th style="padding: 10px; text-align: left;">Size</th>
        </tr>
        <?php foreach ($_SESSION['uploaded_files'] as $file): ?>
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 10px;"><?= htmlspecialchars($file['filename']) ?></td>
            <td style="padding: 10px;"><?= $file['upload_time'] ?></td>
            <td style="padding: 10px;"><?= formatFileSize($file['size']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>