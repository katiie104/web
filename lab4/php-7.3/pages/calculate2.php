<h2>📐 Calculate2 - Tính Điểm Sinh Viên</h2>

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
    $trungbinh = round($tong / 3, 2);
    
    // Xếp loại
    if ($trungbinh >= 8.0) {
        $xeploai = 'Giỏi';
        $mau = '#27ae60';
    } elseif ($trungbinh >= 6.5) {
        $xeploai = 'Khá';
        $mau = '#f39c12';
    } elseif ($trungbinh >= 5.0) {
        $xeploai = 'Trung bình';
        $mau = '#e67e22';
    } else {
        $xeploai = 'Yếu';
        $mau = '#e74c3c';
    }
    
    $result = '
    <div class="result">
        <h3>📊 Kết Quả Điểm</h3>
        <table>
            <tr><td width="30%"><strong>Họ tên:</strong></td><td>' . $hoten . '</td></tr>
            <tr><td><strong>Lớp:</strong></td><td>' . $lop . '</td></tr>
            <tr><td><strong>Điểm M1:</strong></td><td>' . $m1 . '</td></tr>
            <tr><td><strong>Điểm M2:</strong></td><td>' . $m2 . '</td></tr>
            <tr><td><strong>Điểm M3:</strong></td><td>' . $m3 . '</td></tr>
            <tr><td><strong>Tổng điểm:</strong></td><td><strong style="color: #e74c3c; font-size: 1.1em;">' . $tong . '</strong></td></tr>
            <tr><td><strong>Điểm TB:</strong></td><td><strong style="color: ' . $mau . '; font-size: 1.1em;">' . $trungbinh . '</strong></td></tr>
            <tr><td><strong>Xếp loại:</strong></td><td><strong style="color: ' . $mau . '; font-size: 1.1em;">' . $xeploai . '</strong></td></tr>
        </table>
    </div>';
}
?>

<form method="post" action="" id="diemForm">
    <table style="width: 70%;">
        <tr>
            <td width="30%"><strong>Họ và tên:</strong></td>
            <td>
                <input type="text" name="txtHoTen" 
                       value="<?= isset($_POST['txtHoTen']) ? $_POST['txtHoTen'] : 'Trần Hồng Khang' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td><strong>Lớp:</strong></td>
            <td>
                <input type="text" name="txtLop" 
                       value="<?= isset($_POST['txtLop']) ? $_POST['txtLop'] : '19C' ?>" 
                       required>
            </td>
        </tr>
        <tr>
            <td><strong>Điểm M1:</strong></td>
            <td>
                <input type="number" name="txtM1" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM1']) ? $_POST['txtM1'] : '8.5' ?>" 
                       required id="m1" class="diem-input">
            </td>
        </tr>
        <tr>
            <td><strong>Điểm M2:</strong></td>
            <td>
                <input type="number" name="txtM2" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM2']) ? $_POST['txtM2'] : '7.5' ?>" 
                       required id="m2" class="diem-input">
            </td>
        </tr>
        <tr>
            <td><strong>Điểm M3:</strong></td>
            <td>
                <input type="number" name="txtM3" step="0.1" min="0" max="10" 
                       value="<?= isset($_POST['txtM3']) ? $_POST['txtM3'] : '9.0' ?>" 
                       required id="m3" class="diem-input">
            </td>
        </tr>
        <tr>
            <td><strong>Tổng điểm:</strong></td>
            <td>
                <input type="text" name="txtTong" readonly id="tongDiem" 
                       value="<?= isset($_POST['txtTong']) ? $_POST['txtTong'] : '25.0' ?>" 
                       style="background: #f8f9fa; font-weight: bold;">
            </td>
        </tr>
        <tr>
            <td><strong>Điểm trung bình:</strong></td>
            <td>
                <input type="text" name="txtTrungBinh" readonly id="trungBinh" 
                       value="<?= isset($_POST['txtTrungBinh']) ? $_POST['txtTrungBinh'] : '8.33' ?>" 
                       style="background: #f8f9fa; font-weight: bold;">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnOK" class="btn">✅ OK</button>
                <button type="reset" class="btn">🔄 Cancel</button>
            </td>
        </tr>
    </table>
</form>

<?php echo $result; ?>

<script>
// Tính điểm tự động
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.diem-input');
    const tongDiem = document.getElementById('tongDiem');
    const trungBinh = document.getElementById('trungBinh');
    
    inputs.forEach(input => {
        input.addEventListener('input', calculateDiem);
    });
    
    function calculateDiem() {
        let total = 0;
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        const avg = total / 3;
        tongDiem.value = total.toFixed(1);
        trungBinh.value = avg.toFixed(2);
        
        // Đổi màu theo điểm
        if (avg >= 8.0) {
            trungBinh.style.color = '#27ae60';
        } else if (avg >= 6.5) {
            trungBinh.style.color = '#f39c12';
        } else if (avg >= 5.0) {
            trungBinh.style.color = '#e67e22';
        } else {
            trungBinh.style.color = '#e74c3c';
        }
    }
    
    calculateDiem(); // Tính ngay khi load
});
</script>