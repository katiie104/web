<h2>🏠 Trang Quản Trị</h2>

<div style="background: #e8f6f3; padding: 20px; border-radius: 10px; margin: 20px 0;">
    <h3>✅ Đã Đăng Nhập Thành Công!</h3>
    <p>Bạn đang truy cập khu vực quản trị được bảo vệ bởi session.</p>
</div>

<!-- Thông tin session chi tiết -->
<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
    <h3>🔍 Chi Tiết Session</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 15px;">
        <div style="padding: 15px; background: white; border-radius: 5px;">
            <strong>🆔 Session ID:</strong><br>
            <code><?= session_id() ?></code>
        </div>
        <div style="padding: 15px; background: white; border-radius: 5px;">
            <strong>👤 User:</strong><br>
            <?= htmlspecialchars($_SESSION['username']) ?>
        </div>
        <div style="padding: 15px; background: white; border-radius: 5px;">
            <strong>🕒 Login Time:</strong><br>
            <?= $_SESSION['login_time'] ?>
        </div>
        <div style="padding: 15px; background: white; border-radius: 5px;">
            <strong>🌐 IP Address:</strong><br>
            <?= $_SESSION['ip_address'] ?>
        </div>
    </div>
</div>

<!-- Các chức năng quản trị -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">
    <div style="background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 25px; border-radius: 10px; text-align: center;">
        <div style="font-size: 3em;">📁</div>
        <h3>Upload Files</h3>
        <p>Quản lý file upload trong khu vực bảo mật</p>
        <a href="index.php?page=upload" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;">Truy Cập</a>
    </div>
    
    <div style="background: linear-gradient(135deg, #2ecc71, #27ae60); color: white; padding: 25px; border-radius: 10px; text-align: center;">
        <div style="font-size: 3em;">👥</div>
        <h3>User Management</h3>
        <p>Quản lý người dùng hệ thống (coming soon)</p>
        <button class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;" disabled>Sắp Ra Mắt</button>
    </div>
    
    <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 25px; border-radius: 10px; text-align: center;">
        <div style="font-size: 3em;">📊</div>
        <h3>Statistics</h3>
        <p>Thống kê truy cập hệ thống</p>
        <button class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;" disabled>Sắp Ra Mắt</button>
    </div>
    
    <div style="background: linear-gradient(135deg, #9b59b6, #8e44ad); color: white; padding: 25px; border-radius: 10px; text-align: center;">
        <div style="font-size: 3em;">⚙️</div>
        <h3>Settings</h3>
        <p>Cài đặt hệ thống quản trị</p>
        <button class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;" disabled>Sắp Ra Mắt</button>
    </div>
</div>

<!-- Demo session operations -->
<div style="background: #2c3e50; color: white; padding: 25px; border-radius: 10px; margin: 20px 0;">
    <h3>🔧 Session Operations</h3>
    <div style="display: flex; gap: 15px; margin-top: 15px; flex-wrap: wrap;">
        <button onclick="showSessionData()" class="btn">📊 Xem Session Data</button>
        <button onclick="checkSessionStatus()" class="btn">🔍 Kiểm Tra Session</button>
        <button onclick="refreshSession()" class="btn">🔄 Refresh Session</button>
    </div>
    
    <div id="sessionResult" style="margin-top: 15px; padding: 15px; background: #34495e; border-radius: 5px; display: none;"></div>
</div>


<!-- Logout-->
<div style="text-align: center; margin-top: 20px;">
    <a href="../pages/logout.php" class="btn btn-logout">🚪 Đăng Xuất</a>
    <a href="index.php?page=upload" class="btn">📁 Upload Files</a>
</div>

<!-- Session data display -->
<div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
    <h3>💾 Toàn Bộ Session Data</h3>
    <pre style="background: #2c3e50; color: white; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 0.9em;"><?php print_r($_SESSION); ?></pre>
</div>

<script>
function showSessionData() {
    const resultDiv = document.getElementById('sessionResult');
    resultDiv.innerHTML = `
        <h4>📋 Session Information:</h4>
        <p><strong>Session ID:</strong> <?= session_id() ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
        <p><strong>Login Time:</strong> <?= $_SESSION['login_time'] ?></p>
        <p><strong>Session Lifetime:</strong> ${Math.floor((Date.now() - new Date('<?= $_SESSION['login_time'] ?>').getTime()) / 1000)} seconds</p>
    `;
    resultDiv.style.display = 'block';
}

function checkSessionStatus() {
    fetch('../check_session.php')
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('sessionResult');
            resultDiv.innerHTML = `
                <h4>🔍 Session Status:</h4>
                <p><strong>Status:</strong> <span style="color: #27ae60;">${data.status}</span></p>
                <p><strong>User:</strong> ${data.username}</p>
                <p><strong>Active Time:</strong> ${data.active_time} seconds</p>
            `;
            resultDiv.style.display = 'block';
        });
}

function refreshSession() {
    fetch('../refresh_session.php')
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('sessionResult');
            resultDiv.innerHTML = `
                <h4>🔄 Session Refreshed:</h4>
                <p><strong>Message:</strong> <span style="color: #27ae60;">${data.message}</span></p>
                <p><strong>New Lifetime:</strong> ${data.new_lifetime} seconds</p>
            `;
            resultDiv.style.display = 'block';
        });
}
</script>