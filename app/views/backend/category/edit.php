<h6>Sửa thể loại</h6>
<a class="btn btn-success btn-sm" href="index">Danh mục thể loại</a>
<form action="../update/<?= $category['id'] ?>" method="POST" autocomplete="off">
    <div class="form-group">
        <label for="exampleInputEmail1">Tên</label>
        <input type="text" value="<?= $category['name'] ?>" name="name" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Mô tả</label>
        <input type="text" value="<?= $category['description'] ?>" name="description" class="form-control">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Cập nhật thể loại</button>
</form>