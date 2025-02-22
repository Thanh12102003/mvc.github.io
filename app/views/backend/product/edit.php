<h6>Sửa sản phẩm</h6>
<a class="btn btn-success btn-sm" href="../index">List Products</a>

<form action="../update/<?= $product['id'] ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputEmail1">Tên</label>
        <input type="text" value="<?= htmlspecialchars($product['name']) ?>" name="name" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Giá bán</label>
        <input type="text" value="<?= htmlspecialchars($product['price']) ?>" name="price" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Giá gốc</label>
        <input type="text" value="<?= htmlspecialchars($product['original_price']) ?>" name="original_price" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Mô tả</label>
        <input type="text" value="<?= htmlspecialchars($product['description']) ?>" name="description" class="form-control">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Loại</label>
        <select name="category_id" class="form-control">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Ảnh</label>
        <input type="file" name="image" class="form-control-file">
        <img src="<?= BASE_URL . 'uploads/products/' . $product['image'] ?>" height="80" width="80" alt="Product Image">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>