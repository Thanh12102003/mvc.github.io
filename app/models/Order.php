<?php
require_once ROOT . '/system/Database.php';
class Order
{

    // Database connection
    private $db;

    public function __construct()
    {

        $this->db = (new Database())->conn;
    }


    public function insertOrder($ordercode, $method, $customer_id, $cart_items, $status)
    {
        // SQL query to insert the order into the database
        $query = "INSERT INTO orders (ordercode,method, customer_id, cart_items, status) 
                  VALUES (:ordercode,:method ,:customer_id, :cart_items, :status)";

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ordercode', $ordercode);
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':cart_items', $cart_items);
        $stmt->bindParam(':status', $status);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error inserting order: " . $e->getMessage());
            return false;
        }
        
    }
    public function getOrders()
    {
        // SQL query to get orders for the given customer ID
        $query = "SELECT * FROM orders ORDER BY created_at DESC";

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Fetch all orders
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fetch all orders by customer_id
    public function getOrdersByCustomerId($customer_id)
    {
        // SQL query to get orders for the given customer ID
        $query = "SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY created_at DESC";

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();

        // Fetch all orders
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fetch a single order by its ordercode
    public function getOrderByOrderCode($ordercode)
    {
        // SQL query to get an order by its unique ordercode
        $query = "SELECT * FROM orders WHERE ordercode = :ordercode";
        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ordercode', $ordercode);
        $stmt->execute();

        // Fetch the order (if exists)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateOrderStatus($ordercode, $status)
{
    $sql = "UPDATE orders SET status = :status WHERE ordercode = :ordercode";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':ordercode', $ordercode);
    return $stmt->execute();
}

    public function getOrderByOrderCodeAndInfoCustomer($ordercode)
    {
        $query = "
        SELECT 
            orders.*, 
            customers.id AS customer_id, 
            customers.username AS customer_name, 
            shippings.address AS shipping_address, 
            shippings.phone AS shipping_phone, 
            shippings.name AS shipping_name, 
            shippings.note AS shipping_note
        FROM orders
        INNER JOIN customers ON orders.customer_id = customers.id
        LEFT JOIN shippings ON orders.customer_id = shippings.user_id
        WHERE orders.ordercode = :ordercode
    ";

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ordercode', $ordercode, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the order along with customer and shipping data (if exists)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getOrderStatistics()
    {
        // Fetch data from the 'order_statistics' table
        $query = "SELECT date_created, total_orders, total_quantity, total_profit FROM order_statistics ORDER BY date_created";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Fetch the data
        $statistics = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return data as JSON
        echo json_encode($statistics);
    }

    public function updateOrderStatistics($order)
    {
        // Extract the order date
        $orderDate = date('Y-m-d', strtotime($order['created_at'])); // Assuming 'created_at' is in the order table
        $orderQuantity = $order['quantity']; // Assuming quantity field is available in the order table

        // Calculate the total profit by summing up the cart item prices
        $totalProfit = 0;

        // Fetch the cart items associated with the order (assumes 'cart_items' is a JSON column)
        $queryCartItems = "
        SELECT cart_items FROM orders WHERE ordercode = :ordercode
        ";
        $stmtCartItems = $this->db->prepare($queryCartItems);
        $stmtCartItems->bindParam(':ordercode', $order['ordercode'], PDO::PARAM_STR);
        $stmtCartItems->execute();

        // Fetch the cart_items (which is a JSON string in the database)
        $row = $stmtCartItems->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $cartItems = json_decode($row['cart_items'], true); // Decode the JSON to an array

            // Initialize total profit to 0
            $totalProfit = 0;
            $totalQuantity = 0;

            // Loop through each item in the cart and calculate the total profit
            foreach ($cartItems as $item) {
                if (isset($item['price']) && isset($item['quantity'])) {
                    $totalProfit += $item['price'] * $item['quantity']; // Nhân giá với số lượng
                    $totalQuantity += $item['quantity'];
                }
            }
            
        } else {
            $totalProfit = 0; // No cart items found, set profit to 0
            $totalQuantity = 0;
        }
        // Check if statistics already exist for the given date
        $queryCheck = "
        SELECT id FROM order_statistics WHERE date_created = :date_created
    ";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':date_created', $orderDate, PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Statistics exist, update them
            $queryUpdate = "
            UPDATE order_statistics
            SET 
                total_orders = total_orders + 1,
                total_quantity = total_quantity + :quantity,
                total_profit = total_profit + :profit
            WHERE date_created = :date_created
        ";
            $stmtUpdate = $this->db->prepare($queryUpdate);
            $stmtUpdate->bindParam(':date_created', $orderDate, PDO::PARAM_STR);
            $stmtUpdate->bindParam(':quantity', $totalQuantity, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':profit', $totalProfit, PDO::PARAM_STR);
            $stmtUpdate->execute();
        } else {
            // Statistics do not exist, insert new record
            $queryInsert = "
            INSERT INTO order_statistics (date_created, total_orders, total_quantity, total_profit)
            VALUES (:date_created, 1, :quantity, :profit)
        ";
            $stmtInsert = $this->db->prepare($queryInsert);
            $stmtInsert->bindParam(':date_created', $orderDate, PDO::PARAM_STR);
            $stmtInsert->bindParam(':quantity', $totalQuantity, PDO::PARAM_INT);
            $stmtInsert->bindParam(':profit', $totalProfit, PDO::PARAM_STR);
            $stmtInsert->execute();
        }
    }

    public function updateOrderafterCancel($ordercode, $data)
    {
        // Tạo truy vấn SQL để cập nhật
        $sql = "UPDATE orders SET status = :status WHERE ordercode = :ordercode";
    
        // Chuẩn bị truy vấn
        $stmt = $this->db->prepare($sql);
    
        // Gán giá trị
        $stmt->bindParam(':status', $data['status'], PDO::PARAM_INT);
        $stmt->bindParam(':ordercode', $ordercode, PDO::PARAM_STR);
    
        // Thực thi truy vấn
        return $stmt->execute();
    }
    
    public function updateShippingInfo($shipping_id, $shipping_name, $shipping_address, $shipping_phone, $shipping_note)
{
    // Truy vấn SQL để cập nhật thông tin người nhận hàng (customer shipping information)
    $query = "UPDATE shippings 
              SET name = :shipping_name, 
                  address = :shipping_address, 
                  phone = :shipping_phone,
                  note = :shipping_note
              WHERE shipping_id = :shipping_id";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':shipping_name', $shipping_name);
    $stmt->bindParam(':shipping_address', $shipping_address);
    $stmt->bindParam(':shipping_phone', $shipping_phone);
    $stmt->bindParam(':shipping_note', $shipping_note);
    $stmt->bindParam(':shipping_id', $shipping_id);

    return $stmt->execute();
}

}
