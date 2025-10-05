<?php
// php-7.4/index.php - Bài 7.4: GetForm
$page = $_GET['page'] ?? 'home';

// Xử lý session start
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 7.4 - GetForm - Trần Hồng Khang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            color: #2c3e50;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .menu {
            background: rgba(44, 62, 80, 0.95);
            padding: 18px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .menu a:hover {
            background: #3498db;
            transform: translateY(-2px);
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            min-height: 500px;
            backdrop-filter: blur(10px);
        }
        .footer {
            background: rgba(44, 62, 80, 0.95);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #e0e0e0;
            padding: 15px;
        }
        th {
            background: #3498db;
            color: white;
            font-weight: 600;
        }
        input, select, textarea {
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            width: 100%;
            transition: border 0.3s ease;
            font-size: 14px;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        .btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 5px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        .btn-reset {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        .result {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        .radio-group, .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin: 10px 0;
        }
        .radio-group label, .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🎯 Bài 7.4 - GetForm - Xử lý Form Data</h1>
        <p>MSSV: 29_TRANHONGKHANG - Xử lý các loại input form khác nhau</p>
    </div>

    <!-- Menu Navigation -->
    <div class="menu">
        <a href="index.php?page=home">🏠 Home</a>
        <a href="index.php?page=register">📝 Register</a>
        <a href="index.php?page=contact1Page">📞 Contact</a>
        <a href="index.php?page=formDemo">🎨 Form Demo</a>
        <a href="index.php?page=registerProcess">📊 View Data</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="content">
            <?php
            // Include trang tương ứng
            switch ($page) {
                case 'register':
                    include 'pages/register.php';
                    break;
                case 'registerProcess':
                    include 'pages/registerProcess.php';
                    break;
                case 'contact1Page':
                    include 'pages/contact1Page.php';
                    break;
                case 'formDemo':
                    include 'pages/formDemo.php';
                    break;
                case 'home':
                default:
                    include 'pages/home.php';
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2025 - Trần Hồng Khang - 29_TRANHONGKHANG - Bài 7.4: GetForm</p>
    </div>

    <script>
        // Auto-resize textarea
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });

        // Add animation to form elements
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            element.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>