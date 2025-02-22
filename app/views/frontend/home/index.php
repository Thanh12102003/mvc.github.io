<style>
    .card_main {
        margin: 0 auto;
        display: block;
    }

    .nutchitiet{
        font-size:0.6cm;
        text-decoration:none;
        background-color:blue;
        padding:5px 10px;
        border-radius:10px;
        color:white;
        transition: background-color 0.5s, color 0.5s ease;
    }

    .nutchitiet:hover{
        background-color:cyan;
        transition: background-color 0.5s, color 0.5s ease;
        color:black;
    }

    .anhsp{
        border: 3px solid black;
        border-radius:10px;
        transition: box-shadow 1s ease;
        height:400px;
        object-fit: cover;
    }

    .anhsp:hover{
        border: 3px solid black;
        border-radius:10px;
        box-shadow:6px 6px 6px 6px grey;
        transition: box-shadow 1s ease;
    }
</style>
<div class="card card_main" style="width: 100%">

    <div class="card-body ">
        <div class="row">
            <?php include('includes/nav_logo.php') ?>
            <div class="col-md-12">
                <br>
                <h1 style="font-size:1.2cm;" class="h3 font-weight-normal text-center"><?= htmlspecialchars($title); ?>Tất cả sản phẩm</h1>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($all_product as $product): ?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?= BASE_URL  . 'uploads/products/' . htmlspecialchars($product['image']) ?>" class="anhsp" alt="<?= htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h4 class="card-title"><?= htmlspecialchars($product['name']); ?></h4>
                                    <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                                    <p style="font-size:0.5cm;"><strong>Giá:</strong> $ <?= htmlspecialchars($product['price']); ?> </p>
                                    <a href="<?= BASE_URL ?>frontend/home/product/<?= $product['id']; ?>" class="nutchitiet">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>


        </div>

    </div>


</div>