<?php
session_start();

// Xử lý form theme preference
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_theme'])) {
    $theme = $_POST['theme'];
    
    setcookie("user_theme", $theme, time() + (30 * 24 * 60 * 60), "/");
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý form language preference
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_language'])) {
    $language = $_POST['language'];
    setcookie("user_language", $language, time() + (30 * 24 * 60 * 60), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý remember me
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    
    if (isset($_POST['remember_me'])) {
        // Remember for 7 days
        setcookie("remembered_user", $username, time() + (7 * 24 * 60 * 60), "/");
    }
    
    $_SESSION['username'] = $username;
}

// Xử lý clear cookies
if (isset($_GET['clear_cookies'])) {
    setcookie("user_theme", "", time() - 3600, "/");
    setcookie("user_language", "", time() - 3600, "/");
    setcookie("remembered_user", "", time() - 3600, "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Get current preferences
$current_theme = $_COOKIE['user_theme'] ?? 'light';
$current_language = $_COOKIE['user_language'] ?? 'vi';
$remembered_user = $_COOKIE['remembered_user'] ?? '';

// Apply theme
$theme_class = $current_theme === 'dark' ? 'dark-theme' : 'light-theme';
?>

<!DOCTYPE html>
<html lang="<?= $current_language ?>">
<head>
    <meta charset="UTF-8">
    <title>🍪 Bài 7.7 - Cookie Management</title>
    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #333333;
            --card-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        .dark-theme {
            --bg-color: #1a1a1a;
            --text-color: #ffffff;
            --card-bg: #2d3748;
            --border-color: #4a5568;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .card {
            background: var(--card-bg);
            padding: 2rem;
            margin: 1.5rem 0;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .preference-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .form-group {
            margin: 1rem 0;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        select, input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 2px solid var(--border-color);
            border-radius: 5px;
            background: var(--bg-color);
            color: var(--text-color);
            font-size: 1rem;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            margin: 5px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .cookie-info {
            background: #fff3cd;
            color: #856404;
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
            border-left: 4px solid #ffc107;
        }

        .dark-theme .cookie-info {
            background: #664d03;
            color: #ffecb5;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            text-align: center;
            border-radius: 8px;
            border: 2px solid var(--border-color);
        }

        .theme-preview {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-block;
            margin: 0 10px;
            cursor: pointer;
            border: 3px solid transparent;
        }

        .theme-preview.active {
            border-color: #007bff;
        }

        .light-preview {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #dee2e6;
        }

        .dark-preview {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }
    </style>
</head>
<body class="<?= $theme_class ?>">
    <div class="container">
        <div class="header">
            <h1>🍪 Bài 7.7 - Cookie Management</h1>
            <p>Quản lý Cookie trong PHP - Personalization & Preferences</p>
        </div>

        <!-- Navigation -->
        <div class="card" style="text-align: center;">
            <a href="../index.php" class="btn btn-success">🏠 Trang chủ</a>
            <a href="../admin/authorization.php" class="btn btn-primary">🔐 Bài 7.6 - Authorization</a>
            <a href="../pages/login.php" class="btn">🔑 Bài 7.5 - Login</a>
        </div>

        <!-- User Info -->
        <div class="card">
            <h2>👤 Thông tin người dùng</h2>
            <?php if (isset($_SESSION['username'])): ?>
                <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                <p><strong>Theme:</strong> <?= ucfirst($current_theme) ?></p>
                <p><strong>Language:</strong> <?= strtoupper($current_language) ?></p>
            <?php else: ?>
                <p>Chưa đăng nhập</p>
            <?php endif; ?>
        </div>

        <div class="preference-grid">
            <!-- Theme Preference -->
            <div class="card">
                <h3>🎨 Thiết lập Theme</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Chọn theme:</label>
                        <div style="text-align: center; margin: 1rem 0;">
                            <div class="theme-preview light-preview <?= $current_theme === 'light' ? 'active' : '' ?>" 
                                 onclick="document.querySelector('input[name=theme][value=light]').checked = true">
                            </div>
                            <div class="theme-preview dark-preview <?= $current_theme === 'dark' ? 'active' : '' ?>" 
                                 onclick="document.querySelector('input[name=theme][value=dark]').checked = true">
                            </div>
                        </div>
                        <div style="display: flex; gap: 2rem; justify-content: center;">
                            <label>
                                <input type="radio" name="theme" value="light" <?= $current_theme === 'light' ? 'checked' : '' ?>> 
                                Light Mode
                            </label>
                            <label>
                                <input type="radio" name="theme" value="dark" <?= $current_theme === 'dark' ? 'checked' : '' ?>> 
                                Dark Mode
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="set_theme" class="btn btn-primary">💾 Lưu Theme</button>
                </form>
            </div>

            <!-- Language Preference -->
            <div class="card">
                <h3>🌐 Thiết lập Ngôn ngữ</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Chọn ngôn ngữ:</label>
                        <select name="language">
                            <option value="vi" <?= $current_language === 'vi' ? 'selected' : '' ?>>🇻🇳 Tiếng Việt</option>
                            <option value="en" <?= $current_language === 'en' ? 'selected' : '' ?>>🇺🇸 English</option>
                            <option value="ja" <?= $current_language === 'ja' ? 'selected' : '' ?>>🇯🇵 日本語</option>
                        </select>
                    </div>
                    <button type="submit" name="set_language" class="btn btn-primary">💾 Lưu Ngôn ngữ</button>
                </form>
            </div>
        </div>

        <!-- Login with Remember Me -->
        <div class="card">
            <h3>🔐 Đăng nhập với Remember Me</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($remembered_user) ?>" 
                           placeholder="Nhập username...">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember_me"> 
                        Remember me for 7 days
                    </label>
                </div>
                <button type="submit" name="login" class="btn btn-success">🔐 Đăng nhập</button>
            </form>
        </div>

        <!-- Cookie Information -->
        <div class="card">
            <h3>📊 Thông tin Cookie</h3>
            <div class="cookie-info">
                <h4>🍪 Cookies hiện tại:</h4>
                <pre><?php 
                echo "Tổng số cookies: " . count($_COOKIE) . "\n";
                foreach($_COOKIE as $name => $value) {
                    echo "$name: $value\n";
                }
                ?></pre>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h4>Theme Cookie</h4>
                    <p><?= $current_theme ?: 'Not set' ?></p>
                </div>
                <div class="stat-card">
                    <h4>Language Cookie</h4>
                    <p><?= $current_language ?: 'Not set' ?></p>
                </div>
                <div class="stat-card">
                    <h4>Remember Me</h4>
                    <p><?= $remembered_user ?: 'Not set' ?></p>
                </div>
                <div class="stat-card">
                    <h4>Total Cookies</h4>
                    <p><?= count($_COOKIE) ?></p>
                </div>
            </div>

            <a href="?clear_cookies=1" class="btn btn-danger">🗑️ Xóa tất cả Cookies</a>
        </div>

        <!-- Cookie vs Session Comparison -->
        <div class="card">
            <h3>📖 So sánh Cookie vs Session</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--border-color);">
                        <th style="padding: 12px; text-align: left;">Tiêu chí</th>
                        <th style="padding: 12px; text-align: left;">Cookie</th>
                        <th style="padding: 12px; text-align: left;">Session</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Lưu trữ</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Client-side</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Server-side</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Dung lượng</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">~4KB</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Lớn hơn</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Bảo mật</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Thấp hơn</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Cao hơn</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;">Thời gian sống</td>
                        <td style="padding: 12px;">Theo thời gian set</td>
                        <td style="padding: 12px;">Đến khi đóng trình duyệt</td>
                    </tr>
                </tbody>
            </table>
        </div>
 
        <!-- Code Examples -->
        <div class="card">
            <h3>💻 Code Examples</h3>
            <div style="background: #2d3748; color: #e2e8f0; padding: 1rem; border-radius: 5px; margin: 1rem 0;">
                <h4>Set Cookie:</h4>
                <pre><code>&lt;?php
// Set cookie for 30 days
setcookie("user_theme", "dark", time() + (30 * 24 * 60 * 60), "/");
?&gt;</code></pre>
                
                <h4>Get Cookie:</h4>
                <pre><code>&lt;?php
$theme = $_COOKIE['user_theme'] ?? 'light';
?&gt;</code></pre>
                
                <h4>Delete Cookie:</h4>
                <pre><code>&lt;?php
setcookie("user_theme", "", time() - 3600, "/");
?&gt;</code></pre>
            </div>
        </div>
    </div>

    <script>
        // Theme preview interaction
        document.querySelectorAll('.theme-preview').forEach(preview => {
            preview.addEventListener('click', function() {
                document.querySelectorAll('.theme-preview').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Auto-detect system theme
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches && 
            !document.cookie.includes('user_theme')) {
            console.log('System prefers dark mode');
        }
    </script>
</body>
</html>