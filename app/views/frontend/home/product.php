<style>
    .card_main {
        margin: 0 auto;
        display: block;
    }

    .giasp{
        font-size:0.6cm;
        background-color:green;
        color:white;
        padding:5px;
        border-radius:5px;
        animation: nhapnhay 1s infinite;
    }

    .themgiohang{
        font-size:0.6cm;
        background-color:green;
        color:white;
        padding:5px;
        border-radius:5px;
        border: 0px;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .themgiohang:hover{
        background-color:rgb(151, 255, 141);
        color:black;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .themgiohang:active{
        background-color:rgb(246, 255, 164);
    }

    .anhsp{
        border: 3px solid black;
        border-radius:10px;
        transition: box-shadow 1s ease;
        height:500px;
        object-fit: cover;
    }

    .anhsp:hover{
        border: 4px solid black;
        border-radius:10px;
        box-shadow:7px 7px 7px 7px grey;
        transition: box-shadow 1s ease;
    }

    .anhsplienquan{
        border: 1px solid black;
        border-radius:10px;
        transition: box-shadow 1s ease;
        height:300px;
        object-fit: cover;
    }

    .anhsplienquan:hover{
        border: 1px solid black;
        border-radius:10px;
        box-shadow:5px 5px 5px 5px grey;
        transition: box-shadow 1s ease;
    }

    @keyframes nhapnhay {
            0% { color: white; }     
            50% { color: lime; }   
            100% { color: white; } 
        }
</style>

<div class="card card_main" style="width: 100%">
    <div class="card-body ">
        <div class="row">
            <?php include('includes/nav_logo.php') ?>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Product Card -->
                        <div class="card">
                            <img src="<?= BASE_URL  . 'uploads/products/' . htmlspecialchars($product['image']) ?>" class="anhsp" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1><?php echo $product['name']; ?></h1>
                            <p style="font-size:0.5cm;"><?php echo $product['description']; ?></p>
                            <div class="d-flex justify-content-between">
                                <span class="giasp">$ <?php echo number_format($product['price'], 2); ?></span>
                                <form method="POST" action="<?= BASE_URL ?>frontend/home/addToCart/<?= $product['id']; ?>">
                                    <input type="submit" class="themgiohang" value="Thêm vào giỏ hàng">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <h2>Sản phẩm liên quan</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($related as $product_re): ?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?= BASE_URL  . 'uploads/products/' . htmlspecialchars($product_re['image']) ?>" class="anhsplienquan" alt="<?= htmlspecialchars($product_re['name']); ?>" style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h4 class="card-title"><?= htmlspecialchars($product_re['name']); ?></h4>
                                    <p class="card-text"><?= htmlspecialchars($product_re['description']); ?></p>
                                    <p style="font-size:0.5cm;"><strong>Giá:</strong> $ <?= htmlspecialchars($product_re['price']); ?> </p>
                                    <a href="<?= BASE_URL ?>frontend/home/product/<?= $product_re['id']; ?>" class="btn btn-primary">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


        </div>

    </div>


</div>