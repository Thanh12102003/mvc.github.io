<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "webbanhang";
    public $conn;

    public function __construct()
    {
        // Set the DSN (Data Source Name) for MySQL
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";

        // Try to establish a PDO connection
        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // If there's a connection error, show the message
            die("Connection failed: " . $e->getMessage());
        }
    }
}
