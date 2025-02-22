<?php
require_once ROOT . '/system/Database.php';
class Product
{
    // Database connection
    private $db;

    public function __construct()
    {

        $this->db = (new Database())->conn;
    }
    // Read all products
    public function getAllProducts()
    {
        $query = "
    SELECT 
        products.*, 
        categories.name AS category_name 
    FROM 
        products 
    INNER JOIN 
        categories 
    ON 
        products.category_id = categories.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createProduct($name, $price, $description, $category_id, $imagePath, $original_price)
    {
        $query = "INSERT INTO products (name, price, description, category_id, image, original_price) 
              VALUES (:name, :price, :description, :category_id, :image,:original_price)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':original_price', $original_price);

        return $stmt->execute();
    }
    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateProduct($id, $name, $price, $description, $category_id, $imagePath = null, $original_price)
    {
        $query = "
        UPDATE products 
        SET 
            name = :name, 
            price = :price, 
            original_price = :original_price, 
            description = :description, 
            category_id = :category_id" .
            ($imagePath ? ", image = :image" : "") . " 
        WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':original_price', $original_price);

        if ($imagePath) {
            $stmt->bindParam(':image', $imagePath);
        }

        return $stmt->execute();
    }

    // Method to delete a
    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // Method to get related products based on the category ID
    public function getRelatedProductById($id)
    {
        // Get the category of the current product
        $product = $this->getProductById($id);
        if ($product) {
            $categoryId = $product['category_id'];

            // Now, fetch related products in the same category
            $query = "SELECT * FROM products WHERE category_id = :category_id AND id != :id LIMIT 4"; // You can adjust the limit as needed
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return []; // If no product is found, return an empty array
    }
}
