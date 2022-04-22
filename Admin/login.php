<?php

require_once('../db/Database.php');
require_once('../models/Retailer.php');

$db = new Database();
$conn = $db->connect();

if(isset($_SESSION['uid'])) {
   session_destroy();
}

$email = "";
$pwd = "";

$errors = array(
   'pwd' => ''
);


if($_SERVER['REQUEST_METHOD'] === 'POST'){

   $email = $_POST['email'];
   $pwd = $_POST['pwd'];

   if ($email === "admin@chipadvisor.com" && $pwd = "Admin@123") {

      session_start();
      $_SESSION['uid'] = "001";
      $_SESSION['fname'] = "Admin 01";
      header('Location:./index.php');

   } else {
      $errors['pwd'] = 'Invalid Log in. Check email/password';
   }
      
 
   
}

?>

<?php require_once("./header.php") ?>

   <div class="det-form-container">
      <h3 style="text-align: center;">ADMIN Log in</h3>
      <br>
      <form action="login.php" method="post" class="det-form">
         <div class="container">
            <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
            <label for="email">Email:</label><br>
            <input type="email" placeholder="Enter email" name="email" required value="<?php echo $email ?>"><br>
            <label for="psw">Password:</label><br>
            <input type="password" placeholder="Enter Password" name="pwd" required value="<?php echo $pwd ?>"><br>
            <input type="submit" value="Log in">
            <br>
         </div>
      </form>
   </div>
   
</body>
</html>