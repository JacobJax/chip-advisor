<?php
class Database{

   // DB PARAMS

   // local dev server
   $host = getenv('DB_HOST');
   $db = getenv('DB_NAME');
   $username = getenv('DB_USERNAME');
   $pwd = getenv('DB_PWD');
   private $conn;

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
