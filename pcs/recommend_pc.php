<?php

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function get_pc_arr($conn, $oc_id, $price)
{
   $query = "SELECT likes.user_id, 
            ocupation.occ_desc, 
            likes.pc_id, 
            pc.name, 
            pc.avatar,
            specs.ram, 
            specs.hdd, 
            specs.screen, 
            specs.os, 
            specs.body, 
            specs.graphics, 
            specs.price FROM likes 
            LEFT JOIN users ON likes.user_id = users.user_id 
            LEFT JOIN ocupation on users.occ_id = ocupation.occ_id 
            LEFT JOIN pc ON likes.pc_id = pc.pc_id 
            LEFT JOIN specs ON likes.pc_id = specs.pcid 
            WHERE ocupation.occ_id = :id AND specs.price <= :price
            GROUP BY likes.pc_id"
   ;

   $stmt = $conn->prepare($query);
   $stmt->bindValue(':id', $oc_id);
   $stmt->bindValue(':price', $price);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

if($_SERVER["REQUEST_METHOD"] === "POST")
{
   $result = json_encode(get_pc_arr($conn, $_POST['occ'], $_POST['price']));
   echo $result;
}

?>