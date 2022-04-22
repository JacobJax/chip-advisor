<?php

require_once('../db/Database.php');
require_once('../models/PC.php');
require_once('../models/Retailer.php');

$db = new Database();
$conn = $db->connect();

?>
   <?php require_once("./header.php") ?>
   <?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>
   <?php $ret = new Retailer($conn); $rets = $ret->getRetailers(); ?>

   <section class="r-pc-container">
      <h3 style="text-align: center;">Retailers</h3>
      <table class="rpc-t t-users">
         <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Shop</th>
            <th>Email</th>
            <th>Action</th>
         </tr>
         <?php foreach($rets as $r) { ?>
            <tr>
               <td><?php echo $r['f_name'] ?></td>
               <td><?php echo $r['l_name'] ?></td>
               <td><?php echo $r['shop'] ?></td>
               <td><?php echo $r['email'] ?></td>
               <td>
                  <a href="#">Update</a>
                  <a href="#">Delete</a>
               </td>
            </tr>
         <?php }?>
      </table>

      <h3 style="text-align: center;">PCs</h3>
      <?php $pc = new PC($conn); $pcs = $pc->getPCs(); ?>
      <table class="rpc-t t-users">
         <tr>
            <th>#</th>
            <th>PC name</th>
            <th>Created on</th>
            <th>Created by:</th>
            <th>Specs:</th>
            <th>Action</th>
         </tr>
         <?php foreach($pcs as $r) { ?>
            <tr>
               <td><img src="..<?php echo $r['avatar'] ?>" style="width: 50px; height: 50px; object-fit: cover;"></td>
               <td><?php echo $r['name'] ?></td>
               <td><?php echo $r['created_on'] ?></td>
               <td><?php echo $r['created_by'] ?></td>
               <td style="text-align: left;"><?php echo "RAM: " . $r['ram'] . " HDD:" . $r['hdd'] . " SCREEN:" . $r['screen'] . " BODY:" . $r['body'] . " GRAPHICS:" . $r['graphics']?></td>
               <td>
                  <a href="#">Update</a>
                  <a href="#">Delete</a>
               </td>
            </tr>
         <?php }?>
      </table>
   </section>
</body>
</html>