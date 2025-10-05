<h2>📁 UploadForm - Upload Nhiều File</h2>

<?php
// Hiển thị thông báo nếu có
if (isset($_GET['upload_status'])) {
    $status = $_GET['upload_status'];
    if ($status == 'success') {
        echo '<div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0;">';
        echo '✅ Upload file thành công! <a href="index.php?page=uploadprocess">Xem danh sách file</a>';
        echo '</div>';
    } elseif ($status == 'error') {
        echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 15px 0;">';
        echo '❌ Lỗi khi upload file!';
        echo '</div>';
    }
}
?>

<div class="result">
    <h3>📋 Hướng dẫn Upload</h3>
    <ul>
        <li>Chọn tối đa 10 file để upload</li>
        <li>Kích thước mỗi file tối đa: 2MB</li>
        <li>Định dạng cho phép: JPG, PNG, GIF, PDF, TXT</li>
        <li>File sẽ được lưu trong thư mục <code>uploads/</code></li>
    </ul>
</div>

<!-- Form upload nhiều file -->
<form method="post" action="index.php?page=uploadprocess" enctype="multipart/form-data" id="uploadForm">
    <table style="width: 80%;">
        <tr>
            <td colspan="2">
                <h3>📤 Upload 10 File (Sử dụng mảng kết hợp)</h3>
            </td>
        </tr>
        
        <?php for ($i = 1; $i <= 10; $i++): ?>
        <tr>
            <td width="20%"><strong>File <?= $i ?>:</strong></td>
            <td>
                <input type="file" name="files[]" class="file-input" 
                       accept=".jpg,.jpeg,.png,.gif,.pdf,.txt" 
                       style="padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
                <span class="file-size" style="margin-left: 10px; color: #666; font-size: 0.9em;"></span>
            </td>
        </tr>
        <?php endfor; ?>
        
        <tr>
            <td></td>
            <td style="padding-top: 20px;">
                <button type="submit" name="submit" class="btn">🚀 Upload Files</button>
                <button type="reset" class="btn">🔄 Reset</button>
                <a href="index.php?page=uploadprocess" class="btn">📋 Xem File Đã Upload</a>
            </td>
        </tr>
    </table>
</form>

<!-- Thông tin kỹ thuật -->
<div class="result" style="margin-top: 30px;">
    <h3>🔧 Kỹ Thuật Sử Dụng</h3>
    <ul>
        <li><strong>Multipart Form:</strong> enctype="multipart/form-data"</li>
        <li><strong>Array Input:</strong> name="files[]" (mảng files)</li>
        <li><strong>Super Global:</strong> $_FILES để xử lý file upload</li>
        <li><strong>File Validation:</strong> Kiểm tra type, size trước khi upload</li>
        <li><strong>Security:</strong> move_uploaded_file() để đảm bảo an toàn</li>
    </ul>
</div>

<script>
// Hiển thị thông tin file khi chọn
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('.file-input');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const sizeSpan = this.nextElementSibling;
            if (this.files.length > 0) {
                const file = this.files[0];
                const size = (file.size / 1024 / 1024).toFixed(2); // MB
                sizeSpan.textContent = `Size: ${size} MB`;
                
                // Cảnh báo nếu file quá lớn
                if (file.size > 2 * 1024 * 1024) {
                    sizeSpan.style.color = '#e74c3c';
                    sizeSpan.innerHTML += ' ⚠️ File quá lớn!';
                } else {
                    sizeSpan.style.color = '#27ae60';
                }
            } else {
                sizeSpan.textContent = '';
            }
        });
    });
    
    // Validate form trước khi submit
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const fileInputs = document.querySelectorAll('.file-input');
        let hasFile = false;
        
        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                hasFile = true;
                // Kiểm tra kích thước file
                if (input.files[0].size > 2 * 1024 * 1024) {
                    alert('⚠️ File "' + input.files[0].name + '" vượt quá 2MB!');
                    e.preventDefault();
                    return;
                }
            }
        });
        
        if (!hasFile) {
            alert('⚠️ Vui lòng chọn ít nhất 1 file để upload!');
            e.preventDefault();
        }
    });
});
</script>