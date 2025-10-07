<?php

?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Tran Hong Khang - Information</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Thêm một số style cơ bản cho iframe */
    .iframe-container {
      width: 160%;
      height: 900px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-top: 20px;
      margin-left: 50px;
    }

    iframe {
      width: 80%;
      height: 80%;
      border: none;
    }
  </style>
</head>

<body>
  <header>
    <div>
      <h1>Tran Hong Khang <span>Information</span></h1>
    </div>
    <nav>
      <a href="index.php">TRANG CHỦ</a>
      <a href="#">GIỚI THIỆU</a>
      <a href="#">CÔNG VIỆC</a>
      <a href="https://www.facebook.com/katiieeei">MẠNG XÃ HỘI</a>
      <a href="#">LIÊN HỆ</a>
    </nav>
  </header>

  <div class="container">
    <aside class="sidebar">
      <h3>List bai tap</h3>
      <ol>
        <li>Lab2
          <ol>
            <li><a href="index.php">Bài 1 - Giới thiệu bản thân </a></li>
            <li><a href="#" onclick="loadContent('/lab2/bai2.html')">Bài 2 - Bảng điểm học tập </a></li>
            <li><a href="#" onclick="loadContent('/lab2/bai3.html')">Bài 3 - CV xin việc</a></li>
            <li><a href="#" onclick="loadContent('/lab2/bai4.html')">Bài 4 - Website liên hiệp hội</a></li>
          </ol>
        </li>
        
        <li>
          Lab3
          <ol>
            <li><a href="#" onclick="loadContent('/lab3/7-2.html')">7.2 - Kiểm tra trắc nghiệm </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-3.html')">7.3 - Form nhập cho table LOP </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-4.html')">7.4 - Form nhập table HOSO </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-5.html')">7.5 - Form nhập đăng ký </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-6.html')">7.6 - Danh sách </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-7.html')">7.7 - Thực đơn </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-8.html')">7.8 - Tab </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-9.html')">7.9 - Cây </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-10.html')">7.10 - Máy tính </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-11.html')">7.11 - Hoạt cảnh </a></li>
            <li><a href="#" onclick="loadContent('/lab3/7-12.html')">7.12 - Sắp xếp và tìm kiếm trên bảng </a></li>
            
          </ol>
        </li>
        
        <li>
          Lab4
          <ol>
            <li><a href="#" onclick="loadContent('/lab4/php-7.1/index.php')">7.1 - Lấy template </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.2/index.php')">7.2 - Sử dụng template </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.3/index.php')">7.3 - Lấy & Gửi dữ liệu </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.4/index.php')">7.4 - GetForm </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.5/index.php')">7.5 - Session </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.5/index.php')">7.6 - Cookie </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.7/index.php')">7.7 - Function </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.8/index.php')">7.8 - Đọc, ghi file </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.9/index.php')">7.9 - Thao tác file và data flow </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.10/index.php')">7.10 - Website đa ngôn ngữ </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.11/index.php')">7.11 - Kết nối và truy vấn cơ sở dữ liệu cơ bản </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.12/index.php')">7.12 - Truy vấn dữ liệu</a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.13/index.php')">7.13 - Web bán laptop phần End user </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.14/index.php')">7.14 - Web bán laptop phần End administration </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.15/index.php')">7.15 - Xây dựng chức năng giỏ hàng cho Web bán máy laptop </a></li>
            <li><a href="#" onclick="loadContent('/lab4/php-7.16/index.php')">7.16 - Tích hợp richtext box trong Web bán laptop </a></li>
          </ol>
        </li>
      </ol>
    </aside>

    <section class="main">
      <div id="content-area">
        <h2>Chào!</h2>
        <div class="profile">
          <img src="/lab4/images/conan.webp" alt="Logo Khang">
          <div class="profile-info">
            <p><b>Tớ hiện đang là sinh viên của Học viện Kỹ thuật Mật mã</b></p>
            <p>• Tên: Trần Hồng Khang</p>
            <p>• Ngày sinh: 01/04/2004</p>
            <p>• Quê quán: Hà Nam </p>
            <p>• Đang học lớp: 19C</p>
          </div>
        </div>
        <div class="description">
          <p>☻ Mình là 1 bạn trẻ đam mê IT và hăng say với những project website của riêng mình (mặc dù chưa biết nhiều
            về HTML, PHP, CSS,...) !!</p>
          <p>☻ Đặc điểm nhận dạng: mát mát , hihihaha.</p>
        </div>
      </div>
      <div class="iframe-container" id="iframe-container" style="display: none;">
        <iframe id="content-frame" src=""></iframe>
      </div>
    </section>
  </div>

  <script>
    function loadContent(page) {
      const contentArea = document.getElementById('content-area');
      const iframeContainer = document.getElementById('iframe-container');
      const iframe = document.getElementById('content-frame');

      // Ẩn nội dung gốc và hiển thị iframe
      contentArea.style.display = 'none';
      iframeContainer.style.display = 'block';

      // Tải trang vào iframe
      iframe.src = page;

      return false;
    }
  </script>
</body>

</html>
