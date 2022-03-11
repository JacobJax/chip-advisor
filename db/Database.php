<?php
class Database{

   // DB PARAMS

   // local dev server
   private $host = 'localhost';
   private $db = 'chip_advisor';
   private $username = 'root';
   private $pwd = '';
   private $conn;

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