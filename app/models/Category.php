<?php
require_once ROOT . '/system/Database.php';
class Category
{
    // Database connection
    private $db;

    public function __construct()
    {

        $this->db = (new Database())->conn;
    }
    public function getCategoryProductsById($id)
    {
        try {
            // SQL query to fetch products by category ID
            $query = "SELECT p.* 
                      FROM products p
                      INNER JOIN categories c ON p.category_id = c.id
                      WHERE c.id = :category_id";

            // Prepare the statement
            $stmt = $this->db->prepare($query);

            // Bind the category ID parameter
            $stmt->bindParam(':category_id', $id, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch all products as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Error fetching products by category: " . $e->getMessage());
            return [];
        }
    }

    // Fetch all categories
    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return categories as an associative array
    }

    // Get a category by ID
    public function getCategoryById($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to create a new category in the database
    public function createCategory($name, $description)
    {
        // Prepare the SQL query
        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        // Execute the query and return the result
        return $stmt->execute();
    }

    // Method to update a category
    public function updateCategory($id, $name, $description)
    {
        $query = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    // Method to delete a category
    public function deleteCategory($id)
    {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
