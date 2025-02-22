<?php
require_once __DIR__ . '/Database.php';
class Model extends Database
{
    protected $table;

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
