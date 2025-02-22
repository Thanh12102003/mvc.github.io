<?php
// Optionally include the Controller.php file (if not autoloaded)
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Customer.php';
require_once ROOT . '/app/models/Category.php';
require_once ROOT . '/app/models/Product.php';
require_once ROOT . '/app/models/Shipping.php';
class HomeController extends Controller
{
    private $registerModel;
    private $categoryModel;
    private $productModel;
    private $shippingModel;
    public function __construct()
    {

        $this->registerModel = new Customer();
        $this->shippingModel = new Shipping();
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        // Load all categories and store in $data
        $this->data['menu_categories'] = $this->categoryModel->getAllCategories();
        $this->base_url = BASE_URL;
    }

    public function index()
    {

        $all_product = $this->productModel->getAllProducts();

        $data = [
            'title' => '',
            'menu_categories' => $this->data['menu_categories'],
            'all_product' => $all_product
        ];

        $content = $this->view('frontend/home/index', $data, true); // Capture the content

        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function saveShipping()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_customer_id']; // Ensure this session variable is set

            $shippingData = [
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'name' => $_POST['name'] ?? '',
                'note' => $_POST['note'] ?? ''
            ];

            $result = $this->shippingModel->updateShipping($user_id, $shippingData);

            if ($result) {
                header("Location: " . BASE_URL . "frontend/home/cart?success=Shipping details saved successfully.");
            } else {
                header("Location: " . BASE_URL . "frontend/home/cart?error=Failed to save shipping details.");
            }
            exit();
        }
    }

    public function shipping()
    {
        session_start();

        if (!isset($_SESSION['user_customer_id'])) {
            // Redirect to login page if not logged in
            header("Location: " . BASE_URL . "frontend/home/index");
            exit();
        }
        $user_id = $_SESSION['user_customer_id']; // Ensure this session variable exists and is set
        $getuser = $this->shippingModel->getShippingByUserId($user_id);

        $data = [
            'title' => 'Cập nhật địa chỉ vận chuyển',
            'menu_categories' => $this->data['menu_categories'],
            'getuser' => $getuser
        ];

        $content = $this->view('frontend/home/shipping', $data, true); // Capture the content

        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }

    public function removeFromCart($id)
    {
        session_start();
        // Check if the cart session exists
        if (isset($_SESSION['cart'])) {
            // Loop through the cart and remove the product by its ID
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] == $id) {
                    unset($_SESSION['cart'][$key]); // Remove the item from the cart
                    break;
                }
            }

            // Re-index the cart array after removal to prevent gaps in the indices
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        // Redirect back to the cart page
        header("Location: " . BASE_URL . "frontend/home/cart?success=Deleted Sucessfully");
        exit();
    }
    // Method to update the quantity of an item in the cart
    public function updateQuantity($id, $action)
    {
        session_start();
        // Check if the cart session exists
        if (isset($_SESSION['cart'])) {
            // Loop through the cart to find the item
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    // Increase the quantity
                    if ($action === 'increase') {
                        $item['quantity'] += 1;
                    }
                    // Decrease the quantity
                    elseif ($action === 'decrease' && $item['quantity'] > 1) {
                        $item['quantity'] -= 1;
                    }
                    break;
                }
            }

            // Re-index the cart array after update to prevent gaps in the indices
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        // Redirect back to the cart page
        header("Location: " . BASE_URL . "frontend/home/cart?success=Updated to Cart successfully."); // Redirect to the cart page
        exit();
    }
    public function addToCart($id)
    {
        // Get the product details using the model
        session_start();
        $product = $this->productModel->getProductById($id);

        if ($product) {
            // Check if the cart session already exists
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; // Initialize the cart if it's empty
            }

            // Check if the product already exists in the cart
            $productFound = false;
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] === $product['id']) {
                    $cartItem['quantity'] += 1; // If the product exists, increase the quantity
                    $productFound = true;
                    break;
                }
            }

            // If the product was not found in the cart, add it as a new item
            if (!$productFound) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1,
                    'image_url' => $product['image']
                ];
            }

            // Redirect or return a response
            header("Location: " . BASE_URL . "frontend/home/cart?success=Added to Cart successfully."); // Redirect to the cart page
            exit();
        }
    }
    public function cart()
    {
        session_start();
        //session_destroy();
        $user_id = $_SESSION['user_customer_id']; // Ensure this session variable exists and is set
        $getuser = $this->shippingModel->getShippingByUserId($user_id);
        $data = [
            'title' => 'Giỏ hàng',
            'menu_categories' => $this->data['menu_categories'],
            'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : [],
            'getuser' => $getuser
        ];
        $content = $this->view('frontend/home/cart', $data, true); // Capture the content

        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function category($id)
    {
        if ($id !== null && is_numeric($id)) {
            // Fetch the category and other data if necessary
            $category = $this->categoryModel->getCategoryById($id);
            $category_products = $this->categoryModel->getCategoryProductsById($id);

            if ($category) {
                // Prepare data for the view
                $data = [
                    'title' => 'Web bán hàng MVC PHP - ' . htmlspecialchars($category['name']),
                    'menu_categories' => $this->data['menu_categories'],
                    'category' => $category, // Pass specific category data to the view
                    'category_products' => $category_products,
                ];

                // Render the view content
                $content = $this->view('frontend/home/category', $data, true);

                // Render the full page layout
                $this->view('layouts/frontend_layout', [
                    'content' => $content,
                    'base_url' => $this->base_url, // Ensure $this->base_url is initialized in the constructor
                    'title' => $data['title'],
                ]);
            } else {
                // Redirect if the category is not found
                header('Location: ' . $this->base_url . '/?error=Category not found.');
                exit();
            }
        } else {
            // Redirect if $id is invalid
            header('Location: ' . $this->base_url . '/?error=Invalid category ID.');
            exit();
        }
    }
    public function product($id)
    {
        if ($id !== null && is_numeric($id)) {
            // Fetch the category and other data if necessary

            $product = $this->productModel->getProductById($id);
            $related = $this->productModel->getRelatedProductById($id);

            if ($product) {
                // Prepare data for the view
                $data = [
                    'title' => 'Web bán hàng MVC PHP - ' . htmlspecialchars($product['name']),
                    'menu_categories' => $this->data['menu_categories'],
                    'product' => $product,
                    'related' => $related
                ];

                // Render the view content
                $content = $this->view('frontend/home/product', $data, true);

                // Render the full page layout
                $this->view('layouts/frontend_layout', [
                    'content' => $content,
                    'base_url' => $this->base_url, // Ensure $this->base_url is initialized in the constructor
                    'title' => $data['title'],
                ]);
            } else {
                // Redirect if the category is not found
                header('Location: ' . $this->base_url . '/?error=Product not found.');
                exit();
            }
        } else {
            // Redirect if $id is invalid
            header('Location: ' . $this->base_url . '/?error=Invalid product ID.');
            exit();
        }
    }
    public function history()
    {
        $data = [
            'title' => 'Lịch sử',
        ];

        $content = $this->view('frontend/home/history', $data, true); // Capture the content


        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function login()
    {

        $data = [
            'title' => 'Đăng nhập tài khoản người dùng',
            'menu_categories' => $this->data['menu_categories']

        ];

        $content = $this->view('frontend/home/login', $data, true); // Capture the content


        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function register()
    {

        $data = [
            'title' => 'Đăng ký tài khoản người dùng',
            'menu_categories' => $this->data['menu_categories']
        ];

        $content = $this->view('frontend/home/register', $data, true); // Capture the content


        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }

    public function customer_login()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Hash the input password using MD5
            $hashedPassword = md5($password);

            // Call the model's login query with the username and hashed password
            $user = $this->registerModel->queryLogin($username, $hashedPassword);

            if ($user) {
                // Login successful
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Set session variables
                $_SESSION['user_customer_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to the category/index page after login
                header('Location: ' . BASE_URL . '/frontend/home/index?success=Login successfully.');
                exit();
            } else {
                // Login failed, redirect back to the login page with an error message
                header('Location: ' . BASE_URL . '/frontend/home/index?error=Login failed.');
                exit();
            }
        }
    }

    public function register_post()
    {
        // Get the form data
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $customer_password = md5($_POST['customer_password']);
        $backup_password = md5($_POST['backup_password']);
        $customer_status = 1;
        // Validate data
        if ($username && $customer_password && $backup_password) {
            // Create a new category instance from the Category model
            $isCreated = $this->registerModel->createCustomer($username, $customer_password, $backup_password, $customer_status);

            if ($isCreated) {
                // Redirect to the category index page or show a success message
                header('Location: ' .  $this->base_url . '/frontend/home/register');
                exit();
            } else {
                echo 'Error: Customer could not be created.';
            }
        } else {
            echo 'Please fill in all fields.';
        }
    }
    public function blog_detail($id = 1)
    {
        $data = [
            'title' => 'Chi tiết bài viết',
        ];

        $content = $this->view('frontend/home/blo_detail', $data, true); // Capture the content


        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function logout()
    {
        // Start the session if it's not already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Unset specific session variables
        unset($_SESSION['user_customer_id']);
        unset($_SESSION['username']);


        header('Location: ' . BASE_URL . '/?success=Logout successfully.');
        exit();
    }
}
