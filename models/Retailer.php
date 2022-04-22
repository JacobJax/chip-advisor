<?php

class Retailer{

   private $conn;
   private $table = "retailers";

   private $fname;
   private $lname;
   private $shop;
   private $email;
   private $password;

   public function __construct($db)
   {
      $this->conn = $db;
   }

   public function addRetailer(array $rArray) {

      $this->fname = $rArray['fname'];
      $this->lname = $rArray['lname'];
      $this->shop = $rArray['shop'];
      $this->email = $rArray['email'];
      $this->password = password_hash($rArray['pwd'], PASSWORD_DEFAULT);

      $query = "INSERT INTO " . $this->table . "(f_name, l_name, email, password, shop)
               VALUES (:fname, :lname, :email, :pwd, :shop)";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':fname', $this->fname);
      $stmt->bindValue(':lname', $this->lname);
      $stmt->bindValue(':email', $this->email);
      $stmt->bindValue(':pwd', $this->password);
      $stmt->bindValue(':shop', $this->shop);

      $stmt->execute();
   }

   public function logIn($email, $pwd) {
      $query = "SELECT * FROM ". $this->table . " WHERE email LIKE :email";
   
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':email', $email);
   
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
   
      if(!$user) {
         return false;
      } else {
         return [
            'isLogged' => password_verify($pwd, $user['password']),
            'user' => $user
         ];
      } 
   }

   public function getRetailers(){
      $query = "SELECT * FROM ". $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getRetailer($id){

      $query = "SELECT * FROM ". $this->table . " WHERE retailer_id = :id";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
   }
}