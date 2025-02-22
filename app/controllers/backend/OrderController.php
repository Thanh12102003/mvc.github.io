<?php
// Optionally include the Controller.php file (if not autoloaded)
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/models/Order.php';
class OrderController extends Controller
{

    private $orderModel;

    public function __construct()
    {

        $this->orderModel = new Order();

        $this->base_url = BASE_URL;
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_access_id'])) {
            // Redirect to login page if not logged in
            header("Location: " . BASE_URL . "backend/auth/login");
            exit();
        }
    }
    public function details($ordercode)
{
    // Lấy thông tin user từ session
    $user = $_SESSION['user'] ?? null; // user sẽ là mảng chứa thông tin đăng nhập

    // Fetch the order details by ordercode
    $order = $this->orderModel->getOrderByOrderCodeAndInfoCustomer($ordercode);

    // Kiểm tra xem đơn hàng có tồn tại không
    if ($order) {
        // Chuẩn bị dữ liệu để truyền sang view
        $data = [
            'order' => $order,
            'user'  => $user,
        ];

        // Kết xuất nội dung chi tiết đơn hàng
        $content = $this->view('backend/order/details', $data, true);

        // Hiển thị trang với layout backend
        $this->view('layouts/backend_layout', [
            'content' => $content,
            'title'   => 'Order Details',
        ]);
    } else {
        // Nếu không tìm thấy đơn hàng hoặc truy cập bị từ chối, chuyển hướng đến trang index
        header("Location: " . BASE_URL . "backend/order/index");
        exit();
    }
}

    public function index()
    {


        $orders = $this->orderModel->getOrders();

        // Pass the orders to the view
        $data = [
            'orders' => $orders,

        ];
        $content = $this->view('backend/order/history', $data, true);

        // Display the page using the frontend layout
        $this->view('layouts/backend_layout', [
            'content' => $content,
            'title' => 'Order History'
        ]);
    }
    public function updateOrderStatus()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ordercode = $_POST['ordercode'];
        $status = $_POST['status'];

        if ($ordercode && in_array($status, [1, 2, 3])) {
            $result = $this->orderModel->updateOrderStatus($ordercode, $status);

            if ($result) {
                if ($status == 3) {
                }
                header("Location: " . BASE_URL . "backend/order/details/$ordercode?success=Status updated.");
                exit();
            } else {
                header("Location: " . BASE_URL . "backend/order/details/$ordercode?error=Failed to update status.");
                exit();
            }
        } else {
            header("Location: " . BASE_URL . "backend/order/details/$ordercode?error=Invalid input.");
            exit();
        }
    }
}

    public function getOrderStatistics()
    {
        $orders = $this->orderModel->getOrderStatistics();
    }

    public function orderedit($ordercode)
{
    // Lấy dữ liệu đơn hàng từ database
    $order = $this->orderModel->getOrderByOrderCode($ordercode);

    if (!$order) {
        // Nếu không tìm thấy đơn hàng, hiển thị lỗi 404
        header("HTTP/1.0 404 Not Found");
        echo "Đơn hàng không tồn tại.";
        exit();
    }

    // Hiển thị giao diện sửa đơn hàng
    $content = $this->view('backend/order/orderedit', ['order' => $order], true);
    $this->view('layouts/backend_layout', [
        'content' => $content,
        'title' => 'Edit Order',
    ]);
}

public function update()
{
    // Lấy dữ liệu từ form
    $ordercode = $_POST['ordercode']; 
    $status = $_POST['status'];
    $shipping_name = $_POST['shipping_name'];
    $shipping_address = $_POST['shipping_address'];
    $shipping_phone = $_POST['shipping_phone'];
    $shipping_note = $_POST['shipping_note'];

    // Lấy thông tin đơn hàng từ model
    $order = $this->orderModel->getOrderByOrderCode($ordercode);

    // Kiểm tra nếu không tìm thấy đơn hàng
    if (!$order) {
        die("Không tìm thấy đơn hàng. Vui lòng kiểm tra lại dữ liệu.");
    }

    // Lấy shipping_id từ đơn hàng
    $shipping_id = $order['shipping_id'];

    // Cập nhật thông tin người nhận hàng (bảng `shippings`)
    $this->orderModel->updateShippingInfo($shipping_id, $shipping_name, $shipping_address, $shipping_phone, $shipping_note);

    // Cập nhật trạng thái đơn hàng (bảng `orders`)
    $this->orderModel->updateOrderStatus($ordercode, $status);

    // Chuyển hướng sau khi cập nhật
    header("Location: " . BASE_URL . "backend/order/details/$ordercode?success=Order updated.");
    exit();
}



public function updateOrder($ordercode, $data)
{
    $this->db->where('ordercode', $ordercode);
    $this->db->update('orders', $data);
}

public function cancelorder()
{
    $ordercode = $_POST['ordercode']; // Lấy mã đơn hàng từ form
    $status = 3; // Trạng thái đơn hàng đã hủy

    // Cập nhật trạng thái đơn hàng
    $result = $this->orderModel->updateOrderafterCancel($ordercode, ['status' => $status]);

    if ($result) {
        // Cập nhật thành công
        header("Location: " . BASE_URL . "backend/order/history?success=Order has been canceled.");
    } else {
        // Cập nhật thất bại
        header("Location: " . BASE_URL . "backend/order/details/$ordercode?error=Failed to cancel order.");
    }
    exit();
}

public function history()
{
    // Lấy danh sách đơn hàng từ model
    $orders = $this->orderModel->getOrders();

    // Truyền dữ liệu đến view
    $data = [
        'orders' => $orders,
    ];

    // Hiển thị giao diện lịch sử đơn hàng
    $content = $this->view('backend/order/history', $data, true);
    $this->view('layouts/backend_layout', [
        'content' => $content,
        'title' => 'Lịch sử đơn hàng',
    ]);
}

private $input;

public function delete($id)
{
    session_start();

    // Kiểm tra quyền
    if (!isset($_SESSION['user_access_id']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403); // Forbidden
        echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền xóa người dùng!']);
        exit();
    }

    // Xóa người dùng bằng model
    $result = $this->authModel->deleteUserById($id);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Xóa người dùng thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Xóa người dùng thất bại!']);
    }
    exit();
}


}
