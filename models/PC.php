<?php

class PC{
   
   private $conn;
   private $table  = "pc";

   private $name;
   private $ram;
   private $hdd;
   private $screen;
   private $os;
   private $body;
   private $graphics;
   private $grCard;
   private $grDesc;
   private $price;
   private $avt;

   public function __construct($db)
   {
      $this->conn = $db;
   }

   public function addPC(array $pcArray, $cid)
   {

      $this->name = $pcArray['name'];
      $this->avt = $pcArray['avt'];

      $query = "INSERT INTO " . $this->table . " (name, created_by, avatar)
      VALUES(:name, :cr, :avt)";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':name', $this->name);
      $stmt->bindValue(':cr', $cid);
      $stmt->bindValue(':avt', $this->avt);

      $stmt->execute();
   }

   public function addSpecs(array $specs, $id)
   {
      
      $this->ram = $specs['ram'];
      $this->hdd = $specs['hdd'];
      $this->screen = $specs['screen'];
      $this->os = $specs['os'];
      $this->body = $specs['body'];
      $this->graphics = $specs['gr'];
      $this->grCard = $specs['grCard'];
      $this->price = $specs['price'];
      $this->grDesc = $specs['grDesc'];

      $query = "INSERT INTO specs(pcid, ram, hdd, screen, os, body, graphics, grCard, grDesc, price) 
               VALUES(:id, :ram, :hdd, :scr, :os, :body, :gr, :grc, :grd, :price)";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->bindValue(':ram', $this->ram);
      $stmt->bindValue(':hdd', $this->hdd);
      $stmt->bindValue(':scr', $this->screen);
      $stmt->bindValue(':os', $this->os);
      $stmt->bindValue(':body', $this->body);
      $stmt->bindValue(':gr', $this->graphics);
      $stmt->bindValue(':grc', $this->grCard);
      $stmt->bindValue(':grd', $this->grDesc);
      $stmt->bindValue(':price', $this->price);

      $stmt->execute();    

      $this->changeActive($id);

   }

   public function getPCs()
   {
      $query = "SELECT * FROM `pc` LEFT JOIN `specs` ON pc.pc_id = specs.pcid
               ORDER BY created_on DESC";

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getPC($id)
   {
      $query = "SELECT * FROM `pc` LEFT JOIN `specs` ON pc.pc_id = specs.pcid
               WHERE pc_id = :id ORDER BY created_on DESC";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':id', $id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   private function update_name($id, $name)
   {
      $query = "UPDATE pc 
               SET name = :name
               WHERE pc_id = :id"
      ;

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue('id', $id);

      $stmt->execute();
   }
   private function update_specs($id, array $specs)
   {
      $this->ram = $specs['ram'];
      $this->hdd = $specs['hdd'];
      $this->screen = $specs['screen'];
      $this->os = $specs['os'];
      $this->body = $specs['body'];
      $this->graphics = $specs['gr'];
      $this->grCard = $specs['grCard'];
      $this->price = $specs['price'];
      $this->grDesc = $specs['grDesc'];

      $query = "UPDATE specs 
               SET ram = :ram,
               hdd = :hdd,
               screen = :scr,
               os = :os,
               body = :body,
               graphics = :gr,
               grCard = :grc,
               grDesc = :grd,
               price = :price
               WHERE pcid = :id"
      ;

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':ram', $this->ram);
      $stmt->bindValue(':hdd', $this->hdd);
      $stmt->bindValue(':scr', $this->screen);
      $stmt->bindValue(':os', $this->os);
      $stmt->bindValue(':body', $this->body);
      $stmt->bindValue(':gr', $this->graphics);
      $stmt->bindValue(':grc', $this->grCard);
      $stmt->bindValue(':grd', $this->grDesc);
      $stmt->bindValue(':price', $this->price);
      $stmt->bindValue(':id', $id);

      $stmt->execute();
   }

   public function updatePC($id, $name, array $specs)
   {
      $this->update_name($id, $name);
      $this->update_specs($id, $specs);
   }

   public function getUserPCs($uid)
   {
      $query = "SELECT * FROM `pc` LEFT JOIN `specs` ON pc.pc_id = specs.pcid
               WHERE pc.created_by = :uid ORDER BY created_on DESC";

      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':uid', $uid);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   private function changeActive($id)
   {
      $query = "UPDATE ". $this->table . " SET isActive = true WHERE pc_id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':id', $id);

      $stmt->execute();
   }

   public function delete_pc($id)
   {
      $query = "DELETE FROM ". $this->table . " WHERE pc_id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(':id', $id);

      $stmt->execute();
   }
}
