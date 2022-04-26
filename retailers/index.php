<?php

require_once('../db/Database.php');
require_once('../models/PC.php');

$db = new Database();
$conn = $db->connect();

?>
   <?php require_once("./header.php") ?>
   <?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>
   <?php $pc = new PC($conn); $u_pc = $pc->getUserPCs($_SESSION['uid']); ?>

   <section class="r-pc-container">
      <?php if(!$u_pc) {?>
         <h2>No PCs Yet. <small>Click <a href="./add.php?id=<?php echo $_SESSION['uid'] ?>">Here</a> To add</small></h2>
      <?php } else {?>
         <?php foreach($u_pc as $pc) {?>
            <div class="r-pc">
               <div class="r-ill">
                  <img src="..<?php echo $pc['avatar']?>" alt="">
               </div>
               <div class="r-det">
                  <div class="r-det-top">
                     <?php if(!$pc['isActive']) {?>
                        <a href="specs.php?id=<?php echo $pc['pc_id'] ?>" class="btn">Activate</a>
                     <?php } else {?>
                        <p>Active</p>
                     <?php }?>
                     <p>
                        <small><a href="./editpc.php?pid=<?php echo $pc['pc_id'] ?>">Edit</a></small>
                        <small><a href="./delete.php?pid=<?php echo $pc['pc_id'] ?>">Delete</a></small>
                     </p>
                     <small><p>Created on: <?php echo $pc['created_on'] ?></p></small>
                  </div>
                  <div class="r-det-bottom">
                     <h3 class="pc-name"><?php echo $pc['name'] ?></h3>
                     <p><?php echo "RAM: " .$pc['ram'] . " | HDD: " . $pc['hdd'] . " | Screen: " . $pc['screen'] . " | " . $pc['body'] ?></p>
                     <p><?php echo "OS: " . $pc['os'] . " | Graphics: " . $pc['graphics'] . " | Graphics card: " . $pc['grDesc']  ?></p><br>
                     <p>Price: <strong><?php echo $pc['price'] ?></strong></p>
                  </div>
               </div>
            </div>
         <?php }?>
      <?php }?>

   </section>
</body>
</html>