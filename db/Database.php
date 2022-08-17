<?php
class Database{

   // DB PARAMS

   // local dev server
   private $host;
   private $db;
   private $username;
   private $pwd;
   private $conn;
   
   public function __construct() {
      //$this->host = getenv('DB_HOST');
      //$this->db = getenv('DB_NAME');
      //$this->username = getenv('DB_USERNAME');
      //$this->pwd = getenv('DB_PWD');

      $this->host = "localhost";
      $this->db = "chip_advisor";
      $this->username = "root";
      $this->pwd = "";
   }

   // DB CONNECT
   public function connect() {
      $this->conn = null;

      try {
         $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->username, $this->pwd);
         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
         echo "An error occured: $e";
      }

      return $this->conn;
   }
}
?>
