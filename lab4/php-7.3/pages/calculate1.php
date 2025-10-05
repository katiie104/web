<h2>🧮 Calculate1 - Tính Toán Cơ Bản</h2>

<?php
// Xử lý tính toán
$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST['a']) ? (int)$_POST['a'] : 0;
    $b = isset($_POST['b']) ? (int)$_POST['b'] : 0;
    $operator = $_POST['operator'] ?? '';

    switch ($operator) {
        case '+':
            $result = "<span style='color: #27ae60;'>$a + $b = " . ($a + $b) . "</span>";
            break;
        case '-':
            $result = "<span style='color: #e74c3c;'>$a - $b = " . ($a - $b) . "</span>";
            break;
        case '*':
            $result = "<span style='color: #f39c12;'>$a × $b = " . ($a * $b) . "</span>";
            break;
        case '/':
            if ($b == 0) {
                $result = "<span style='color: #c0392b;'>❌ Không thể chia cho 0</span>";
            } else {
                $result = "<span style='color: #8e44ad;'>$a ÷ $b = " . round($a / $b, 2) . "</span>";
            }
            break;
        default:
            $result = "<span style='color: #7f8c8d;'>⚠️ Vui lòng chọn phép tính</span>";
    }
}
?>

<!-- Form tính toán -->
<form method="post" action="">
    <table style="width: 60%;">
        <tr>
            <td width="30%"><strong>Số thứ nhất (a):</strong></td>
            <td>
                <input type="number" name="a" 
                       value="<?= isset($_POST['a']) ? $_POST['a'] : '10' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td><strong>Số thứ hai (b):</strong></td>
            <td>
                <input type="number" name="b" 
                       value="<?= isset($_POST['b']) ? $_POST['b'] : '5' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td><strong>Phép tính:</strong></td>
            <td>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <label style="cursor: pointer;">
                        <input type="radio" name="operator" value="+" 
                               <?= (isset($_POST['operator']) && $_POST['operator'] == '+') ? 'checked' : 'checked' ?>> 
                        ➕ Cộng
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="operator" value="-" 
                               <?= (isset($_POST['operator']) && $_POST['operator'] == '-') ? 'checked' : '' ?>> 
                        ➖ Trừ
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="operator" value="*" 
                               <?= (isset($_POST['operator']) && $_POST['operator'] == '*') ? 'checked' : '' ?>> 
                        ✖️ Nhân
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="operator" value="/" 
                               <?= (isset($_POST['operator']) && $_POST['operator'] == '/') ? 'checked' : '' ?>> 
                        ➗ Chia
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn">🧮 Tính Toán</button>
                <button type="reset" class="btn">🔄 Nhập Lại</button>
            </td>
        </tr>
    </table>
</form>

<!-- Hiển thị kết quả -->
<?php if ($result): ?>
<div class="result">
    <h3>📊 Kết Quả:</h3>
    <div style="font-size: 1.2em; padding: 10px; background: white; border-radius: 5px;">
        <?php echo $result; ?>
    </div>
</div>
<?php endif; ?>

<!-- Demo các phép tính -->
<h3>🎯 Demo Nhanh</h3>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 15px;">
    <?php
    $demos = [
        ['a' => 15, 'b' => 3, 'op' => '+', 'color' => '#27ae60'],
        ['a' => 20, 'b' => 8, 'op' => '-', 'color' => '#e74c3c'],
        ['a' => 6, 'b' => 7, 'op' => '*', 'color' => '#f39c12'],
        ['a' => 50, 'b' => 5, 'op' => '/', 'color' => '#8e44ad']
    ];
    
    foreach ($demos as $demo) {
        $calc = $demo['a'] . ' ' . 
               ($demo['op'] == '+' ? '+' : ($demo['op'] == '-' ? '-' : ($demo['op'] == '*' ? '×' : '÷'))) . 
               ' ' . $demo['b'] . ' = ';
        
        switch ($demo['op']) {
            case '+': $calc .= $demo['a'] + $demo['b']; break;
            case '-': $calc .= $demo['a'] - $demo['b']; break;
            case '*': $calc .= $demo['a'] * $demo['b']; break;
            case '/': $calc .= $demo['a'] / $demo['b']; break;
        }
        
        echo '<div style="padding: 10px; background: ' . $demo['color'] . '; color: white; border-radius: 5px;">';
        echo $calc;
        echo '</div>';
    }
    ?>
</div>