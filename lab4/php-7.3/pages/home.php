<h2>🏠 Trang Home</h2>
<p>Mọi page được chạy trên nền trang Index.php</p>

<div class="result">
    <h3>📋 Giới thiệu Bài 7.3</h3>
    <p><strong>Mục tiêu:</strong> Lấy và gửi dữ liệu giữa client và server</p>
    
    <h4>🎯 Các chức năng chính:</h4>
    <ul>
        <li><strong>DrawTable:</strong> Vẽ bảng động với số dòng/cột</li>
        <li><strong>Loop:</strong> Hiển thị vòng lặp PHP</li>
        <li><strong>Calculate1:</strong> Tính toán cơ bản (+, -, *, /)</li>
        <li><strong>Calculate2:</strong> Form tính điểm sinh viên</li>
        <li><strong>Array1:</strong> Thao tác với mảng 2 chiều</li>
        <li><strong>UploadForm:</strong> Upload nhiều file</li>
    </ul>

    <h4>🔧 Kỹ thuật sử dụng:</h4>
    <ul>
        <li>PHP GET/POST methods</li>
        <li>Xử lý form data</li>
        <li>Upload file với $_FILES</li>
        <li>Switch-case routing</li>
        <li>Xử lý mảng PHP</li>
    </ul>
</div>

<!-- Hiển thị thông tin GET parameters (nếu có) -->
<?php if (!empty($_GET)): ?>
<div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin-top: 20px;">
    <h4>📊 Thông tin GET parameters:</h4>
    <pre><?php print_r($_GET); ?></pre>
</div>
<?php endif; ?>