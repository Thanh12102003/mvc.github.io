<div class="col-md-12">
    <h1>Đơn hàng</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <?php if (empty($orders)): ?>
                        <p>Bạn chưa có đơn hàng nào.</p>
                    <?php else: ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>

                                    <th>Tình trạng</th>
                                    <th>Ngày đặt</th>
                                    <th>Phương thức</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['ordercode']); ?></td>

                                        <td>
                                            <?php if ($order['status'] == 1): ?>
                                                <span class="donhangmoi">Đơn hàng mới</span>
                                            <?php elseif ($order['status'] == 2): ?>
                                                <span class="donhangdaxuly">Đơn hàng đã xử lý</span>
                                            <?php elseif ($order['status'] == 3): ?>
                                                <span class="donhangdahuy">Đơn hàng đã hủy</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= date('Y-m-d H:i:s', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <?php if ($order['method'] != 'MOMO'): ?>
                                                <span class="cod">COD</span>
                                            <?php else: ?>
                                                <span class="momo">MOMO</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>backend/order/details/<?= $order['ordercode']; ?>" class="xemchitiet">Xem chi tiết</a>
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
<br>
<style>
    .donhangmoi{
        background-color:rgb(93, 0, 255);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
    }

    .donhangdaxuly{
        background-color:rgb(0, 189, 19);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
    }

    .donhangdahuy{
        background-color:rgb(255, 0, 0);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
    }

    .cod{
        background-color:rgb(145, 196, 255);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
    }

    .momo{
        background-color:rgb(218, 0, 214);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
    }

    .xemchitiet{
        background-color:rgb(141, 141, 141);
        color:white;
        border-radius:5px;
        padding:5px;
        font-weight:bold;
        text-decoration:none;
    }

    .xemchitiet:hover{
        color:yellow;
    }

    th{
        font-size:0.6cm;
    }

    .card{
        border: 2px solid black;
        box-shadow: 5px 5px 5px 5px grey;
    }
</style>