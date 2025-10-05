<h2>🔄 Loop - Vòng Lặp PHP</h2>

<?php
// Xử lý khi submit form
$loop_result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnHienThi'])) {
    $n = intval($_POST['so_lan'] ?? 5);
    
    $loop_result .= '<h3>✅ For Loop (1 đến ' . $n . '):</h3>';
    $loop_result .= '<div style="background: #f0f0f0; padding: 10px; border-radius: 5px;">';
    for ($i = 1; $i <= $n; $i++) {
        $loop_result .= '<span style="display: inline-block; padding: 5px; margin: 2px; background: #3498db; color: white; border-radius: 3px;">' . $i . '</span>';
    }
    $loop_result .= '</div>';
    
    $loop_result .= '<h3>✅ While Loop (Bảng cửu chương 2):</h3>';
    $loop_result .= '<div style="background: #f0f0f0; padding: 10px; border-radius: 5px;">';
    $i = 1;
    while ($i <= 10) {
        $loop_result .= '2 × ' . $i . ' = ' . (2 * $i) . '<br>';
        $i++;
    }
    $loop_result .= '</div>';
    
    $loop_result .= '<h3>✅ Foreach Loop (Mảng màu sắc):</h3>';
    $colors = ['Đỏ', 'Xanh', 'Vàng', 'Tím', 'Cam'];
    $loop_result .= '<div style="background: #f0f0f0; padding: 10px; border-radius: 5px;">';
    foreach ($colors as $index => $color) {
        $loop_result .= 'Màu ' . ($index + 1) . ': <strong>' . $color . '</strong><br>';
    }
    $loop_result .= '</div>';
}
?>

<!-- Form nhập số lần lặp -->
<form method="post" action="">
    <table>
        <tr>
            <td width="30%"><strong>Số lần lặp:</strong></td>
            <td>
                <input type="number" name="so_lan" min="1" max="20" 
                       value="<?= isset($_POST['so_lan']) ? $_POST['so_lan'] : '5' ?>" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnHienThi" class="btn">🔄 Hiển Thị Loop</button>
                <button type="reset" class="btn">🗑️ Reset</button>
            </td>
        </tr>
    </table>
</form>

<!-- Hiển thị kết quả loop -->
<?php echo $loop_result; ?>

<!-- Demo các loại loop -->
<h3>🎯 Demo Các Loại Vòng Lặp</h3>

<div style="display: flex; gap: 20px; margin-top: 20px;">
    <div style="flex: 1; background: #e8f6f3; padding: 15px; border-radius: 5px;">
        <h4>For Loop</h4>
        <?php
        for ($i = 1; $i <= 3; $i++) {
            echo "Vòng lặp for: $i<br>";
        }
        ?>
    </div>
    
    <div style="flex: 1; background: #fce4ec; padding: 15px; border-radius: 5px;">
        <h4>While Loop</h4>
        <?php
        $i = 1;
        while ($i <= 3) {
            echo "Vòng lặp while: $i<br>";
            $i++;
        }
        ?>
    </div>
    
    <div style="flex: 1; background: #f3e5f5; padding: 15px; border-radius: 5px;">
        <h4>Foreach Loop</h4>
        <?php
        $items = ['PHP', 'HTML', 'CSS'];
        foreach ($items as $item) {
            echo "Ngôn ngữ: $item<br>";
        }
        ?>
    </div>
</div>