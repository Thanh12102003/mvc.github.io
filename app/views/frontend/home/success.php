<style>
    .card_main {
        margin: 0 auto;
        display: block;
    }
</style>
<div class="card card_main" style="width: 100%">

    <div class="card-body ">
        <div class="row">
            <?php include('includes/nav_logo.php') ?>
            <div class="col-md-12">
                <h1 class="h3 font-weight-normal text-center">Checkout Thành Công</h1>
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <?php
                                if (isset($_GET['ordercode'])) {
                                    $ordercode = htmlspecialchars($_GET['ordercode']);
                                    echo "<h3>Cảm ơn vì đã mua hàng!</h3>";
                                    echo "<p>Đơn hàng của bạn đã được đặt thành công. Mã đơn hàng của bạn là: <strong>$ordercode</strong></p>";
                                } else {
                                    echo "<h3>Không tìm thấy đơn hàng!</h3>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>