<h2>🏠 Trang Chủ - GetForm</h2>

<div class="result">
    <h3>🎯 Giới thiệu Bài 7.4</h3>
    <p><strong>Mục tiêu:</strong> Lấy dữ liệu từ các loại form input khác nhau</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">
    <div style="background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 25px; border-radius: 10px;">
        <h4>📝 Register Form</h4>
        <p>Form đăng ký với đầy đủ các loại input:</p>
        <ul>
            <li>Textbox & Textarea</li>
            <li>Password field</li>
            <li>Radio buttons</li>
            <li>Checkbox & Checkbox list</li>
            <li>Select dropdown</li>
        </ul>
        <a href="index.php?page=register" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;">Xem Form</a>
    </div>

    <div style="background: linear-gradient(135deg, #2ecc71, #27ae60); color: white; padding: 25px; border-radius: 10px;">
        <h4>📞 Contact Form</h4>
        <p>Form liên hệ xử lý trên cùng trang:</p>
        <ul>
            <li>Xử lý POST trên cùng page</li>
            <li>Ẩn form sau khi submit</li>
            <li>Hiển thị kết quả ngay lập tức</li>
            <li>Real-time validation</li>
        </ul>
        <a href="index.php?page=contact1Page" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;">Xem Form</a>
    </div>

    <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 25px; border-radius: 10px;">
        <h4>🎨 Form Demo</h4>
        <p>Demo tất cả loại input trong 1 form:</p>
        <ul>
            <li>Tất cả input types</li>
            <li>HTML5 validation</li>
            <li>JavaScript enhancement</li>
            <li>Responsive design</li>
        </ul>
        <a href="index.php?page=formDemo" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid white;">Xem Demo</a>
    </div>
</div>

<div class="result" style="margin-top: 30px;">
    <h3>🔧 Các Loại Input Được Hỗ Trợ</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 2em;">📝</div>
            <strong>Text/Textarea</strong>
        </div>
        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 2em;">🔒</div>
            <strong>Password</strong>
        </div>
        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 2em;">☑️</div>
            <strong>Checkbox</strong>
        </div>
        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 2em;">🔘</div>
            <strong>Radio</strong>
        </div>
        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 2em;">📋</div>
            <strong>Select</strong>
        </div>
    </div>
</div>

<!-- Hiển thị session data nếu có -->
<?php if (!empty($_SESSION)): ?>
<div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin-top: 20px;">
    <h4>💾 Session Data Hiện Tại:</h4>
    <pre><?php print_r($_SESSION); ?></pre>
</div>
<?php endif; ?>