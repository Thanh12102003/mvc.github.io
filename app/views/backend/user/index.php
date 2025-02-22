<div>

    <h1>Danh sách người dùng</h1>
    <a class="btn btn-primary btn-sm" href="create">Thêm người dùng mới</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên người dùng</th>
                <th scope="col">Mật khẩu</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $key => $user): ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['password']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <a href="edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <!-- Delete Button -->
                        <a href="delete/<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>

<style>
    .table{
        border: solid black 2px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            if (!confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                return;
            }

            const row = this.closest('tr');
            const userId = this.dataset.id;

            fetch(`delete/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        // Xóa dòng khỏi bảng
                        row.remove();

                        // Cập nhật lại số thứ tự
                        const rows = document.querySelectorAll('tbody tr');
                        rows.forEach((row, index) => {
                            row.querySelector('th').textContent = index + 1;
                        });
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Có lỗi xảy ra!');
                });
        });
    });
});
</script>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
$isLoggedIn = isset($_SESSION['user_access_id']);
?>