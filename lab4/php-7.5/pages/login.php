<h2>🔐 Đăng Nhập Hệ Thống</h2>

<?php
// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnLogin"])) {
    $username = $_POST["txtUsername"] ?? '';
    $password = $_POST["txtPassword"] ?? '';
    
    if ($username === "admin" && $password === "admin") {
        $_SESSION['username'] = $username;                      //Lưu thông tin đăng nhập vào session
        $_SESSION['password'] = $password; 
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        
        $_SESSION['message'] = "✅ Đăng nhập thành công! Chuyển hướng đến trang quản trị...";
        $_SESSION['message_type'] = 'success';
        
        header('Location: /lab4/php-7.5/admin/index.php');
        exit;
    } else {
        $error_message = "❌ Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>
 
<?php if (isset($error_message)): ?>
    <div class="alert alert-error">
        <?= $error_message ?>
        <br><small><strong>💡 Gợi ý:</strong> Sử dụng username và password được dùng phổ biến nhất</small>
    </div>
<?php endif; ?>

<!-- Form đăng nhập -->
<form method="post" action="">
    <div class="form-group">
        <label for="txtUsername">👤 Username:</label>
        <input type="text" id="txtUsername" name="txtUsername" 
               value="<?= isset($_POST['txtUsername']) ? htmlspecialchars($_POST['txtUsername']) : 'admin' ?>" 
               placeholder="Nhập username..." required autofocus>
    </div>
    
    <div class="form-group">
        <label for="txtPassword">🔒 Password:</label>
        <input type="password" id="txtPassword" name="txtPassword" 
               value="admin" 
               placeholder="Nhập password..." required>
    </div>
    
    <div style="text-align: center; margin-top: 25px;">
        <button type="submit" name="btnLogin" class="btn">🔐 Đăng Nhập</button>
        <button type="reset" class="btn">🔄 Nhập Lại</button>
        <a href="index.php?page=home" class="btn">🏠 Về Trang Chủ</a>
    </div>
</form>

<div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin-top: 25px;">
    <h4>💡 Thông Tin Đăng Nhập Mẫu:</h4>

</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
    <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 2em;">🛡️</div>
        <strong>Bảo Mật</strong>
        <p>Session validation</p>
    </div>
    <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 2em;">⚡</div>
        <strong>Nhanh Chóng</strong>
        <p>Real-time authentication</p>
    </div>
    <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <div style="font-size: 2em;">🔐</div>
        <strong>An Toàn</strong>
        <p>Secure session management</p>
    </div>
</div>

<script>
// Password visibility toggle
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('txtPassword');
    const toggleButton = document.createElement('button');
    toggleButton.type = 'button';
    toggleButton.innerHTML = '👁️';
    toggleButton.style.position = 'absolute';
    toggleButton.style.right = '10px';
    toggleButton.style.top = '50%';
    toggleButton.style.transform = 'translateY(-50%)';
    toggleButton.style.background = 'none';
    toggleButton.style.border = 'none';
    toggleButton.style.cursor = 'pointer';
    toggleButton.style.fontSize = '1.2em';
    
    passwordInput.style.paddingRight = '40px';
    passwordInput.parentElement.style.position = 'relative';
    passwordInput.parentElement.appendChild(toggleButton);
    
    toggleButton.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '🔒';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '👁️';
        }
    });
});

// Auto-submit với Enter
document.getElementById('txtPassword').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.querySelector('button[name="btnLogin"]').click();
    }
});
</script>