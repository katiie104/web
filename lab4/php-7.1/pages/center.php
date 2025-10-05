<div class="center">
    <?php
    // Lấy tham số "page" từ URL, mặc định là home
    $page = $_GET['page'] ?? 'home';

    // Mảng ánh xạ: key (tham số) => value (file PHP)
    $tasks = [
        'task7_1' => 'tasks/task7_1.php',
        'task7_2' => 'tasks/task7_2.php',
        'task7_3' => 'tasks/task7_3.php',
        'task7_4' => 'tasks/task7_4.php',
        'task7_5' => 'tasks/task7_5.php',
        'task7_6' => 'tasks/task7_6.php',
        // thêm tiếp nếu có nhiều bài khác
    ];

    if (array_key_exists($page, $tasks)) {
        if (file_exists($tasks[$page])) {
            include $tasks[$page];
        } else {
            echo "<p style='color:red;'>⚠️ File không tồn tại: {$tasks[$page]}</p>";
        }
    } else {
        // Nội dung mặc định giống hình bạn gửi
        echo '
        <div class="welcome">
            <h2>Chào!</h2>
            <div class="card">
                <h3>Tớ hiện đang là sinh viên của Học viện Kỹ thuật Mật mã</h3>
                <div class="profile">
                    <img src="/29_TRANHONGKHANG/conan.webp" alt="Logo Khang">
                    <ul>
                        <li><strong>Tên:</strong> Trần Hồng Khang</li>
                        <li><strong>Ngày sinh:</strong> 01/04/2004</li>
                        <li><strong>Quê quán:</strong> Hà Nam</li>
                        <li><strong>Đang học lớp:</strong> 19C</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <p>☻ Mình là 1 bạn trẻ đam mê IT và hăng say với những project website của riêng mình (mặc dù chưa biết nhiều về HTML, PHP, CSS,...) !!</p>
                <p>☻ Đặc điểm nhận dạng:  hihihaha.</p>
            </div>
        </div>';
    }
    ?>
</div>
