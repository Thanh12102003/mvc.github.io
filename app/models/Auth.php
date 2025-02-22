<?php
require_once ROOT . '/system/Database.php';

class Auth
{
    // Database connection
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = (new Database())->conn;
    }
    // Add a new user to the database
    public function addUser($username, $password)
    {
        // SQL query to insert a new user
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";

        // Prepare the query
        $stmt = $this->db->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Execute the query and return the result
        return $stmt->execute();
    }

    // Get user details by user ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user details by user ID
    public function updateUserById($id, $username, $password = null)
    {
        if ($password) {
            // If password is provided, include it in the update
            $query = "
            UPDATE users 
            SET username = :username,  password = :password 
            WHERE id = :id
        ";
        } else {
            // If no password is provided, update only the username and email
            $query = "
            UPDATE users 
            SET username = :username
            WHERE id = :id
        ";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($password) {
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }
    public function getAllUsers()
    {
        // SQL query to select all users from the database
        $query = "SELECT * FROM users";

        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Fetch all users
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fetch user and validate login credentials using MD5
    public function queryLogin($username, $password)
    {
        // Prepare SQL query to fetch user by username
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);

        // Bind the username parameter to the query
        $stmt->bindParam(1, $username, PDO::PARAM_STR); // Use position 1 for binding in PDO

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if ($user) {
            // Compare the MD5 password stored in the database with the MD5 hash of the input password
            if (md5($password) === $user['password']) {
                // Password is correct, return user data (or session setup)
                return $user;
            } else {
                // Invalid password
                return false;
            }
        } else {
            // No user found with that username
            return false;
        }
    }
}
