<h2>📊 Kết Quả Đăng Ký</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnRegister"])) {
    
    // Lưu data vào session để demo
    $_SESSION['form_data'] = $_POST;
    
    // Lấy data từ client
    echo '<div class="result">';
    echo '<h3>✅ Đăng Ký Thành Công!</h3>';
    echo '<p>Dữ liệu đã được gửi từ trang Register.php</p>';
    echo '</div>';
    
    // Hiển thị dữ liệu đã nhận
    echo '<table>';
    echo '<tr><td colspan="2" style="text-align: center; background: #3498db; color: white;"><strong>📋 THÔNG TIN ĐÃ ĐĂNG KÝ</strong></td></tr>';
    
    // Textbox và TextArea
    $name = htmlspecialchars($_POST["txtUsername"] ?? '');
    $pass = str_repeat('*', strlen($_POST["txtPassword"] ?? ''));
    $note = htmlspecialchars($_POST["taNote"] ?? '');
    
    echo '<tr><td width="30%"><strong>👤 Username:</strong></td><td>' . $name . '</td></tr>';
    echo '<tr><td><strong>🔒 Password:</strong></td><td>' . $pass . '</td></tr>';
    
    // RadioButton List (Gender)
    $gender = htmlspecialchars($_POST["radGender"] ?? '');
    echo '<tr><td><strong>⚤ Gender:</strong></td><td>' . $gender . '</td></tr>';
    
    // Select List (Address)
    $address = htmlspecialchars($_POST["lstAddress"] ?? '');
    echo '<tr><td><strong>🏠 Address:</strong></td><td>' . $address . '</td></tr>';
    
    // Checkbox List (Programming Languages)
    $lang = '';
    if (isset($_POST["chkLang"]) && is_array($_POST["chkLang"])) {
        $lang = implode(', ', array_map('htmlspecialchars', $_POST["chkLang"]));
    }
    echo '<tr><td><strong>💻 Programming Languages:</strong></td><td>' . ($lang ?: 'Không chọn') . '</td></tr>';
    
    // RadioButton List (Skill)
    $skill = htmlspecialchars($_POST["radSkill"] ?? '');
    echo '<tr><td><strong>🎯 Skill Level:</strong></td><td>' . $skill . '</td></tr>';
    
    // TextArea (Note)
    echo '<tr><td><strong>📝 Note:</strong></td><td>' . ($note ?: 'Không có ghi chú') . '</td></tr>';
    
    // Checkbox (Marriage Status)
    $marriageStatus = (isset($_POST["chkMarriageStatus"]) && $_POST["chkMarriageStatus"] == 'Da ket hon') 
                    ? 'Đã kết hôn' 
                    : 'Độc thân';
    echo '<tr><td><strong>💑 Marriage Status:</strong></td><td>' . $marriageStatus . '</td></tr>';
    
    echo '</table>';
    
    // Hiển thị raw POST data để debug
    echo '<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px;">';
    echo '<h4>🔧 Raw POST Data (Debug):</h4>';
    echo '<pre style="background: #2c3e50; color: white; padding: 15px; border-radius: 5px; overflow-x: auto;">';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
    echo '</div>';
    
} else {
    echo '<div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 10px;">';
    echo '<h3>❌ Lỗi: Không có dữ liệu đăng ký!</h3>';
    echo '<p>Vui lòng quay lại trang <a href="index.php?page=register">Register</a> để điền thông tin.</p>';
    echo '</div>';
}
?>

<div style="margin-top: 30px; text-align: center;">
    <a href="index.php?page=register" class="btn">📝 Quay lại Form Đăng Ký</a>
    <a href="index.php?page=home" class="btn">🏠 Về Trang Chủ</a>
    <a href="index.php?page=contact1Page" class="btn">📞 Đến Contact Form</a>
</div>

<!-- Hiển thị session data -->
<?php if (!empty($_SESSION['form_data'])): ?>
<div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin-top: 30px;">
    <h4>💾 Session Data (Lưu trữ):</h4>
    <pre><?php print_r($_SESSION['form_data']); ?></pre>
</div>
<?php endif; ?>

<div class="result" style="margin-top: 30px;">
    <h3>🎯 Kỹ Thuật Sử Dụng</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <div>
            <h4>📤 Nhận dữ liệu</h4>
            <p>Sử dụng <code>$_POST</code> để nhận data từ form</p>
        </div>
        <div>
            <h4>🛡️ Bảo mật</h4>
            <p><code>htmlspecialchars()</code> để chống XSS</p>
        </div>
        <div>
            <h4>📊 Xử lý mảng</h4>
            <p>Checkbox list: <code>$_POST["chkLang"]</code> là mảng</p>
        </div>
        <div>
            <h4>💾 Lưu session</h4>
            <p>Dữ liệu được lưu vào <code>$_SESSION</code></p>
        </div>
    </div>
</div>