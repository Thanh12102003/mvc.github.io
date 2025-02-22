<?php
require_once ROOT . '/system/Database.php';

class Customer
{
    // Database connection
    private $db;

    public function __construct()
    {

        $this->db = (new Database())->conn;
    }

    public function queryLogin($username, $hashedPassword)
    {
        try {
            // Prepare SQL query to fetch user by username and hashed password
            $query = "SELECT * FROM customers WHERE username = :username AND customer_password = :customer_password";
            $stmt = $this->db->prepare($query);

            // Bind the parameters
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':customer_password', $hashedPassword, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();

            // Fetch the user record
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error and return false
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    public function createCustomer($username, $customer_password, $backup_password, $customer_status)
    {
        // Prepare the SQL query
        $query = "INSERT INTO customers (username, customer_password , backup_password, customer_status)
         VALUES (:username, :customer_password, :backup_password, :customer_status)";
        $stmt = $this->db->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':customer_password', $customer_password);
        $stmt->bindParam(':backup_password', $backup_password);
        $stmt->bindParam(':customer_status', $customer_status);

        // Execute the query and return the result
        return $stmt->execute();
    }
}
