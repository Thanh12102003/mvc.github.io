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
                            <h1 class="h3 font-weight-normal text-center">Đăng ký tài khoản</h1>
                            <div class="col-md-12">
                                <form autocomplete="off" action="register_post" method="POST">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Tên đăng nhập</label>
                                        <input type="text" name="username" required placeholder="Nhập tên đăng nhập" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                                        <input type="password" name="customer_password" required placeholder="Nhập mật khẩu" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Mật khẩu cấp 2</label>
                                        <input type="password" name="backup_password" required placeholder="Nhập mật khẩu cấp 2" class="form-control" id="exampleInputPassword1">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm">Đăng ký</button>
                                    <p>Bạn đã có tài khoản?<a href="<?= BASE_URL  ?>frontend/home/login">Đăng nhập ngay</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>