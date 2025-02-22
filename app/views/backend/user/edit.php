<h1><?= $title ?></h1>

<form method="POST" action="<?= BASE_URL ?>backend/auth/update/<?= $user['id'] ?>">
    <div class="form-group">
        <label for="username">Tên người dùng</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>


    <div class="form-group">
        <label for="password">Mật khẩu mới (Để trống nếu không đặt lại mật khẩu)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>