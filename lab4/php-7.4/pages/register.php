<h2>📝 Form Đăng Ký</h2>
<p class="form-description">Form này sẽ gửi dữ liệu đến trang registerProcess.php</p>

<form name="form1" action="index.php?page=registerProcess" method="post">
    <table>
        <tr>
            <td colspan="2">
                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #3498db, #2980b9); color: white; border-radius: 10px;">
                    <h3>📋 Form Đăng Ký Thành Viên</h3>
                </div>
            </td>
        </tr>
        
        <!-- Textbox - Username -->
        <tr>
            <td width="30%"><strong>👤 Username:</strong></td>
            <td>
                <input type="text" name="txtUsername" id="txtUsername" 
                       placeholder="Nhập username..." required
                       value="<?= isset($_POST['txtUsername']) ? htmlspecialchars($_POST['txtUsername']) : '' ?>">
            </td>
        </tr>
        
        <!-- Password -->
        <tr>
            <td><strong>🔒 Password:</strong></td>
            <td>
                <input type="password" name="txtPassword" id="txtPassword" 
                       placeholder="Nhập password..." required>
            </td>
        </tr>
        
        <!-- Radio Button List - Gender -->
        <tr>
            <td><strong>⚤ Gender:</strong></td>
            <td>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="radGender" value="Male" checked> 
                        👨 Male
                    </label>
                    <label>
                        <input type="radio" name="radGender" value="Female"> 
                        👩 Female
                    </label>
                    <label>
                        <input type="radio" name="radGender" value="Other"> 
                        🧑 Other
                    </label>
                </div>
            </td>
        </tr>
        
        <!-- Select List - Address -->
        <tr>
            <td><strong>🏠 Address:</strong></td>
            <td>
                <select name="lstAddress" required>
                    <option value="">-- Chọn địa chỉ --</option>
                    <option value="Ha Noi">Hà Nội</option>
                    <option value="TP.HCM">TP. Hồ Chí Minh</option>
                    <option value="Hue">Huế</option>
                    <option value="Da Nang">Đà Nẵng</option>
                    <option value="Hai Phong">Hải Phòng</option>
                    <option value="Other">Khác</option>
                </select>
            </td>
        </tr>
        
        <!-- Checkbox List - Programming Languages -->
        <tr>
            <td><strong>💻 Enable Programming Language:</strong></td>
            <td>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" name="chkLang[]" value="PHP"> 
                        <span style="color: #7474ae;">🐘 PHP</span>
                    </label>
                    <label>
                        <input type="checkbox" name="chkLang[]" value="C#"> 
                        <span style="color: #68217a;">🔷 C#</span>
                    </label>
                    <label>
                        <input type="checkbox" name="chkLang[]" value="C++"> 
                        <span style="color: #00549d;">🔶 C++</span>
                    </label>
                    <label>
                        <input type="checkbox" name="chkLang[]" value="Java"> 
                        <span style="color: #e76f00;">☕ Java</span>
                    </label>
                    <label>
                        <input type="checkbox" name="chkLang[]" value="Python"> 
                        <span style="color: #3776ab;">🐍 Python</span>
                    </label>
                    <label>
                        <input type="checkbox" name="chkLang[]" value="JavaScript"> 
                        <span style="color: #f7df1e;">🟨 JavaScript</span>
                    </label>
                </div>
            </td>
        </tr>
        
        <!-- Radio Button List - Skill -->
        <tr>
            <td><strong>🎯 Skill:</strong></td>
            <td>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="radSkill" value="Beginner"> 
                        🟢 Beginner
                    </label>
                    <label>
                        <input type="radio" name="radSkill" value="Intermediate"> 
                        🟡 Intermediate
                    </label>
                    <label>
                        <input type="radio" name="radSkill" value="Advanced"> 
                        🟠 Advanced
                    </label>
                    <label>
                        <input type="radio" name="radSkill" value="Expert" checked> 
                        🔴 Expert
                    </label>
                </div>
            </td>
        </tr>
        
        <!-- Textarea - Note -->
        <tr>
            <td><strong>📝 Note:</strong></td>
            <td>
                <textarea name="taNote" id="taNote" rows="4" 
                          placeholder="Nhập ghi chú của bạn..."><?= isset($_POST['taNote']) ? htmlspecialchars($_POST['taNote']) : '' ?></textarea>
            </td>
        </tr>
        
        <!-- Checkbox - Marriage Status -->
        <tr>
            <td><strong>💑 Marriage Status:</strong></td>
            <td>
                <label style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="chkMarriageStatus" value="Da ket hon">
                    <span>Đã kết hôn</span>
                </label>
            </td>
        </tr>
        
        <!-- Submit Buttons -->
        <tr>
            <td></td>
            <td style="padding-top: 20px;">
                <button type="submit" name="btnRegister" class="btn">✅ Register</button>
                <button type="reset" class="btn btn-reset">🔄 Reset</button>
                <a href="index.php?page=home" class="btn">🏠 Home</a>
            </td>
        </tr>
    </table>
</form>

<div class="result" style="margin-top: 30px;">
    <h3>🔍 Hướng Dẫn Sử Dụng</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
        <div>
            <h4>📤 Gửi đến trang khác</h4>
            <p>Form này sử dụng <code>action="registerProcess.php"</code> để gửi dữ liệu sang trang xử lý riêng.</p>
        </div>
        <div>
            <h4>🎯 Các loại input</h4>
            <ul>
                <li>Textbox & Password</li>
                <li>Radio buttons (đơn lựa chọn)</li>
                <li>Checkbox list (nhiều lựa chọn)</li>
                <li>Select dropdown</li>
                <li>Textarea</li>
            </ul>
        </div>
        <div>
            <h4>📊 Data handling</h4>
            <ul>
                <li>Checkbox list: <code>name="chkLang[]"</code></li>
                <li>Radio group: cùng <code>name="radGender"</code></li>
                <li>Single checkbox: giá trị boolean</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Real-time validation
document.getElementById('txtUsername').addEventListener('input', function() {
    if (this.value.length < 3) {
        this.style.borderColor = '#e74c3c';
    } else {
        this.style.borderColor = '#2ecc71';
    }
});

// Password strength indicator
document.getElementById('txtPassword').addEventListener('input', function() {
    const strength = document.getElementById('passwordStrength');
    if (!strength) {
        const strengthDiv = document.createElement('div');
        strengthDiv.id = 'passwordStrength';
        strengthDiv.style.marginTop = '5px';
        strengthDiv.style.fontSize = '0.9em';
        this.parentNode.appendChild(strengthDiv);
    }
    
    const password = this.value;
    let strengthText = '';
    let color = '#e74c3c';
    
    if (password.length === 0) {
        strengthText = '';
    } else if (password.length < 6) {
        strengthText = '🔴 Weak';
    } else if (password.length < 10) {
        strengthText = '🟡 Medium';
        color = '#f39c12';
    } else {
        strengthText = '🟢 Strong';
        color = '#2ecc71';
    }
    
    document.getElementById('passwordStrength').innerHTML = strengthText;
    document.getElementById('passwordStrength').style.color = color;
});

// Auto-save form data to session storage
document.querySelectorAll('input, select, textarea').forEach(element => {
    element.addEventListener('input', function() {
        sessionStorage.setItem(this.name, this.value);
    });
    
    // Load saved data
    if (sessionStorage.getItem(element.name)) {
        element.value = sessionStorage.getItem(element.name);
    }
});
</script>