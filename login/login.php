<?php

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

if(isset($_SESSION['uid'])) {
   session_destroy();
}

$errors = array(
   'pwd' => ''
);

function logIn($conn, $email, $pwd) {
   $query = "SELECT * FROM users WHERE email LIKE :email";

   $stmt = $conn->prepare($query);
   $stmt->bindValue(':email', $email);

   $stmt->execute();
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   return [
      'isLogged' => password_verify($pwd, $user['password']),
      'user' => $user
   ];
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

   $email = $_POST['email'];
   $pwd = $_POST['pwd'];

   $log = logIn($conn, $email, $pwd);

   if($log['isLogged']) {

      session_start();
      $_SESSION['uid'] = $log['user']['user_id'];
      $_SESSION['fname'] = $log['user']['f_name'];
      header('Location:../index.php');
      
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
            <label for="email">Email:</label><br>
            <input type="email" placeholder="Enter email" name="email" required><br>
            <label for="psw">Password:</label><br>
            <input type="password" placeholder="Enter Password" name="pwd" required><br>
            <input type="submit" value="Register">
            <br>
            <span><small>Dont have an account? click <a href="./register.php">Here</a> to register</small></span>
         </div>
      </form>
   </div>
   
</body>
</html>