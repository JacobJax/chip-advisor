<?php require_once("./header.php") ?>
<?php

require_once('./db/Database.php');
$db = new Database();
$conn = $db->connect();

function getPCS($conn)
{
   $query = "SELECT * FROM pc LEFT JOIN specs ON pc.pc_id = specs.pcid WHERE pc.isActive = true";
   $stmt = $conn->prepare($query);
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
   <section>
      <div class="span-max jumbo">
         <div class="jumbo-head">
            <h1>Get the Best Recommendation and Deal that suits your need</h1>
            <div class="jumbo-links">
               <a href="#pcs" class="btn">Explore</a>
               <a href="./pcs/recommend.php" class="btn-g">Recommend a pc</a>
            </div>
         </div>
      </div>
   </section>

   <section class="pc-container span-max" id="pcs">
      <?php $pcs = getPCS($conn) ?>
      <?php foreach($pcs as $pc) {?>
         <div class="pc">
            <img src="./<?php echo $pc['avatar'] ?>">
            <div class="pc-details">
               <h4><?php echo $pc['name'] ?></h4>
               <p><?php echo "ram: " . $pc['ram'] . " | hdd: " . $pc['hdd'] . " | screen: " . $pc['screen'] . " | os: " . $pc['os'] . " | body: " . $pc['body'] ?></p>
               <div class="price">
                  <p>Price: Ksh<?php echo $pc['price'] ?></p>
               </div>
               <br>
               <div class="pc-action">
                  <?php if(!isset($_SESSION['uid'])){ ?>
                     <a href="./login/login.php" class="lb-btn sm-btn">❤ Like</a>
                  <?php } else { ?>
                     <a href="#" class="l-btn sm-btn">
                        <input type="hidden" name="pid" id="pid" value="<?php echo $pc['pc_id'] ?>">
                        <?php
                           if(checkLike($pc['pc_id'], $conn)){
                           echo "👍Liked"; 
                           } else {
                              echo "❤ Like";
                           }
                        ?>
                     </a>
                  <?php } ?>
                  <a href="./pcs/pc.php?pid=<?php echo $pc['pc_id'] ?>" class="v-btn sm-btn">💻 View</a>
               </div>
            </div>
         </div>
      <?php }?>
   </section>

</body>
</html>