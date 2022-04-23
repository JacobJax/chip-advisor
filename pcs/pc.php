<?php include_once "./header.php" ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ../login/login.php'); } ?>

<?php
require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function getPC($pid, $conn)
{
   $query = "SELECT * FROM pc 
            LEFT JOIN specs ON pc.pc_id = specs.pcid 
            LEFT JOIN users ON pc.created_by = users.user_id 
            WHERE pc.pc_id = :pid AND pc.isActive = true
   ";
   $stmt = $conn->prepare($query);
   $stmt->bindValue(':pid', $pid);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkLike($pid, $conn)
{
   $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = :id AND pc_id = :pid");
   $stmt->bindValue(':id', $_SESSION['uid']);
   $stmt->bindValue(':pid', $pid);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php $pcs = getPC($_GET['pid'], $conn) ?>
<?php foreach($pcs as $pc) {?>
   <br>
<div class="pc" style="margin: auto; width: 50%; height: 60%;">
   <img src="../<?php echo $pc['avatar'] ?>">
   <div class="pc-details">
      <h4><?php echo $pc['name'] ?></h4>
      <p><?php echo "ram: " . $pc['ram'] . " | hdd: " . $pc['hdd'] . " | screen: " . $pc['screen'] . " | os: " . $pc['os'] . " | body: " . $pc['body'] ?></p>
      <div class="price">
         <p>Price: <?php echo $pc['price'] ?></p>
      </div>
      <br>
      <div class="pc-action">
         <a href="#" class="l-btn">
            <input type="hidden" name="pid" id="pid" value="<?php echo $pc['pc_id'] ?>">
            <?php
               if(!isset($_SESSION['uid'])){ 
                  echo "❤Like";
               } else { 
                  if(checkLike($pc['pc_id'], $conn)){
                  echo "👍Liked"; 
                  } else {
                     echo "❤Like";
                  }
               } 
            ?>
         </a>
         <a href="mailto:<?php echo $pc['email'] ?>" class="v-btn">📞Contact retailer</a>
      </div>
   </div>
</div>
<?php }?>

</body>
</html>