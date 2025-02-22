<?php
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Order.php';
require_once ROOT . '/app/models/Category.php';
class CheckoutController extends Controller
{

    private $orderModel;
    private $categoryModel;
    public function __construct()
    {

        $this->orderModel = new Order();
        $this->categoryModel = new Category();
        $this->data['menu_categories'] = $this->categoryModel->getAllCategories();
        $this->base_url = BASE_URL;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function success()
    {

        $data = [
            'title' => 'Thanh toán đặt hàng thành công',
            'menu_categories' => $this->data['menu_categories']
        ];

        $content = $this->view('frontend/home/success', $data, true);
        if (isset($_GET['partnerCode']) && $_GET['partnerCode'] !== "") {
            $this->index();
        }

        $this->view('layouts/frontend_layout', [
            'content' => $content,
            'base_url' => BASE_URL,  
            'title' => $data['title'],
        ]);
    }
    public function index()
    {
        if (!isset($_SESSION['user_customer_id'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }
        $method = $_POST['method'];
        if ($method != 'COD') {
            $method = 'MOMO';
        }
        $customer_id = $_SESSION['user_customer_id']; 
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }
        $ordercode = $this->generateOrderCode();
        $cart_items = json_encode($_SESSION['cart']);

        $status = 1;
        $this->orderModel->insertOrder($ordercode, $method, $customer_id, $cart_items, $status);

        unset($_SESSION['cart']);

        header("Location: " . BASE_URL . "frontend/checkout/success?ordercode=" . $ordercode);
        exit();
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo()
    {
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $orderInfo = "Thanh toán qua ATM";
        $amount = $_POST['tongtien']; 
        $orderId = time() . ""; 
        $redirectUrl = BASE_URL . "frontend/checkout/success?ordercode=$orderId"; 
        $ipnUrl = BASE_URL . "frontend/checkout/success?ordercode=$orderId"; 

        $extraData = "";  
        $requestId = time() . ""; 
        $requestType = "payWithATM"; 

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test", 
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  
        if ($jsonResult['resultCode'] == '0') {
           
            header('Location: ' . $jsonResult['payUrl']);
        } else {

            echo "Error: " . $jsonResult['message'];
        }
    }

    private function generateOrderCode()
    {
        return uniqid();
    }
}
