<?php
require_once ROOT . '/system/Database.php';
class Shipping
{
    // Database connection
    private $db;

    public function __construct()
    {

        $this->db = (new Database())->conn;
    }
    public function getShippingByUserId($user_id)
    {
        $query = "
            SELECT *
            FROM shippings
            WHERE user_id = :user_id
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
        }

        return null; // Return null if no record is found
    }
    public function updateShipping($user_id, $shippingData)
    {
        // Check if shipping data already exists for the user
        $queryCheck = "SELECT id FROM shippings WHERE user_id = :user_id";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Shipping data exists, update it
            $queryUpdate = "
        UPDATE shippings
        SET 
            address = :address,
            phone = :phone,
            name = :name,
            note = :note
            
        WHERE user_id = :user_id
    ";
            $stmtUpdate = $this->db->prepare($queryUpdate);
        } else {
            // Shipping data does not exist, insert new record
            $queryInsert = "
        INSERT INTO shippings (
            user_id, name, phone, note, address
        ) VALUES (
            :user_id, :name, :phone, :note, :address
        )
    ";
            $stmtUpdate = $this->db->prepare($queryInsert);
        }

        // Bind parameters
        $stmtUpdate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':note', $shippingData['note'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':address', $shippingData['address'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':phone', $shippingData['phone'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':name', $shippingData['name'], PDO::PARAM_STR);

        // Execute and return the result
        return $stmtUpdate->execute();
    }
}
