 <div class="center">
    <h2>Form Đăng Ký</h2>
    <form method="post" action="index.php?page=resultregister">
        <table>
            <tr>
                <td>Tên:</td>
                <td><input type="text" name="txtTen" required></td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td><input type="text" name="txtDiaChi" required></td>
            </tr>
            <tr>
                <td>Nghề:</td>
                <td>
                    <select name="lstNghe">
                        <option value="Quản lý">Quản lý</option>
                        <option value="Lập trình viên">Lập trình viên</option>
                        <option value="Kỹ sư">Kỹ sư</option>
                        <option value="Giáo viên">Giáo viên</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ghi chú:</td>
                <td><textarea name="taGhiChu" rows="3" cols="30"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="reset" value="Xóa">
                    <input type="submit" value="Đăng Ký">
                </td>
            </tr>
        </table>
    </form>
</div>