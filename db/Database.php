<?php
class Database{

   // DB PARAMS

   // local dev server
   private $host = getenv('DB_HOST');
   private $db = getenv('DB_NAME');
   private $username = getenv('DB_USERNAME');
   private $pwd = getenv('DB_PWD');
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
