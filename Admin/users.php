<?php require_once("./header.php") ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>

<?php

require_once('../db/Database.php');

$db = new Database();
$conn = $db->connect();

function get_users($conn)
{
   $query = "SELECT users.user_id, 
            users.f_name, 
            users.l_name, 
            location.location_desc, 
            gender.gender_desc, 
            ocupation.occ_desc, 
            users.email FROM `users` 
            LEFT JOIN location ON users.location_id = location.location_id 
            LEFT JOIN gender ON users.gender_id = gender.gender_id 
            LEFT JOIN ocupation ON users.occ_id = ocupation.occ_id"
   ;

   $stmt = $conn->prepare($query);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<section class="r-pc-container">
   <?php $rets = get_users($conn); ?>
   <h3 style="text-align: center;">Users <a href="./users.php" onclick="window.open(this.href).print(); return false" class="btn" style="font-size: 13px;">Generate report</a></h3><br><br>
   <table class="rpc-t t-users">
      <tr>
         <th>First name</th>
         <th>Last name</th>
         <th>Gender</th>
         <th>Location</th>
         <th>Occupation</th>
         <th>Email</th>
         <th>Action</th>
      </tr>
      <?php foreach($rets as $r) { ?>
         <tr>
            <td><?php echo $r['f_name'] ?></td>
            <td><?php echo $r['l_name'] ?></td>
            <td><?php echo $r['gender_desc'] ?></td>
            <td><?php echo $r['location_desc'] ?></td>
            <td><?php echo $r['occ_desc'] ?></td>
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