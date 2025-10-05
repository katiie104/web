<?php
/**
 * 📤 UPLOAD FUNCTIONS - Các hàm xử lý upload file
 */

/**
 * Xử lý upload file an toàn
 * @param array $file Mảng $_FILES['file']
 * @param string $target_dir Thư mục đích
 * @param array $allowed_types Các loại file cho phép
 * @param int $max_size Kích thước tối đa (bytes)
 * @return array Kết quả upload
 */
function handleFileUpload(array $file, string $target_dir = 'uploads/', array $allowed_types = [], int $max_size = 2097152): array {
    // Kiểm tra lỗi upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'success' => false,
            'message' => getUploadErrorMessage($file['error'])
        ];
    }
    
    // Kiểm tra kích thước file
    if ($file['size'] > $max_size) {
        return [
            'success' => false,
            'message' => "File quá lớn. Kích thước tối đa: " . formatFileSize($max_size)
        ];
    }
    
    // Thiết lập các loại file cho phép mặc định
    if (empty($allowed_types)) {
        $allowed_types = [
            'txt' => 'text/plain',
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
    }
    
    // Lấy thông tin file
    $filename = sanitizeFilename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    // Kiểm tra loại file
    if (!array_key_exists($file_ext, $allowed_types)) {
        return [
            'success' => false,
            'message' => "Loại file không được phép. Chỉ chấp nhận: " . implode(', ', array_keys($allowed_types))
        ];
    }
    
    // Kiểm tra MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        return [
            'success' => false,
            'message' => "MIME type không hợp lệ"
        ];
    }
    
    // Tạo tên file an toàn
    $safe_filename = generateSafeFilename($filename);
    $target_path = $target_dir . $safe_filename;
    
    // Đảm bảo thư mục tồn tại
    createDirectory($target_dir);
    
    // Di chuyển file upload
    if (move_uploaded_file($file_tmp, $target_path)) {
        return [
            'success' => true,
            'message' => "Upload thành công: {$safe_filename}",
            'filename' => $safe_filename,
            'path' => $target_path,
            'size' => $file_size,
            'type' => $file_type
        ];
    } else {
        return [
            'success' => false,
            'message' => "Lỗi khi di chuyển file upload"
        ];
    }
}

/**
 * Lấy thông báo lỗi upload
 * @param int $error_code Mã lỗi
 * @return string Thông báo lỗi
 */
function getUploadErrorMessage(int $error_code): string {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return "File vượt quá kích thước tối đa cho phép trong php.ini";
        case UPLOAD_ERR_FORM_SIZE:
            return "File vượt quá kích thước tối đa trong form";
        case UPLOAD_ERR_PARTIAL:
            return "File chỉ được upload một phần";
        case UPLOAD_ERR_NO_FILE:
            return "Không có file nào được upload";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Thiếu thư mục tạm";
        case UPLOAD_ERR_CANT_WRITE:
            return "Không thể ghi file vào disk";
        case UPLOAD_ERR_EXTENSION:
            return "Upload bị dừng bởi extension PHP";
        default:
            return "Lỗi upload không xác định";
    }
}

/**
 * Tạo tên file an toàn
 * @param string $filename Tên file gốc
 * @return string Tên file an toàn
 */
function generateSafeFilename(string $filename): string {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $name = pathinfo($filename, PATHINFO_FILENAME);
    
    // Loại bỏ ký tự đặc biệt
    $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
    
    // Thêm timestamp để tránh trùng lặp
    $timestamp = time();
    
    return $safe_name . '_' . $timestamp . '.' . $extension;
}

/**
 * Làm sạch tên file
 * @param string $filename Tên file
 * @return string Tên file đã làm sạch
 */
function sanitizeFilename(string $filename): string {
    // Loại bỏ đường dẫn
    $filename = basename($filename);
    
    // Thay thế ký tự không hợp lệ
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    
    // Giới hạn độ dài
    if (strlen($filename) > 255) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $filename = substr($name, 0, 255 - strlen($extension) - 1) . '.' . $extension;
    }
    
    return $filename;
}

/**
 * Kiểm tra xem file có phải là ảnh không
 * @param string $file_path Đường dẫn file
 * @return bool True nếu là ảnh
 */
function isImageFile(string $file_path): bool {
    if (!file_exists($file_path)) {
        return false;
    }
    
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_path);
    finfo_close($finfo);
    
    return in_array($mime_type, $allowed_image_types);
}

/**
 * Lấy danh sách file trong thư mục
 * @param string $directory Đường dẫn thư mục
 * @param string $pattern Pattern tìm kiếm
 * @return array Danh sách file
 */
function listFilesInDirectory(string $directory, string $pattern = '*'): array {
    if (!is_dir($directory)) {
        return [];
    }
    
    $files = glob($directory . '/' . $pattern);
    if ($files === false) {
        return [];
    }
    
    // Chỉ lấy file, không lấy thư mục
    $files = array_filter($files, 'is_file');
    
    // Chỉ lấy tên file, không lấy đường dẫn đầy đủ
    $files = array_map('basename', $files);
    
    return array_values($files);
}

/**
 * Tạo thư mục nếu chưa tồn tại
 * @param string $directory Đường dẫn thư mục
 * @param int $permissions Quyền thư mục
 * @return bool True nếu thành công
 */
function createDirectory(string $directory, int $permissions = 0755): bool {
    if (!is_dir($directory)) {
        return mkdir($directory, $permissions, true);
    }
    return true;
}

/**
 * Format kích thước file
 * @param int $bytes Kích thước tính bằng bytes
 * @return string Kích thước đã format
 */
function formatFileSize(int $bytes): string {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>