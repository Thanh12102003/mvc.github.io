<div>
    
    <h1>Sản phẩm</h1>
    <a class="btn btn-primary btn-sm" href="create">Thêm sản phẩm mới</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Giá gốc</th>
                <th scope="col">Loại</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $product): ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td>$<?= number_format($product['price'], 0, ',', '.'); ?></td>
                    <td>$<?= number_format($product['original_price'], 0, ',', '.'); ?></td>
                    <td><?=
                        $product['category_name']
                        ?></td>
                    <td>
                        <img src="<?= BASE_URL  . 'uploads/products/' . $product['image'] ?>" height="80" width="80" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td><?= htmlspecialchars($product['description']); ?></td>
                    <td>
                        <a href="edit/<?= $product['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="delete/<?= $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Xóa</a>
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