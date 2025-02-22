<div class="container mt-4">
    <h2>Sửa đơn hàng - <?= htmlspecialchars($order['ordercode']); ?></h2>

    <form method="POST" action="<?= BASE_URL ?>backend/order/update">
        <input type="hidden" name="ordercode" value="<?= htmlspecialchars($order['ordercode']); ?>">

        <div class="mb-3">
            <label for="status" class="form-label">Tình trạng đơn hàng</label>
            <select class="form-control" name="status" id="status">
                <option value="1" <?= $order['status'] == 1 ? 'selected' : ''; ?>>Đơn hàng mới</option>
                <option value="2" <?= $order['status'] == 2 ? 'selected' : ''; ?>>Đã xử lý</option>
                <option value="3" <?= $order['status'] == 3 ? 'selected' : ''; ?>>Đã hủy</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="shipping_name" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" name="shipping_name" id="shipping_name"
                   value="<?= htmlspecialchars($order['shipping_name']); ?>">
        </div>

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="shipping_address" id="shipping_address"
                   value="<?= htmlspecialchars($order['shipping_address']); ?>">
        </div>

        <div class="mb-3">
            <label for="shipping_phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="shipping_phone" id="shipping_phone"
                   value="<?= htmlspecialchars($order['shipping_phone']); ?>">
        </div>

        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="<?= BASE_URL ?>backend/order/details/<?= $order['ordercode']; ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>
