<?php

require_once('../db/Database.php');
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

function logIn($conn, $email, $pwd) {
   $query = "SELECT * FROM users WHERE email LIKE :email";

   $stmt = $conn->prepare($query);
   $stmt->bindValue(':email', $email);

   $stmt->execute();
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if(!$user) {
      return false;
   } else {
      return [
         'isLogged' => password_verify($pwd, $user['password']),
         'user' => $user
      ];
   } 
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

   $email = $_POST['email'];
   $pwd = $_POST['pwd'];

   $log = logIn($conn, $email, $pwd);
   // print_r(json_encode($log));

   if($log) {
      
      if ($log['isLogged']) {

         session_start();
         $_SESSION['uid'] = $log['user']['user_id'];
         $_SESSION['fname'] = $log['user']['f_name'];
         header('Location:../index.php');

      } else {
         $errors['pwd'] = 'Invalid Log in. Check email/password';
      }      
   } else {
      $errors['pwd'] = 'Invalid Log in. Check email/password';
   }  
}

?>

<?php require_once("./header.php") ?>

   <section class="span-max">
      <div class="det-form-container">
         <h3 style="text-align: center;">Log in</h3>
         <form action="login.php" method="post" class="det-form rounded-edge">
            <div class="container">
               <label for="err"><small style="color: red;"><?php echo $errors['pwd'] ?></small></label><br>
               <label for="email">Email:</label><br>
               <input type="email" class="rounded-edge" placeholder="Enter email" name="email" required value="<?php echo $email ?>"><br>
               <label for="psw">Password:</label><br>
               <input type="password" class="rounded-edge" placeholder="Enter Password" name="pwd" required value="<?php echo $pwd ?>"><br>
               <input type="submit" class="rounded-edge" value="Log in">
               <br>
               <span><small>Dont have an account? click <a href="./register.php">Here</a> to register</small></span>
            </div>
         </form>
      </div>
   </section>
   
</body>
</html>