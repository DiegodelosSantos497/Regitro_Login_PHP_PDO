<?php
require_once(__DIR__ . '/../config/Connection.php');

class UserModel extends Connection
{
    private  $id, $name, $email, $password, $image;
    private $table = "users";
    private  $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function getUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getElementById($id)
    {
        $this->id = $id;
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id ");
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function add($name, $email, $password, $image)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
        $stmt = $this->conn->prepare("INSERT INTO $this->table(name, email, password, image) VALUES(:name, :email, :password, :image)");
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $this->password, PDO::PARAM_STR);
        $stmt->bindValue(":image", $this->image, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->id = $id;
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($name, $email, $password, $image, $id)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
        $this->id = $id;
        $stmt = $this->conn->prepare("UPDATE $this->table SET name = :name, email = :email, password = :password, image = :image WHERE id = :id");
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":email",  $this->email, PDO::PARAM_STR);
        $stmt->bindValue(":password",  $this->password, PDO::PARAM_STR);
        $stmt->bindValue(":image",  $this->image, PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        $this->email = $email;
        $this->password = sha1($password);
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = :email AND password = :password");
        $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $this->password, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
