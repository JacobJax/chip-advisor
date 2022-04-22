<?php

require_once('../db/Database.php');
require_once('../models/Retailer.php');
$db = new Database();
$conn = $db->connect();


// error checking
$fname = "";
$lname = "";
$email = "";
$shop = "";
$pwd = "";
$cpwd = "";

$errors = [
   'fname' => "",
   'lname' => "",
   'email' => "",
   'pwd' => "",
   'pwd1' => "",
   'shop' => ""
];

// add data to database
if($_SERVER['REQUEST_METHOD'] === 'POST') {

   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $shop = $_POST['shop'];
   $pwd = $_POST['pwd'];
   $cpwd = $_POST['cpwd'];

   // handle user input errors
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Invalid email address";
   }
   if(!preg_match("/^[a-z ,.'-]+$/i", $fname)){
      $errors['fname'] = "Invalid name entry";
   }
   if(!preg_match("/^[a-z ,.'-]+$/i", $shop)){
      $errors['shop'] = "Invalid shop entry";
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
      $rArray = [
         'fname' => $fname,
         'lname' => $lname,
         'shop' => $shop,
         'email' => $email,
         'pwd' => $pwd
      ];

      $retailer = new Retailer($conn);
      $retailer->addRetailer($rArray);

      header('Location: login.php');
   }
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
            <label for="err"><small style="color: red;"><?php echo $errors['fname'] ?></small></label><br>
            <label for="lname">Last name:</label><br>
            <input type="text" placeholder="Enter last name" name="lname" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['lname'] ?></small></label><br>
            <label for="email">Email:</label><br>
            <input type="email" placeholder="Enter email" name="email" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['email'] ?></small></label><br>
            <label for="email">Shop:</label><br>
            <input type="text" placeholder="Enter shop" name="shop" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['shop'] ?></small></label><br>
            <label for="psw">Password:</label><br>
            <input type="password" placeholder="Enter Password" name="pwd" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
            <label for="psw">Confirm password:</label><br>
            <input type="password" placeholder="Confirm Password" name="cpwd" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['pwd1'] ?></small></label><br>

            <input type="submit" value="Register">
            <br>

            <span><small>Already have an account? click <a href="./login.php">Here</a> to log in</small></span>
         </div>
      </form>
   </div>

   
</body>
</html>