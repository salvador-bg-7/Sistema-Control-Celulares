<?php
class Model
{
    protected $db;

    public function lastInsertId() {
    return $this->db->lastInsertId();
}

    public function __construct()
    {
        require_once APP_ROOT . '/config/database.php';
        $database = new Database();
        $this->db = $database->connect();
    }


   



}

