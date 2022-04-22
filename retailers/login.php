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

   // echo $pwd;

   $retailer = new Retailer($conn);
   $log = $retailer->logIn($email, $pwd);

   // print_r(json_encode($log));

   if($log) {

      if ($log['isLogged']) {
         session_start();
         $_SESSION['uid'] = $log['user']['retailer_id'];
         $_SESSION['fname'] = $log['user']['f_name'];
         header('Location:./index.php');
      } else {
         $errors['pwd'] = 'Invalid Log in. Check email/password';
      }
      
   } else {
      $errors['pwd'] = 'Invalid Log in. Check email/password';
   }
   
}

?>

<?php require_once("./header.php") ?>

   <div class="det-form-container">
      <h3 style="text-align: center;">Log in</h3>
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
            <span><small>Dont have an account? click <a href="./register.php">Here</a> to register</small></span>
         </div>
      </form>
   </div>
   
</body>
</html>