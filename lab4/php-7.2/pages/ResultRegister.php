 <div class="center">
    <h2>Kết quả đăng ký:</h2>
    <?php
    if(isset($_POST['txtTen'])) {
        $ten = $_POST['txtTen'];
        $diachi = $_POST['txtDiaChi'];
        $nghe = $_POST['lstNghe'];
        $ghichu = $_POST['taGhiChu'];
        
        echo "<p><strong>Tên:</strong> $ten</p>";
        echo "<p><strong>Địa chỉ:</strong> $diachi</p>";
        echo "<p><strong>Nghề:</strong> $nghe</p>";
        echo "<p><strong>Ghi chú:</strong> $ghichu</p>";
    } else {
        echo "<p>Không có dữ liệu đăng ký!</p>";
    }
    ?>
</div>