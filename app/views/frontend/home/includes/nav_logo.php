<?php
// Login successful
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="col-md-12">
    <img src="<?= BASE_URL ?>/assets/image/logo.jpg" class="logo" />
</div>

<div class="col-md-12">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar_box2">
        <div class="" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item active">
                    <a class="nav-link" href="<?= BASE_URL  ?>frontend/home/index">Trang chủ</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="<?= BASE_URL  ?>frontend/home/cart">Giỏ hàng</a>
                </li>
                <?php foreach ($menu_categories as $menu_category): ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?= BASE_URL  ?>frontend/home/category/<?= $menu_category['id'] ?>"><?= $menu_category['name'] ?></a>
                    </li>
                <?php endforeach; ?>

                <?php
                if (isset($_SESSION['user_customer_id'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>frontend/order/index">Lịch sử đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>frontend/home/shipping">Vận chuyển</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>frontend/home/logout">Đăng xuất</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Xin chào: <?= htmlspecialchars($_SESSION['username']) ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASE_URL  ?>frontend/home/login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL  ?>frontend/home/register">Đăng ký</a>
                    </li>
                <?php
                }
                ?>


            </ul>

        </div>
    </nav>
    <?php include('notification.php') ?>

    <!-- Modal -->
    <div class="modal fade" id="modal_contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Liên hệ qua Zalo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <style>
                        .zalo_style {
                            border: 2px solid #000;
                            border-radius: 10px;
                            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                        }

                    </style>
                    <p>Quét mã QR dưới đây để liên hệ với chúng tôi qua Zalo:</p>
                    <a href="https://zalo.me/mqsbdu493" target="_blank">
                        <img class="zalo_style" src="https://zalo.me/mqsbdu493" alt="QR Code Zalo" />
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>

                </div>
            </div>
        </div>
    </div>

</div>

