<?php
//code from codingcage.com
class Database
{
     
    private $host = "local";
    private $db_name = "dbname";
    private $username = "root";
    private $password = "";
    public $conn;
     
    public function dbConnection()
    {     
     $this->conn = null;    
     try
     {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //throw
     }
     catch(PDOException $exception)
     {
        echo "Connection error: " . $exception->getMessage();
     }
     
     //echo "connected"; //test connection
     return $this->conn;
    }
}
?>