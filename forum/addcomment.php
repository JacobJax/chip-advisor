<?php 

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {
   $post = $_POST['post'];

   $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (:pid, :id, :cp)");
   $stmt->bindValue(':pid', $_POST['pid']);
   $stmt->bindValue(':id', $_SESSION['uid']);
   $stmt->bindValue(':cp', $_POST['post']);

   $stmt->execute();

   echo $_POST['post'];
   // header('Location: ./index.php');
}

?>