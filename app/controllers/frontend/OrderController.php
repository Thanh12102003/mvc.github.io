<?php
// Optionally include the Controller.php file (if not autoloaded)
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Order.php';
require_once ROOT . '/app/models/Category.php';
require_once ROOT . '/app/models/Shipping.php';
class OrderController extends Controller
{

    private $orderModel;
    private $shippingModel;
    private $categoryModel;
    public function __construct()
    {

        $this->orderModel = new Order();
        $this->shippingModel = new Shipping();
        $this->categoryModel = new Category();

        // Load all categories and store in $data
        $this->data['menu_categories'] = $this->categoryModel->getAllCategories();
        $this->base_url = BASE_URL;
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function details($ordercode)
    {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_customer_id'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        // Fetch the order details by ordercode
        $order = $this->orderModel->getOrderByOrderCode($ordercode);

        // Check if the order exists and belongs to the logged-in customer
        if ($order && $order['customer_id'] == $_SESSION['user_customer_id']) {
            // Pass the order details to the view
            $data = ['order' => $order, 'menu_categories' => $this->data['menu_categories']];
            $content = $this->view('frontend/home/details', $data, true);

            // Display the page using the frontend layout
            $this->view('layouts/frontend_layout', [
                'content' => $content,
                'title' => 'Order Details',

            ]);
        } else {
            // Order not found or access denied
            header("Location: " . BASE_URL . "/home/history");
            exit();
        }
    }
    public function index()
    {
        // Ensure the customer is logged in
        if (!isset($_SESSION['user_customer_id'])) {
            // Redirect to login if no customer is logged in
            header("Location: " . BASE_URL . "/");
            exit();
        }
        $customer_id = $_SESSION['user_customer_id']; // Get customer ID from session
        $orders = $this->orderModel->getOrdersByCustomerId($customer_id);

        // Pass the orders to the view
        $data = [
            'orders' => $orders,
            'menu_categories' => $this->data['menu_categories']
        ];
        $content = $this->view('frontend/home/history', $data, true);

        // Display the page using the frontend layout
        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'title' => 'Order History'
        ]);
    }
}
