<h1>Thêm người dùng</h1>
<a class="btn btn-primary btn-sm" href="index">Danh sách người dùng</a>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>backend/auth/store">
    <div class="form-group">
        <label for="username">Tên người dùng</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
</form>
