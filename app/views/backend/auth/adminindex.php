<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
$isLoggedIn = isset($_SESSION['user_access_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url('<?= BASE_URL ?>/assets/image/background1.jpg');
            background-size:100%;
        }

        .dashboard-content {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: 30%;
            margin-right: 30%;
            margin-top:1cm;
            opacity:90%;
        }

        .chữ{
            text-align:center;
            animation: nhapnhay 1s infinite;
        }

        @keyframes nhapnhay {
            0% { color: red; }     
            50% { color: blue; }   
            100% { color: red; } 
        }
    </style>
</head>
<body>
    <div class="dashboard-content">
    <h1 style="text-align:center; font-weight:bold;">Quản lý Admin</h1>
    <br>
        <h5 class="chữ">Chào mừng đến với trang quản lý dành cho Admin!</h5>
    </div>
</body>
</html>
