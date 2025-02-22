<div class="container mt-4">
<div class="printable-area">
    <h2>Chi tiết đơn hàng - <?= htmlspecialchars($order['ordercode']); ?></h2>

    <!-- Display Status -->
    <p><strong>Tình trạng:</strong>
    <?php if ($order['status'] == 1): ?>
        <span class="donhangmoi">Đơn hàng mới</span>
    <?php elseif ($order['status'] == 2): ?>
        <span class="donhangdaxuly">Đơn hàng đã được xử lý</span>
    <?php elseif ($order['status'] == 3): ?>
        <span class="donhangdahuy">Đơn đã hủy</span>
    <?php else: ?>
        <span class="tinhtrang">Trạng thái không xác định</span>
    <?php endif; ?>
    </p>

    <p><strong>Ngày đặt:</strong> <?= date('Y-m-d H:i:s', strtotime($order['created_at'])); ?></p>
    <h4>Thông tin khách hàng</h4>
    <p><strong>Tên:</strong> <?= htmlspecialchars($order['customer_name']); ?></p>
    <h4>Người lập đơn</h4>
    <p><strong>Tên:</strong> Minh Vũ Châu-5</p>
    <h4>Thông tin vận chuyển</h4>
    <p><strong>Tên:</strong> <?= htmlspecialchars($order['shipping_name']); ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['shipping_phone']); ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address']); ?></p>
    <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['shipping_note']); ?></p>


    <h4>Sản phẩm trong giỏ hàng:</h4>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Decode the cart items stored in JSON format
            $cartItems = json_decode($order['cart_items'], true);
            foreach ($cartItems as $item): ?>
                <tr>
                    <td>
                        <!-- Display product image -->
                        <img src="<?= BASE_URL  . 'uploads/products/' . htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="50" height="50" style="object-fit: cover;">
                    </td>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?= number_format($item['price'], 2); ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>

                </tr>

            <?php endforeach; ?>
            <form method="POST" action="<?= BASE_URL ?>backend/order/updateOrderStatus" style="display:inline;" class="no-print">

                <input type="hidden" name="ordercode" value="<?= $order['ordercode']; ?>">
                <?php
                if ($order['status'] != 2) {
                ?>
                    <tr>
                        <td>
                        <select class="form-control" name="status">
                            <option value="1" <?= $order['status'] == 1 ? 'selected' : ''; ?>>Đơn hàng mới</option>
                            <option value="2" <?= $order['status'] == 2 ? 'selected' : ''; ?>>Đã xử lý</option>
                            <option value="3" <?= $order['status'] == 3 ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>

                        </td>

                        <td><button type="submit" class="btn btn-primary">Cập nhật tình trạng</button></td>
                    </tr>
                <?php
                }
                ?>
            </form>
        </tbody>
    </table>
</div>
</div>
<div style="display: flex; gap: 10px;">
    <div class="text-end mb-3">
        <a href="<?= BASE_URL ?>backend/order/orderedit/<?= $order['ordercode']; ?>" class="btn btn-warning">
            Sửa đơn hàng
        </a>
    </div>
    
    <div>
        <form method="POST" action="<?= BASE_URL ?>backend/order/cancelorder" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
            <input type="hidden" name="ordercode" value="<?= htmlspecialchars($order['ordercode']); ?>">
            <button type="submit" class="suavahuy">Hủy Đơn Hàng</button>
        </form>
    </div>
    
    <div>
        <button id="printInvoice" class="btn btn-success">In Đơn Hàng</button>
    </div>
</div>


<style>
    .suavahuy{
        background-color:red;
        border: 1px red;
        border-radius:7px;
        float:right;
        padding:6px;
        width:3.28cm;
        height:1cm;
        color:white;
    }

    @media print {
    .no-print {
        display: none;
    }
    }

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


</style>

<script>
    document.getElementById('printInvoice').addEventListener('click', function () {
        // Tạo cửa sổ in
        var printContents = document.querySelector('.printable-area').innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Order</title>
                    <style>
                        /* Tùy chỉnh in */
                        @media print {
                            body {
                                margin: 0;
                                font-family: Arial, sans-serif;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin: 20px 0;
                            }
                            table, th, td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: left;
                            }
                            th {
                                background-color: #f2f2f2;
                            }
                            @page {
                                margin: 0;
                            }
                        }
                    </style>
                </head>
                <body>${printContents}</body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });
</script>

