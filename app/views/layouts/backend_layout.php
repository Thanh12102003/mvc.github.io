<!-- app/views/layouts/backend_layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Backend Dashboard' ?></title> <!-- Use $title here -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />

</head>

<body>
    <div class="container">
        <header>

            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= BASE_URL ?>backend/auth/adminindex" class="nav-link">Admin Dashboard</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" target="_blank" href="<?= BASE_URL ?>">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>backend/auth/dashboard">Báo cáo</a>
                            </li>
                            <li class="nav-item"><a href="<?= BASE_URL ?>backend/order/index" class="nav-link">Đơn hàng</a></li>
                            </li>
                            <li class="nav-item"><a href="<?= BASE_URL ?>backend/category/index" class="nav-link">Danh mục</a></li>
                            </li>
                            <li class="nav-item"><a href="<?= BASE_URL ?>backend/product/index" class="nav-link">Sản phẩm</a></li>
                            </li>
                            <li class="nav-item"><a href="<?= BASE_URL ?>backend/auth/index" class="nav-link">Người dùng</a></li>
                            </li>

                            <?php
                            if (isset($_SESSION['user_access_id'])) {
                            ?>
                                <li class="nav-item"><a href="<?= BASE_URL ?>backend/auth/logout" class="nav-link">Đăng xuất</a></li>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item"><a href="<?= BASE_URL ?>backend/auth/login" class="nav-link">Đăng nhập</a></li>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>

                    </div>
                </div>
            </nav>

        </header>

        <style>
            
            .container-fluid{
                background-color:rgb(199, 199, 199);
                padding: 0.1cm;
                height: 2cm;
                box-shadow: 5px 5px 5px 5px grey;
                border: 2px solid black;
                border-radius:5px;
            }

            .nav-link{
                font-size:0.5cm;
                padding: 0.5cm;
                border-radius:7px;
                margin-right:1.2cm;
                font-weight:bold;
                color:black;
            }

            .nav-link:hover{
                color:white;
                background-color:black;
                border-radius:7px;
                padding:0.5cm;
            }

            .navbar-brand{
                /*margin-left:1cm;*/
                padding: 0.5cm;
                font-weight:bold;
                color:black;
            }

            .navbar-brand:hover{
                color:white;
                background-color:black;
                border-radius:7px;
                padding: 0.5cm;
            }

        </style>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert" id="success-alert">
                <?= htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert" id="error-alert">
                <?= htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script>
            $(document).ready(function() {
                // Make an AJAX call to get the order statistics data
                $.ajax({
                    url: '../order/getOrderStatistics', // Change this to your actual controller URL
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Format the data to be used in Morris.js
                        var chartData = data.map(function(item) {
                            return {
                                date: item.date_created,
                                orders: item.total_orders,
                                quantity: item.total_quantity,
                                profit: item.total_profit
                            };
                        });

                        // Render Morris.js Line Chart
                        new Morris.Bar({
                            element: 'orderStatisticsChart',
                            data: chartData,
                            xkey: 'date',
                            ykeys: ['orders', 'quantity', 'profit'],
                            labels: ['Total Orders', 'Total Quantity', 'Total Profit'],
                            parseTime: false,
                            resize: true,
                            lineColors: ['#0b62a4', '#7a92a3', '#4da74d'], // Customize the line colors
                            hideHover: 'auto'
                        });
                    },
                    error: function(err) {
                        console.log('Error fetching order statistics:', err);
                    }
                });
            });
        </script>
        <script>
            // Function to hide alert after 2 seconds
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                var errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    successAlert.classList.add('fade'); // You can use fade effect if you like
                    successAlert.style.display = 'none'; // Hide the success alert
                }

                if (errorAlert) {
                    errorAlert.classList.add('fade'); // You can use fade effect if you like
                    errorAlert.style.display = 'none'; // Hide the error alert
                }
            }, 2000); // 2 seconds
        </script>

        <!-- Main Content Area -->
        <main>
            <?= $content ?> <!-- This is where the page-specific content will be injected -->
        </main>

        <!-- Footer -->
        <footer>
            <p>&copy; <?= date('Y') ?> Coded by NCT.</p>
        </footer>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</html>