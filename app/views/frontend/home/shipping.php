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

                <div class="card">
                    <div class="card-body">
                        <div class="row">
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


                                    <button type="submit" class="btn btn-primary btn-sm">Lưu thông tin</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>