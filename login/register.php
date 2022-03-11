<?php

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function getGender($conn) {

   $stmt = $conn->prepare("SELECT * FROM gender");
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
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

$gns = getGender($conn);
$lcts = getLocation($conn);
$occ = getOcc($conn);

// add data to database
if($_SERVER['REQUEST_METHOD'] === 'POST') {

   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $gnd = $_POST['gnd'];
   $lcn = $_POST['lcn'];
   $occ = $_POST['occ'];
   $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);

   $query = "INSERT INTO users (f_name, l_name, location_id, gender_id, occ_id, email, password)
            VALUES (:fname, :lname, :lcn, :gnd, :occ, :email, :pwd)";

   $stmt = $conn->prepare($query);
   $stmt->bindValue(':fname', $fname);
   $stmt->bindValue(':lname', $lname);
   $stmt->bindValue(':lcn', $lcn);
   $stmt->bindValue(':gnd', $gnd);
   $stmt->bindValue(':occ', $occ);
   $stmt->bindValue(':email', $email);
   $stmt->bindValue(':pwd', $pwd);

   $stmt->execute();

   header('Location: login.php');
}

?>

<?php require_once("./header.php") ?>

   <div class="det-form-container">
      <h3 style="text-align: center;">Sign up</h3>
      <br>
      <form action="register.php" method="post" class="det-form">
         <div class="container">
            <label for="uname">First name:</label><br>
            <input type="text" placeholder="Enter first name" name="fname" required><br>
            <label for="lname">Last name:</label><br>
            <input type="text" placeholder="Enter last name" name="lname" required><br>
            <label for="email">Email:</label><br>
            <input type="email" placeholder="Enter email" name="email" required><br>
            <div class="lng">
               <div class="gn">
                  <label for="p-age">Gender:</label><br>
                  <select class="form-control" name="gnd" style="height: 30px; width: 170px; margin: 10px 0;">
                     <?php foreach($gns as $type) { ?>
                              <option value=<?php echo $type["gender_id"] ?> ><?php echo $type["gender_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="ln">
                  <label for="p-age">Location:</label><br>
                  <select class="form-control" name="lcn" style="height: 30px; width: 170px; margin: 10px 0;">
                     <?php foreach($lcts as $type) { ?>
                              <option value=<?php echo $type["location_id"] ?> ><?php echo $type["location_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
            <label for="p-age">Select occupation:</label><br>
            <select class="form-control" name="occ" style="height: 30px; width: 100%; margin: 10px 0;">
               <?php foreach($occ as $type) { ?>
                  <option value=<?php echo $type["occ_id"] ?> ><?php echo $type["occ_desc"] ?></option>
               <?php } ?>
            </select><br>
            <label for="psw">Password:</label><br>
            <input type="password" placeholder="Enter Password" name="pwd" required><br>
            <label for="psw">Confirm password:</label><br>
            <input type="password" placeholder="Confirm Password" name="cpwd" required><br>

            <input type="submit" value="Register">
            <br>

            <span><small>Already have an account? click <a href="./login.php">Here</a> to log in</small></span>
         </div>
      </form>
   </div>

   
</body>
</html>