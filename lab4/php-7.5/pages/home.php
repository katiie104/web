<h2>🏠 Trang Chủ - End User</h2>

<div class="session-info">
    <h4>🔍 Thông Tin Session Hiện Tại:</h4>
    <?php if (isset($_SESSION['username'])): ?>
        <p><strong>👤 Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
        <p><strong>🔑 Password:</strong> <?= str_repeat('*', strlen($_SESSION['password'] ?? '')) ?></p>
        <p><strong>🕒 Login Time:</strong> <?= $_SESSION['login_time'] ?? 'Chưa đăng nhập' ?></p>
        <p><strong>💚 Status:</strong> <span style="color: #27ae60;">Đã đăng nhập</span></p>
        
        <div style="margin-top: 15px;">
            <a href="admin/index.php" class="btn">⚙️ Truy Cập Admin Panel</a>
            <a href="admin/logout.php" class="btn">🚪 Đăng Xuất</a>
        </div>
    <?php else: ?>
        <p><strong>💚 Status:</strong> <span style="color: #e74c3c;">Chưa đăng nhập</span></p>
        <p>Vui lòng đăng nhập để truy cập khu vực quản trị.</p>
        
        <div style="margin-top: 15px;">
            <a href="index.php?page=login" class="btn">🔐 Đăng Nhập Ngay</a>
        </div>
    <?php endif; ?>
</div>

<div style="background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 25px; border-radius: 10px; margin-top: 20px;">
    <h3>🎯 Giới Thiệu Bài 7.5 - Session</h3>
    <p><strong>Mục tiêu:</strong> Quản lý phiên đăng nhập và bảo mật ứng dụng web</p>
    
    <h4>🔐 Tính Năng Chính:</h4>
    <ul style="margin-left: 20px;">
        <li>Xác thực đăng nhập với session</li>
        <li>Bảo vệ khu vực quản trị</li>
        <li>Quản lý trạng thái người dùng</li>
        <li>Upload file trong khu vực bảo mật</li>
        <li>Xử lý đăng xuất an toàn</li>
    </ul>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px;">
    <div style="text-align: center; padding: 20px; background: #e8f6f3; border-radius: 10px;">
        <div style="font-size: 3em;">🔐</div>
        <h4>Authentication</h4>
        <p>Xác thực người dùng</p>
    </div>
    <div style="text-align: center; padding: 20px; background: #fce4ec; border-radius: 10px;">
        <div style="font-size: 3em;">⚡</div>
        <h4>Session</h4>
        <p>Quản lý phiên làm việc</p>
    </div>
    <div style="text-align: center; padding: 20px; background: #e3f2fd; border-radius: 10px;">
        <div style="font-size: 3em;">🛡️</div>
        <h4>Security</h4>
        <p>Bảo mật ứng dụng</p>
    </div>
    <div style="text-align: center; padding: 20px; background: #f3e5f5; border-radius: 10px;">
        <div style="font-size: 3em;">📁</div>
        <h4>Upload</h4>
        <p>Quản lý file upload</p>
    </div>
</div>

<!-- Hiển thị toàn bộ session data (debug) -->
<?php if (!empty($_SESSION)): ?>
<div style="background: #2c3e50; color: white; padding: 20px; border-radius: 10px; margin-top: 25px;">
    <h4>🔧 Session Data (Debug):</h4>
    <pre style="overflow-x: auto; font-size: 0.9em;"><?php print_r($_SESSION); ?></pre>
</div>
<?php endif; ?>