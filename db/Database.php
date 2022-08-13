<?php
class Database{

   // DB PARAMS

   // local dev server
   private $conn;
   
   public function __construct() {
      $this->host = getenv('DB_HOST');
      $this->db = getenv('DB_NAME');
      $this->username = getenv('DB_USERNAME');
      $this->pwd = getenv('DB_PWD');
   }

   // DB CONNECT
   public function connect() {
      $this->conn = null;

      try {
         $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $pwd);
         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
         echo "An error occured: $e";
      }

      return $this->conn;
   }
}
?>
