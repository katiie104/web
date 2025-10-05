<h2>Vẽ Bảng Động</h2>

<?php
// Xử lý khi người dùng nhấn nút Vẽ
$table_html = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnVe'])) {
    $rows = isset($_POST['rows']) ? (int)$_POST['rows'] : 4;
    $cols = isset($_POST['cols']) ? (int)$_POST['cols'] : 4;
    
    // Tạo bảng HTML
    $table_html = '<h3>Bảng ' . $rows . '×' . $cols . ':</h3>';
    $table_html .= '<table border="1" cellpadding="10" style="border-collapse: collapse; margin: 10px 0;">';
    
    for ($i = 1; $i <= $rows; $i++) {
        $table_html .= '<tr>';
        for ($j = 1; $j <= $cols; $j++) {
            $value = ($i - 1) * $cols + $j;
            $table_html .= '<td style="text-align: center; background: #' . ($i % 2 == 0 ? 'f0f0f0' : 'ffffff') . ';">' . $value . '</td>';
        }
        $table_html .= '</tr>';
    }
    $table_html .= '</table>';
}
?>

<!-- Form nhập số dòng, số cột -->
<form method="post" action="">
    <table>
        <tr>
            <td>Số dòng:</td>
            <td>
                <input type="number" name="rows" min="1" max="10" 
                       value="<?= isset($_POST['rows']) ? $_POST['rows'] : '4' ?>" required>
            </td>
        </tr>
        <tr>
            <td>Số cột:</td>
            <td>
                <input type="number" name="cols" min="1" max="10" 
                       value="<?= isset($_POST['cols']) ? $_POST['cols'] : '4' ?>" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnVe" class="btn">Vẽ Bảng</button>
                <button type="reset" class="btn">Nhập Lại</button>
            </td>
        </tr>
    </table>
</form>

<!-- Hiển thị bảng -->
<?php echo $table_html; ?>

<!-- Bảng mẫu theo yêu cầu đề bài -->
<h3>Bảng mẫu (4×4):</h3>
<table border="1" cellpadding="10" style="border-collapse: collapse; margin: 10px 0;">
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