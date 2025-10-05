<h2>Tính Toán</h2>

<?php
// Xử lý tính toán nếu có dữ liệu POST
$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST['a']) ? (int)$_POST['a'] : 0;
    $b = isset($_POST['b']) ? (int)$_POST['b'] : 0;
    $operator = $_POST['operator'] ?? '';

    switch ($operator) {
        case '+':
            $result = "$a + $b = " . ($a + $b);
            break;
        case '-':
            $result = "$a - $b = " . ($a - $b);
            break;
        case '*':
            $result = "$a * $b = " . ($a * $b);
            break;
        case '/':
            if ($b == 0) {
                $result = "Không thể chia cho 0";
            } else {
                $result = "$a / $b = " . round($a / $b, 2);
            }
            break;
        default:
            $result = "Vui lòng chọn phép tính";
    }
}
?>

<!-- Form tính toán -->
<form method="post" action="">
    <table>
        <tr>
            <td>Số a:</td>
            <td><input type="number" name="a" value="<?= isset($_POST['a']) ? $_POST['a'] : '' ?>" required></td>
        </tr>
        <tr>
            <td>Số b:</td>
            <td><input type="number" name="b" value="<?= isset($_POST['b']) ? $_POST['b'] : '' ?>" required></td>
        </tr>
        <tr>
            <td>Phép tính:</td>
            <td>
                <label><input type="radio" name="operator" value="+" <?= (isset($_POST['operator']) && $_POST['operator'] == '+') ? 'checked' : '' ?>> Cộng</label>
                <label><input type="radio" name="operator" value="-" <?= (isset($_POST['operator']) && $_POST['operator'] == '-') ? 'checked' : '' ?>> Trừ</label>
                <label><input type="radio" name="operator" value="*" <?= (isset($_POST['operator']) && $_POST['operator'] == '*') ? 'checked' : '' ?>> Nhân</label>
                <label><input type="radio" name="operator" value="/" <?= (isset($_POST['operator']) && $_POST['operator'] == '/') ? 'checked' : '' ?>> Chia</label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn">Tính Toán</button>
                <button type="reset" class="btn">Nhập Lại</button>
            </td>
        </tr>
    </table>
</form>

<?php if ($result): ?>
    <div style="margin-top: 20px; padding: 10px; background: #e8f6f3; border-radius: 5px;">
        <strong>Kết quả: </strong><?php echo $result; ?>
    </div>
<?php endif; ?>

<hr>

<h3>Tính toán tự động</h3>
<?php
// Tính giai thừa của 10
$giaithua = 1;
for($i = 1; $i <= 10; $i++) {
    $giaithua *= $i;
}
echo "<p><strong>Giai thừa của 10:</strong> $giaithua</p>";

// Tính diện tích hình tròn và thể tích khối cầu (bán kính = 10)
$r = 10;
$dientich = round(pi() * $r * $r, 2);
$thetich = round((4/3) * pi() * pow($r, 3), 2);
echo "<p><strong>Diện tích hình tròn (r=10):</strong> $dientich</p>";
echo "<p><strong>Thể tích khối cầu (r=10):</strong> $thetich</p>";
?>