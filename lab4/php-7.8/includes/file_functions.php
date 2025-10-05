<?php
/**
 * 📁 FILE FUNCTIONS - Các hàm xử lý file cơ bản
 */

/**
 * Tạo file mới với nội dung
 * @param string $path Đường dẫn file
 * @param string $content Nội dung
 * @return bool True nếu thành công
 */
function createFile(string $path, string $content = ''): bool {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        createDirectory($dir);
    }
    
    $result = file_put_contents($path, $content);
    return $result !== false;
}

/**
 * Đọc toàn bộ nội dung file
 * @param string $path Đường dẫn file
 * @return string Nội dung file
 */
function readFileContent(string $path): string {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    if (!is_readable($path)) {
        throw new Exception("Không có quyền đọc file: {$path}");
    }
    
    $content = file_get_contents($path);
    if ($content === false) {
        throw new Exception("Lỗi khi đọc file: {$path}");
    }
    
    return $content;
}

/**
 * Ghi nội dung vào file (ghi đè)
 * @param string $path Đường dẫn file
 * @param string $content Nội dung
 * @return bool True nếu thành công
 */
function writeFileContent(string $path, string $content): bool {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    if (!is_writable($path)) {
        throw new Exception("Không có quyền ghi file: {$path}");
    }
    
    $result = file_put_contents($path, $content);
    return $result !== false;
}

/**
 * Thêm nội dung vào cuối file
 * @param string $path Đường dẫn file
 * @param string $content Nội dung thêm
 * @return bool True nếu thành công
 */
function appendToFile(string $path, string $content): bool {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    $result = file_put_contents($path, $content, FILE_APPEND | LOCK_EX);
    return $result !== false;
}

/**
 * Đọc file theo từng dòng
 * @param string $path Đường dẫn file
 * @return array Mảng các dòng
 */
function readFileLines(string $path): array {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        throw new Exception("Lỗi khi đọc file: {$path}");
    }
    
    return $lines;
}

/**
 * Lấy thông tin chi tiết về file
 * @param string $path Đường dẫn file
 * @return array Thông tin file
 */
function getFileInfo(string $path): array {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    $stat = stat($path);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $path);
    finfo_close($finfo);
    
    return [
        'name' => basename($path),
        'path' => $path,
        'size' => $stat['size'],
        'type' => $mime_type,
        'modified' => $stat['mtime'],
        'created' => $stat['ctime'],
        'permissions' => substr(sprintf('%o', fileperms($path)), -4),
        'extension' => pathinfo($path, PATHINFO_EXTENSION),
        'is_readable' => is_readable($path),
        'is_writable' => is_writable($path)
    ];
}

/**
 * Kiểm tra xem file có tồn tại và có thể đọc được không
 * @param string $path Đường dẫn file
 * @return bool True nếu file hợp lệ
 */
function isValidFile(string $path): bool {
    return file_exists($path) && is_file($path) && is_readable($path);
}

/**
 * Xóa file
 * @param string $path Đường dẫn file
 * @return bool True nếu thành công
 */
function deleteFile(string $path): bool {
    if (!file_exists($path)) {
        throw new Exception("File không tồn tại: {$path}");
    }
    
    if (!is_writable($path)) {
        throw new Exception("Không có quyền xóa file: {$path}");
    }
    
    return unlink($path);
}

/**
 * Sao chép file
 * @param string $source Đường dẫn nguồn
 * @param string $destination Đường dẫn đích
 * @return bool True nếu thành công
 */
function copyFile(string $source, string $destination): bool {
    if (!file_exists($source)) {
        throw new Exception("File nguồn không tồn tại: {$source}");
    }
    
    $dir = dirname($destination);
    if (!is_dir($dir)) {
        createDirectory($dir);
    }
    
    return copy($source, $destination);
}

/**
 * Đổi tên hoặc di chuyển file
 * @param string $old_path Đường dẫn cũ
 * @param string $new_path Đường dẫn mới
 * @return bool True nếu thành công
 */
function renameFile(string $old_path, string $new_path): bool {
    if (!file_exists($old_path)) {
        throw new Exception("File không tồn tại: {$old_path}");
    }
    
    $dir = dirname($new_path);
    if (!is_dir($dir)) {
        createDirectory($dir);
    }
    
    return rename($old_path, $new_path);
}
?>