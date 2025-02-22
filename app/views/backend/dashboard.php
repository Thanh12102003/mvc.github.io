<div>

    <h1>Báo cáo</h1>
    <div id="orderStatisticsChart" style="height: 250px;"></div>
    <p class="textbaocao">Báo cáo theo ngày</p>
</div>

<style>
    .textbaocao{
        text-align:center;
        font-size:0.7cm;
    }
</style>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
$isLoggedIn = isset($_SESSION['user_access_id']);
?>