<h2>📊 DrawTable - Vẽ Bảng Động</h2>

<?php
// Xử lý khi submit form
$table_html = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnVe'])) {
    $rows = intval($_POST['rows'] ?? 4);
    $cols = intval($_POST['cols'] ?? 4);
    
    // Tạo bảng HTML
    $table_html = '<h3>✅ Bảng ' . $rows . '×' . $cols . ':</h3>';
    $table_html .= '<table border="1" cellpadding="10" style="border-collapse: collapse; margin: 15px 0;">';
    
    for ($i = 1; $i <= $rows; $i++) {
        $table_html .= '<tr>';
        for ($j = 1; $j <= $cols; $j++) {
            // Tạo giá trị theo pattern: 1, 2, 3... hoặc 1-1, 1-2...
            $value = ($i - 1) * $cols + $j;
            $table_html .= '<td style="text-align: center; background: #' . 
                          ($i % 2 == 0 ? 'f9f9f9' : 'ffffff') . ';">' . $value . '</td>';
        }
        $table_html .= '</tr>';
    }
    $table_html .= '</table>';
}
?>

<!-- Form nhập số dòng, số cột -->
<form method="post" action="">
    <table style="width: 50%;">
        <tr>
            <td width="30%"><strong>Số dòng:</strong></td>
            <td>
                <input type="number" name="rows" min="1" max="20" 
                       value="<?= isset($_POST['rows']) ? $_POST['rows'] : '4' ?>" required>
            </td>
        </tr>
        <tr>
            <td><strong>Số cột:</strong></td>
            <td>
                <input type="number" name="cols" min="1" max="20" 
                       value="<?= isset($_POST['cols']) ? $_POST['cols'] : '4' ?>" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnVe" class="btn">🎨 Vẽ Bảng</button>
                <button type="reset" class="btn">🔄 Nhập Lại</button>
            </td>
        </tr>
    </table>
</form>

<!-- Hiển thị bảng -->
<?php echo $table_html; ?>

<!-- Bảng mẫu theo yêu cầu đề bài -->
<h3>📋 Bảng mẫu (4×4) - Pattern tăng dần:</h3>
<table border="1" cellpadding="10" style="border-collapse: collapse; margin: 15px 0;">
    <tr>
        <td>1</td><td></td><td></td><td></td>
    </tr>
    <tr>
        <td>1</td><td>2</td><td></td><td></td>
    </tr>
    <tr>
        <td>1</td><td>2</td><td>3</td><td></td>
    </tr>
    <tr>
        <td>1</td><td>2</td><td>3</td><td>4</td>
    </tr>
</table>

<div class="result">
    <h4>💡 Kỹ thuật sử dụng:</h4>
    <ul>
        <li><strong>Method:</strong> POST - gửi dữ liệu lên chính trang</li>
        <li><strong>Xử lý:</strong> PHP xử lý và trả kết quả ngay</li>
        <li><strong>Dynamic:</strong> Tạo bảng HTML động từ PHP</li>
    </ul>
</div>