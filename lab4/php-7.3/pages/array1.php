<h2>📋 Array1 - Ma Trận 2 Chiều</h2>

<?php
// Xử lý khi nhấn nút Tính
$ketqua_html = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnTinh'])) {
    
    // Tạo ma trận 1 từ dữ liệu nhập
    $matran1 = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $matran1[$i][$j] = intval($_POST['matran1'][$i][$j] ?? 0);
        }
    }
    
    // Tạo ma trận 2 từ dữ liệu nhập
    $matran2 = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $matran2[$i][$j] = intval($_POST['matran2'][$i][$j] ?? 0);
        }
    }
    
    // Tính toán các ma trận
    $tong = $hieu = $tich = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $tong[$i][$j] = $matran1[$i][$j] + $matran2[$i][$j];
            $hieu[$i][$j] = $matran1[$i][$j] - $matran2[$i][$j];
            
            // Tính tích (đơn giản hóa)
            $tich[$i][$j] = 0;
            for ($k = 0; $k < 3; $k++) {
                $tich[$i][$j] += $matran1[$i][$k] * $matran2[$k][$j];
            }
        }
    }
    
    // Hiển thị kết quả
    $ketqua_html = '<h3>✅ KẾT QUẢ:</h3>';
    
    $ketqua_html .= '<h4>Ma trận Tổng:</h4>';
    $ketqua_html .= displayMatrix($tong);
    
    $ketqua_html .= '<h4>Ma trận Hiệu:</h4>';
    $ketqua_html .= displayMatrix($hieu);
    
    $ketqua_html .= '<h4>Ma trận Tích:</h4>';
    $ketqua_html .= displayMatrix($tich);
}

// Hàm hiển thị ma trận
function displayMatrix($matrix) {
    $html = '<table border="1" cellpadding="10" style="border-collapse: collapse; margin: 10px 0;">';
    foreach ($matrix as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td style="text-align: center; background: #f8f9fa;">' . $cell . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}
?>

<form method="post" action="">
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <!-- Ma trận 1 -->
        <div style="flex: 1;">
            <h3>Nhập Ma trận 1</h3>
            <table border="1" cellpadding="10" style="border-collapse: collapse;">
                <?php for ($i = 0; $i < 3; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++): ?>
                    <td>
                        <input type="number" name="matran1[<?= $i ?>][<?= $j ?>]" 
                               value="<?= isset($_POST['matran1'][$i][$j]) ? $_POST['matran1'][$i][$j] : ($i + 1) ?>" 
                               style="width: 50px; text-align: center;">
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
        
        <!-- Ma trận 2 -->
        <div style="flex: 1;">
            <h3>Nhập Ma trận 2</h3>
            <table border="1" cellpadding="10" style="border-collapse: collapse;">
                <?php for ($i = 0; $i < 3; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++): ?>
                    <td>
                        <input type="number" name="matran2[<?= $i ?>][<?= $j ?>]" 
                               value="<?= isset($_POST['matran2'][$i][$j]) ? $_POST['matran2'][$i][$j] : '0' ?>" 
                               style="width: 50px; text-align: center;">
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
    
    <div style="text-align: center;">
        <button type="submit" name="btnTinh" class="btn">🧮 Tính Toán</button>
        <button type="reset" class="btn">🔄 Nhập Lại</button>
    </div>
</form>

<?php echo $ketqua_html; ?>

<!-- Demo ma trận mẫu -->
<h3>🎯 Ma Trận Mẫu</h3>
<div style="display: flex; gap: 15px; margin-top: 15px;">
    <div style="flex: 1; text-align: center;">
        <strong>Ma trận 1</strong>
        <?php
        $demo1 = [[1, 1, 1], [2, 2, 2], [3, 3, 3]];
        echo displayMatrix($demo1);
        ?>
    </div>
    <div style="flex: 1; text-align: center;">
        <strong>Ma trận 2</strong>
        <?php
        $demo2 = [[0, 0, 0], [0, 0, 0], [0, 0, 0]];
        echo displayMatrix($demo2);
        ?>
    </div>
</div>