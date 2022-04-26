<?php

require_once('../db/Database.php');
require_once('../models/PC.php');
$db = new Database();
$conn = $db->connect();

$pc = new PC($conn);

if(isset($_GET['pid'])) 
{
   $pc->delete_pc($_GET['pid']);
   header('Location: ./index.php');
}

?>