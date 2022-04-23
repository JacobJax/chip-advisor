<?php
session_start();

require_once('./db/Database.php');
$db = new Database();
$conn = $db->connect();

function likePC($uid, $pid, $conn)
{
   $stmt = $conn->prepare("INSERT INTO likes (user_id, pc_id) VALUES (:uid, :pid)");
   $stmt->bindValue(':uid', $uid);
   $stmt->bindValue(':pid', $pid);

   return $stmt->execute();
}

if($_SERVER['REQUEST_METHOD'] === "POST")
{
   if(likePC($_SESSION['uid'], $_POST['pid'], $conn))
   {
      echo "Liked";
   } else {echo "Error";}
}