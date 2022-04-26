<?php

require_once('../db/Database.php');
// require_once('../models/PC.php');
require_once('../models/Retailer.php');

$db = new Database();
$conn = $db->connect();

?>

<?php require_once("./header.php") ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>

<section class="r-pc-container">
   <?php $ret = new Retailer($conn); $rets = $ret->getRetailers(); ?>
   <h3 style="text-align: center;">Retailers <a href="./retailers.php" onclick="window.open(this.href).print(); return false" class="btn" style="font-size: 13px;">Generate report</a></h3><br><br>
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
</section>

</body>
</html>