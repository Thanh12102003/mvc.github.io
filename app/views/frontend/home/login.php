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
                            <h1 class="h3 font-weight-normal text-center">Đăng nhập tài khoản</h1>
                            <div class="col-md-12">
                                <form autocomplete="off" method="POST" action="customer_login">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Tên đăng nhập</label>
                                        <input type="text" name="username" placeholder="Nhập tên đăng nhập" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" placeholder="Nhập mật khẩu" class="form-control" id="exampleInputPassword1">
                                    </div>


                                    <button type="submit" class="btn btn-primary btn-sm">Đăng nhập</button>
                                    <p>Bạn chưa có tài khoản?<a href="<?= BASE_URL  ?>frontend/home/register">Đăng ký ngay</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>


</div>