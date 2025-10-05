<h2>Form Liên Hệ & Tính Điểm</h2>

<?php
// Xử lý khi submit form
$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnOK'])) {
    $hoten = htmlspecialchars($_POST['txtHoTen'] ?? '');
    $lop = htmlspecialchars($_POST['txtLop'] ?? '');
    $m1 = floatval($_POST['txtM1'] ?? 0);
    $m2 = floatval($_POST['txtM2'] ?? 0);
    $m3 = floatval($_POST['txtM3'] ?? 0);
    $tong = $m1 + $m2 + $m3;
    
    $result = '
    <div style="background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px;">
        <h3>Kết Quả:</h3>
        <table>
            <tr><td width="30%"><strong>Họ tên:</strong></td><td>' . $hoten . '</td></tr>
            <tr><td><strong>Lớp:</strong></td><td>' . $lop . '</td></tr>
            <tr><td><strong>Điểm M1:</strong></td><td>' . $m1 . '</td></tr>
            <tr><td><strong>Điểm M2:</strong></td><td>' . $m2 . '</td></tr>
            <tr><td><strong>Điểm M3:</strong></td><td>' . $m3 . '</td></tr>
            <tr><td><strong>Tổng điểm:</strong></td><td><strong style="color: #e74c3c;">' . $tong . '</strong></td></tr>
            <tr><td><strong>Điểm trung bình:</strong></td><td><strong style="color: #e74c3c;">' . round($tong/3, 2) . '</strong></td></tr>
        </table>
    </div>';
}
?>

<form method="post" action="" id="contactForm">
    <table>
        <tr>
            <td width="30%">Họ và tên:</td>
            <td>
                <input type="text" name="txtHoTen" 
                       value="<?= isset($_POST['txtHoTen']) ? $_POST['txtHoTen'] : '' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td>Lớp:</td>
            <td>
                <input type="text" name="txtLop" 
                       value="<?= isset($_POST['txtLop']) ? $_POST['txtLop'] : '' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td>Điểm M1:</td>
            <td>
                <input type="number" name="txtM1" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM1']) ? $_POST['txtM1'] : '' ?>" 
                       required id="m1">
            </td>
        </tr>
        <tr>
            <td>Điểm M2:</td>
            <td>
                <input type="number" name="txtM2" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM2']) ? $_POST['txtM2'] : '' ?>" 
                       required id="m2">
            </td>
        </tr>
        <tr>
            <td>Điểm M3:</td>
            <td>
                <input type="number" name="txtM3" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM3']) ? $_POST['txtM3'] : '' ?>" 
                       required id="m3">
            </td>
        </tr>
        <tr>
            <td>Tổng điểm:</td>
            <td>
                <input type="text" name="txtTong" readonly id="tongDiem"
                       value="<?= isset($_POST['txtTong']) ? $_POST['txtTong'] : '0' ?>">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnOK" class="btn">OK</button>
                <button type="reset" class="btn">Cancel</button>
            </td>
        </tr>
    </table>
</form>

<?php echo $result; ?>

<script>
// Tính tổng điểm tự động
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['m1', 'm2', 'm3'];
    const tongDiem = document.getElementById('tongDiem');
    
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', calculateTotal);
    });
    
    function calculateTotal() {
        let total = 0;
        inputs.forEach(id => {
            const value = parseFloat(document.getElementById(id).value) || 0;
            total += value;
        });
        tongDiem.value = total.toFixed(1);
    }
    
    // Tính toán lần đầu khi load trang
    calculateTotal();
});
</script>

<div style="margin-top: 20px; background: #d6daf0; padding: 10px; border-radius: 5px;">
    <strong>💡 Tính năng nổi bật:</strong>
    <ul>
        <li>Tự động tính tổng điểm khi nhập điểm các môn</li>
        <li>Validate dữ liệu nhập vào</li>
        <li>Hiển thị kết quả ngay trên cùng trang</li>
        <li>Responsive design</li>
    </ul>
</div>