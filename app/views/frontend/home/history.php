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
                <h5>Lịch sử tài khoản</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <?php if (empty($orders)): ?>
                                    <p>Bạn không có đơn hàng nào.</p>
                                <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đặt đơn</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($order['ordercode']); ?></td>
                                                    <td>
                                                        <p>
                                                            <?php if ($order['status'] == 1): ?>
                                                                <span class="badge bg-primary">Đơn hàng mới</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">Đơn hàng đã được xử lý</span>
                                                            <?php endif; ?>
                                                        </p>
                                                    </td>
                                                    <td><?= date('Y-m-d H:i:s', strtotime($order['created_at'])); ?></td>
                                                    <td>
                                                        <a href="<?= BASE_URL ?>frontend/order/details/<?= $order['ordercode']; ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>