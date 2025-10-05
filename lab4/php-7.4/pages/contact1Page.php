<h2>📞 Contact Form</h2>

<?php
// Xử lý form trên cùng trang
$showForm = true;
$resultData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnContact"])) {
    $showForm = false;
    
    // Lấy dữ liệu từ form
    $resultData = [
        'username' => htmlspecialchars($_POST["txtUsername"] ?? ''),
        'gender' => htmlspecialchars($_POST["radGender"] ?? ''),
        'address' => htmlspecialchars($_POST["lstAddress"] ?? ''),
        'note' => htmlspecialchars($_POST["taNote"] ?? '')
    ];
    
    // Lưu vào session
    $_SESSION['contact_data'] = $resultData;
}
?>

<?php if ($showForm): ?>
<!-- Hiển thị form nếu chưa submit -->
<div class="result">
    <h3>💬 Form Liên Hệ</h3>
    <p>Form này xử lý dữ liệu trên cùng trang (không chuyển trang)</p>
</div>

<form name="formContact" method="post" action="">
    <table>
        <tr>
            <td colspan="2" style="text-align: center; background: linear-gradient(135deg, #2ecc71, #27ae60); color: white;">
                <h3>📋 Form Liên Hệ</h3>
            </td>
        </tr>
        
        <!-- Username -->
        <tr>
            <td width="30%"><strong>👤 Username:</strong></td>
            <td>
                <input type="text" name="txtUsername" 
                       value="<?= isset($_POST['txtUsername']) ? htmlspecialchars($_POST['txtUsername']) : 'Pham Gia Minh' ?>" 
                       required>
            </td>
        </tr>
        
        <!-- Gender -->
        <tr>
            <td><strong>⚤ Gender:</strong></td>
            <td>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="radGender" value="Male" checked> 
                        👨 Male
                    </label>
                    <label>
                        <input type="radio" name="radGender" value="Female"> 
                        👩 Female
                    </label>
                </div>
            </td>
        </tr>
        
        <!-- Address -->
        <tr>
            <td><strong>🏠 Address:</strong></td>
            <td>
                <select name="lstAddress" required>
                    <option value="Ha Noi">Hà Nội</option>
                    <option value="TP.HCM">TP. HCM</option>
                    <option value="Hue">Huế</option>
                    <option value="Da Nang">Đà Nẵng</option>
                </select>
            </td>
        </tr>
        
        <!-- Note -->
        <tr>
            <td><strong>📝 Note:</strong></td>
            <td>
                <textarea name="taNote" rows="3" placeholder="Nhập ghi chú..."><?= isset($_POST['taNote']) ? htmlspecialchars($_POST['taNote']) : 'Very good' ?></textarea>
            </td>
        </tr>
        
        <!-- Submit -->
        <tr>
            <td></td>
            <td>
                <button type="submit" name="btnContact" class="btn">📧 Contact</button>
                <button type="reset" class="btn btn-reset">🔄 Reset</button>
            </td>
        </tr>
    </table>
</form>

<?php else: ?>
<!-- Hiển thị kết quả sau khi submit -->
<div class="result">
    <h3>✅ Thông Tin Liên Hệ Đã Gửi</h3>
    <p>Form đã được ẩn đi và hiển thị kết quả bên dưới:</p>
</div>

<table>
    <tr><td colspan="2" style="text-align: center; background: #27ae60; color: white;"><strong>📊 THÔNG TIN LIÊN HỆ</strong></td></tr>
    <tr><td width="30%"><strong>👤 Username:</strong></td><td><?= $resultData['username'] ?></td></tr>
    <tr><td><strong>⚤ Gender:</strong></td><td><?= $resultData['gender'] ?></td></tr>
    <tr><td><strong>🏠 Address:</strong></td><td><?= $resultData['address'] ?></td></tr>
    <tr><td><strong>📝 Note:</strong></td><td><?= $resultData['note'] ?></td></tr>
</table>

<div style="text-align: center; margin-top: 20px;">
    <button onclick="window.location.href='index.php?page=contact1Page'" class="btn">📝 Hiện Lại Form</button>
    <a href="index.php?page=home" class="btn">🏠 Về Trang Chủ</a>
</div>

<!-- Hiển thị POST data -->
<div style="background: #e8f6f3; padding: 15px; border-radius: 8px; margin-top: 20px;">
    <h4>🔍 POST Data Received:</h4>
    <pre><?php print_r($_POST); ?></pre>
</div>
<?php endif; ?>

<div class="result" style="margin-top: 30px;">
    <h3>🎯 Đặc Điểm Form Này</h3>
    <ul>
        <li><strong>🔁 Xử lý trên cùng trang:</strong> <code>action=""</code></li>
        <li><strong>👁️ Ẩn/hiện form:</strong> Dùng PHP để điều khiển hiển thị</li>
        <li><strong>⚡ Real-time:</strong> Không cần reload trang (nếu dùng AJAX)</li>
        <li><strong>💾 Session storage:</strong> Lưu data vào session</li>
    </ul>
</div>