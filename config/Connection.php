<?php

class Connection
{
    private $host = "localhost";
    private $dbname = "examples";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function connect()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            $this->conn = "error de conexion";
            echo "Error: " . $e->getMessage();
        }
    }
}
