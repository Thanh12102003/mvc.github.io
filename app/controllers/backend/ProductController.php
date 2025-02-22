<?php

require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Product.php';
require_once ROOT . '/app/models/Category.php';
class ProductController extends Controller
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['user_access_id'])) {
            // Redirect to login page if not logged in
            header("Location: " . BASE_URL . "backend/auth/login");
            exit();
        }
        $this->productModel = new Product();
        $this->categoryModel = new Category();

        $this->base_url = BASE_URL;
    }


    public function index()
    {

        $products = $this->productModel->getAllProducts();

        $successMessage = isset($_GET['success']) ? $_GET['success'] : null;

        $data = [
            'products' => $products,
            'successMessage' => $successMessage,
            'title' => 'Products List',
        ];


        $content = $this->view('backend/product/index', $data, true); // Capture the content


        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }

    public function create()
    {
        $categories = $this->categoryModel->getAllCategories();
        $data = [
            'categories' => $categories,
            'title' => 'Product Add',
        ];
        // Render the index view
        $content = $this->view('backend/product/add', $data, true); // Capture the content
        // Load the view for listing categories
        // Pass base_url to the layout
        $this->view('layouts/backend_layout', [
            'content' => $content,
            'base_url' => $this->base_url,  // base_url should be defined globally or in your config
            'title' => $data['title'],
        ]);
    }
    public function store()
    {
        try {
            // Check if the form is submitted via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize input data
                $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
                $original_price = htmlspecialchars($_POST['original_price'], ENT_QUOTES, 'UTF-8');
                $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
                $category_id = (int)$_POST['category_id'];

                // Handle image upload
                $imagePath = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    // Define the upload directory relative to your project root
                    $uploadDir = dirname(__DIR__) . '../../../public/uploads/products/';
                    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                    $imagePath = $uploadDir . $fileName;

                    // Check if the upload directory exists, if not, create it
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Move uploaded file to the upload directory
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        throw new Exception('Failed to upload image.');
                    }

                    // Save relative path for database storage (relative to the public folder)
                    //$imagePathForDB = 'uploads/products/' . $fileName;
                }
                // Save product data using the model
                $result = $this->productModel->createProduct($name, $price, $description, $category_id, $fileName, $original_price);

                if ($result) {
                    // Redirect to the product listing page with success message
                    header('Location: ' . $this->base_url . 'backend/product/index?success=Product added successfully.');
                    exit;
                } else {
                    throw new Exception('Failed to save product.');
                }
            } else {
                throw new Exception('Invalid request method.');
            }
        } catch (Exception $e) {
            // Handle errors and display user-friendly messages
            $this->view('layouts/backend_layout', [
                'content' => '<p>Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>',
                'base_url' => $this->base_url,
                'title' => 'Error',
            ]);
        }
    }
    public function edit($id)
    {
        // Fetch product data by ID
        $product = $this->productModel->getProductById($id);

        // Fetch all categories for the dropdown
        $categories = $this->categoryModel->getAllCategories();

        if ($product) {
            // Prepare data for the view
            $data = [
                'product' => $product,
                'categories' => $categories,
                'title' => 'Edit Product',
            ];

            // Render the edit form
            $content = $this->view('backend/product/edit', $data, true);

            $this->view('layouts/backend_layout', [
                'content' => $content,
                'base_url' => $this->base_url,
                'title' => $data['title'],
            ]);
        } else {
            echo 'Product not found.';
        }
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $original_price = $_POST['original_price'];

            // Handle image upload if a new file is provided
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Define the upload directory relative to your project root
                $uploadDir = dirname(__DIR__) . '../../../public/uploads/products/';
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $imagePath = $uploadDir . $fileName;

                // Check if the upload directory exists, if not, create it
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move uploaded file to the upload directory
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    throw new Exception('Failed to upload image.');
                }

                // Save relative path for database storage (relative to the public folder)
                //$imagePathForDB = 'uploads/products/' . $fileName;
            }

            // Update product in the database
            $updated = $this->productModel->updateProduct($id, $name, $price, $description, $category_id, $fileName, $original_price);

            if ($updated) {
                header('Location: ' . $this->base_url . 'backend/product/index?success=Product updated successfully.');
                exit();
            } else {
                echo 'Failed to update product.';
            }
        }
    }

    public function delete($id)
    {

        $isDeleted = $this->productModel->deleteProduct($id);

        if ($isDeleted) {
            // Redirect to the category listing page
            header('Location: ' .  $this->base_url  . 'backend/product/index?success=Product deleted successfully.');
            exit();
        } else {
            echo 'Error: Product could not be deleted.';
        }
    }
}
