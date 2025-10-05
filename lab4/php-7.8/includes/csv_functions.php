<?php
/**
 * 📊 CSV FUNCTIONS - Các hàm xử lý file CSV
 */

/**
 * Đọc file CSV và trả về mảng
 * @param string $file_path Đường dẫn file CSV
 * @param bool $has_header Có header không
 * @param string $delimiter Dấu phân cách
 * @return array Dữ liệu CSV
 */
function readCSV(string $file_path, bool $has_header = true, string $delimiter = ','): array {
    if (!file_exists($file_path)) {
        throw new Exception("File CSV không tồn tại: {$file_path}");
    }
    
    $data = [];
    $header = [];
    
    if (($handle = fopen($file_path, 'r')) !== FALSE) {
        // Đọc header nếu có
        if ($has_header) {
            $header = fgetcsv($handle, 0, $delimiter);
            if ($header === FALSE) {
                fclose($handle);
                throw new Exception("Lỗi khi đọc header CSV");
            }
        }
        
        // Đọc dữ liệu
        while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
            if ($has_header && !empty($header)) {
                // Kết hợp với header thành associative array
                $data[] = array_combine($header, $row);
            } else {
                $data[] = $row;
            }
        }
        
        fclose($handle);
    } else {
        throw new Exception("Không thể mở file CSV: {$file_path}");
    }
    
    return $data;
}

/**
 * Ghi mảng dữ liệu ra file CSV
 * @param string $file_path Đường dẫn file CSV
 * @param array $data Dữ liệu cần ghi
 * @param array $header Header (nếu có)
 * @param string $delimiter Dấu phân cách
 * @return bool True nếu thành công
 */
function writeCSV(string $file_path, array $data, array $header = [], string $delimiter = ','): bool {
    $dir = dirname($file_path);
    if (!is_dir($dir)) {
        createDirectory($dir);
    }
    
    if (($handle = fopen($file_path, 'w')) !== FALSE) {
        // Ghi header nếu có
        if (!empty($header)) {
            fputcsv($handle, $header, $delimiter);
        }
        
        // Ghi dữ liệu
        foreach ($data as $row) {
            fputcsv($handle, $row, $delimiter);
        }
        
        fclose($handle);
        return true;
    }
    
    return false;
}

/**
 * Thêm dòng vào file CSV
 * @param string $file_path Đường dẫn file CSV
 * @param array $row Dòng cần thêm
 * @param string $delimiter Dấu phân cách
 * @return bool True nếu thành công
 */
function appendToCSV(string $file_path, array $row, string $delimiter = ','): bool {
    if (!file_exists($file_path)) {
        throw new Exception("File CSV không tồn tại: {$file_path}");
    }
    
    if (($handle = fopen($file_path, 'a')) !== FALSE) {
        fputcsv($handle, $row, $delimiter);
        fclose($handle);
        return true;
    }
    
    return false;
}

/**
 * Chuyển đổi mảng thành chuỗi CSV
 * @param array $data Dữ liệu
 * @param array $header Header
 * @param string $delimiter Dấu phân cách
 * @return string Chuỗi CSV
 */
function arrayToCSVString(array $data, array $header = [], string $delimiter = ','): string {
    $output = fopen('php://temp', 'r+');
    
    // Ghi header
    if (!empty($header)) {
        fputcsv($output, $header, $delimiter);
    }
    
    // Ghi dữ liệu
    foreach ($data as $row) {
        fputcsv($output, $row, $delimiter);
    }
    
    rewind($output);
    $csv_string = stream_get_contents($output);
    fclose($output);
    
    return $csv_string;
}

/**
 * Lấy thông tin về file CSV
 * @param string $file_path Đường dẫn file CSV
 * @return array Thông tin CSV
 */
function getCSVInfo(string $file_path): array {
    if (!file_exists($file_path)) {
        throw new Exception("File CSV không tồn tại: {$file_path}");
    }
    
    $data = readCSV($file_path, false);
    
    return [
        'total_rows' => count($data),
        'total_columns' => !empty($data) ? count($data[0]) : 0,
        'file_size' => formatFileSize(filesize($file_path)),
        'sample_data' => array_slice($data, 0, 5) // 5 dòng đầu tiên
    ];
}

/**
 * Tìm kiếm trong file CSV
 * @param string $file_path Đường dẫn file CSV
 * @param string $search_term Từ khóa tìm kiếm
 * @param bool $case_sensitive Phân biệt hoa thường
 * @return array Kết quả tìm kiếm
 */
function searchInCSV(string $file_path, string $search_term, bool $case_sensitive = false): array {
    $data = readCSV($file_path, true);
    $results = [];
    
    foreach ($data as $index => $row) {
        foreach ($row as $value) {
            if ($case_sensitive) {
                $found = strpos($value, $search_term) !== FALSE;
            } else {
                $found = stripos($value, $search_term) !== FALSE;
            }
            
            if ($found) {
                $results[] = [
                    'row_index' => $index + 2, // +2 vì có header và index bắt đầu từ 0
                    'data' => $row
                ];
                break; // Chỉ thêm mỗi dòng một lần
            }
        }
    }
    
    return $results;
}
?>