<div>
    
    <h1>Danh mục thể loại</h1>
    <a class="btn btn-primary btn-sm" href="create">Thêm thể loại mới</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $key => $category): ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= htmlspecialchars($category['name']); ?></td>
                    <td><?= htmlspecialchars($category['description']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <a href="edit/<?= $category['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <!-- Delete Button -->
                        <a href="delete/<?= $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>

<style>
    .table{
        border: solid 2px black;
    }
    
</style>