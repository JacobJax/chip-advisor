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


// error checking
$fname = "";
$lname = "";
$email = "";

$pwd = "";
$cpwd = "";

$errors = [
   'fname' => "",
   'lname' => "",
   'email' => "",
   'pwd' => "",
   'pwd1' => ""
];

// add data to database
if($_SERVER['REQUEST_METHOD'] === 'POST') {

   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $gnd = $_POST['gnd'];
   $lcn = $_POST['lcn'];
   $occ = $_POST['occ'];
   $pwd = $_POST['pwd'];
   $cpwd = $_POST['cpwd'];

   // handle user input errors
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Invalid email address";
   }
   if(!preg_match("/^[a-z ,.'-]+$/i", $fname)){
      $errors['fname'] = "Invalid name entry";
   }
   if(!preg_match("/^[a-z ,.'-]+$/i", $lname)){
      $errors['lname'] = "Invalid name entry";
   }
   if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $pwd)) {
         $errors['pwd'] = "Password must contain 8 or characters, capital letters and special characters";
   }
   if($cpwd !== $pwd) {
         $errors['pwd1'] = "Passwords do not match";
   }


   if(!array_filter($errors)) {
      $query = "INSERT INTO users (f_name, l_name, location_id, gender_id, occ_id, email, password)
            VALUES (:fname, :lname, :lcn, :gnd, :occ, :email, :pwd)";

      $stmt = $conn->prepare($query);
      $stmt->bindValue(':fname', $fname);
      $stmt->bindValue(':lname', $lname);
      $stmt->bindValue(':lcn', $lcn);
      $stmt->bindValue(':gnd', $gnd);
      $stmt->bindValue(':occ', $occ);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':pwd', password_hash($pwd, PASSWORD_DEFAULT));

      $stmt->execute();

      header('Location: login.php');
   }
}

?>

<?php require_once("./header.php") ?>

   <div class="det-form-container">
      <h3 style="text-align: center;">Sign up</h3>
      <form action="register.php" method="post" class="det-form">
         <div class="container">
            <label for="uname">First name:</label><br>
            <input type="text" class="rounded-edge" placeholder="Enter first name" name="fname" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['fname'] ?></small></label><br>
            <label for="lname">Last name:</label><br>
            <input type="text" class="rounded-edge" placeholder="Enter last name" name="lname" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['lname'] ?></small></label><br>
            <label for="email">Email:</label><br>
            <input type="email" class="rounded-edge" placeholder="Enter email" name="email" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['email'] ?></small></label><br>
            <div class="lng">
               <div class="gn">
                  <label for="p-age">Gender:</label><br>
                  <select class="form-control rounded-edge" name="gnd" style="height: 30px; width: 170px; margin: 10px 0;">
                  <?php $gns = getGender($conn); ?>
                     <?php foreach($gns as $type) { ?>
                        <option value=<?php echo $type["gender_id"] ?> ><?php echo $type["gender_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="ln">
                  <label for="p-age">Location:</label><br>
                  <select class="form-control rounded-edge" name="lcn" style="height: 30px; width: 170px; margin: 10px 0;">
                     <?php $lcts = getLocation($conn); ?>
                     <?php foreach($lcts as $type) { ?>
                        <option value=<?php echo $type["location_id"] ?> ><?php echo $type["location_desc"] ?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
            <label for="p-age">Select occupation:</label><br>
            <select class="form-control rounded-edge" name="occ" style="height: 30px; width: 100%; margin: 10px 0;">
               <?php $occ = getOcc($conn); ?>
               <?php foreach($occ as $type) { ?>
                  <option value=<?php echo $type["occ_id"] ?> ><?php echo $type["occ_desc"] ?></option>
               <?php } ?>
            </select><br>
            <label for="psw">Password:</label><br>
            <input type="password" class="rounded-edge" placeholder="Enter Password" name="pwd" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
            <label for="psw">Confirm password:</label><br>
            <input type="password" class="rounded-edge" placeholder="Confirm Password" name="cpwd" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['pwd1'] ?></small></label><br>

            <input type="submit" class="rounded-edge" value="Register">
            <br>

            <span><small>Already have an account? click <a href="./login.php">Here</a> to log in</small></span>
         </div>
      </form>
   </div>

   
</body>
</html>