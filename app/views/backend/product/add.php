<h6>Add Product</h6>
<a class="btn btn-success btn-sm" href="index">List Products</a>
<form action="store" method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" name="name" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="price" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Original Price</label>
        <input type="text" name="original_price" class="form-control">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <input type="text" name="description" class="form-control">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Category</label>
        <select class="form-control" name="category_id">
            <?php foreach ($categories as $key => $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Image</label>
        <input type="file" name="image" class="form-control-file">
    </div>


    <button type="submit" class="btn btn-primary">Add Product</button>
</form>