<style>
    .card_main {
        margin: 0 auto;
        display: block;
    }

    .luuthongtin{
        font-size:0.5cm;
        background-color:blue;
        color:white;
        padding:5px 10px;
        border-radius:10px;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .luuthongtin:hover{
        background-color:cyan;
        color:black;
        transition: background-color 0.5s ease, color 0.5s ease;
    }
</style>
<?php
// Login successful
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="card card_main" style="width: 100%">

    <div class="card-body ">
        <div class="row">
            <?php include('includes/nav_logo.php') ?>
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h1 style="font-size:1.2cm;" class="h3 font-weight-normal text-center">Giỏ hàng của bạn</h1>
                            <div class="col-md-12">
                                <?php if (isset($cart) && !empty($cart)): ?>
                                    <h3>Giỏ hàng</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Giá</th>
                                                <th>Số lượng</th>
                                                <th>Tổng</th>
                                                <th>Sửa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart as $item): ?>
                                                <tr>
                                                    <td><img src="<?= BASE_URL  . 'uploads/products/' . htmlspecialchars($item['image_url']) ?>" alt="<?php echo $item['name']; ?>" style="width: 50px;"> <?php echo $item['name']; ?></td>
                                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                                    <td>
                                                        <!-- Display quantity -->
                                                        <?php echo $item['quantity']; ?>

                                                        <!-- Form for decreasing quantity -->
                                                        <form method="POST" action="<?= BASE_URL ?>frontend/home/updateQuantity/<?= $item['id']; ?>/decrease" style="display:inline;">
                                                            <button type="submit" class="btn btn-warning btn-sm">-</button>
                                                        </form>

                                                        <!-- Form for increasing quantity -->
                                                        <form method="POST" action="<?= BASE_URL ?>frontend/home/updateQuantity/<?= $item['id']; ?>/increase" style="display:inline;">
                                                            <button type="submit" class="btn btn-success btn-sm">+</button>
                                                        </form>
                                                    </td>
                                                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                                    <td>
                                                        <a href="<?= BASE_URL ?>frontend/home/removeFromCart/<?= $item['id']; ?>" class="btn btn-danger">Xóa</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-between">
                                        <h4>Tổng: $<?php echo number_format(array_sum(array_map(function ($item) {
                                                        return $item['price'] * $item['quantity'];
                                                    }, $cart)), 2); ?></h4>

                                        <form method="POST" action="<?= BASE_URL ?>frontend/checkout/index" style="display:inline;">
                                            <input type="hidden" value="COD" name="method">
                                            <button type="submit" class="btn btn-success">Checkout COD</button>
                                        </form>
                                        <form method="POST" action="<?= BASE_URL ?>frontend/checkout/momo" style="display:inline;">
                                            <input type="hidden" value="<?php echo array_sum(array_map(function ($item) {
                                                                            return $item['price'] * $item['quantity'];
                                                                        }, $cart)); ?>" name="tongtien">
                                            <button type="submit" name="momo" class="btn btn-danger">Checkout MOMO</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <p>Giỏ hàng trống!</p>
                                <?php endif; ?>

                            </div>
                            <?php if (isset($cart) && !empty($cart)): ?>
                                <h1 class="h3 font-weight-normal text-center">Cập nhật thông tin vận chuyển</h1>
                                <div class="col-md-12">
                                    <form autocomplete="off" method="POST" action="saveShipping">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Tên người nhận</label>
                                            <input type="text" name="name" value="<?= $getuser['name'] ?? "" ?>" placeholder="Nhập tên người nhận" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
                                            <input type="text" name="address" value="<?= $getuser['address'] ?? "" ?>" placeholder="Nhập địa chỉ" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone" value="<?= $getuser['phone'] ?? "" ?>" placeholder="Nhập điện thoại nhận hàng" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Ghi chú</label>
                                            <textarea name="note" placeholder="Nhập ghi chú đơn hàng" class="form-control" id="exampleInputPassword1"><?= $getuser['note'] ?? "" ?></textarea>


                                        </div>


                                        <button type="submit" class="luuthongtin">Lưu thông tin</button>

                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>