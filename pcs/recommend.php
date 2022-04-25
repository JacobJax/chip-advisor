<?php include_once('./header.php') ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ../login/login.php'); } ?>

<?php 

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function getLocation($conn) {

   $stmt = $conn->prepare("SELECT * FROM location");
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
function getOcc($conn) {

   $stmt = $conn->prepare("SELECT * FROM ocupation");
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

?>

   <div class="det-form-container">
      <h3 style="text-align: center;">Recommend PC</h3>
      <br>
      <form class="det-form" id="rc-form">
         <div class="container">
            <label for="uname">Whats your budget:</label><br><br>
            <input type="number" placeholder="Amount you're willing to spend" name="price" required style="width: 100%; height: 30px; padding: 5px"><br><br>
            <div class="lng" style="gap: 10px;">
               <div class="ln">
                  <label for="p-age" style="font-size: 13px;">What's Your Current Location:</label><br>
                  <select class="form-control" name="lcn" style="height: 30px; width: 170px; margin: 10px 0;">
                     <?php $lcts = getLocation($conn); ?>
                     <?php foreach($lcts as $type) { ?>
                        <option value=<?php echo $type["location_id"] ?> ><?php echo $type["location_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="occ">
                  <label for="p-age" style="font-size: 13px;">What best describes your occupation:</label><br>
                  <select class="form-control" name="occ" style="height: 30px; width: 100%; margin: 10px 0;">
                     <?php $occ = getOcc($conn); ?>
                     <?php foreach($occ as $type) { ?>
                        <option value=<?php echo $type["occ_id"] ?> ><?php echo $type["occ_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
            <br>
            <input type="submit" value="Recommend">
            <br>
         </div>
      </form>
   </div>
   <details>
      <summary id="pcs-v" style="color: blue; cursor:pointer; text-align: center;"></summary>
      <section class="pc-container" id="pc-v">

      </section>
   </details>
</body>
</html>