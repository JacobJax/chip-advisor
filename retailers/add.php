<?php

require_once('../db/Database.php');
require_once('../models/PC.php');
$db = new Database();
$conn = $db->connect();


// error checking
$name = "";

$errors = [
   'name' => ""
];

// add data to database
if($_SERVER['REQUEST_METHOD'] === 'POST') {

   $name = $_POST['name'];

   // handle user input errors
   // if(!preg_match("/^[a-z ,.'-]+$/i", $name)){
   //    $errors['name'] = "Invalid name entry";
   // }

   if(!array_filter($errors)) {

      // handle image upload   
      $valid_ext = ['jpg', 'jpeg', 'png'];
      $file = $_FILES['ill'];

      $fileName = $file['name'];
      $fileTmpDes = $file['tmp_name'];
      $fileError = $file['error'];

      $fileExt = explode('.', $fileName);
      $actualFileExt = strtolower(end($fileExt));

      $fileNewName = uniqid('', true) . '.' . $actualFileExt;
      $destination = "../img/" . $fileNewName;
      $poster = $destination;
      move_uploaded_file($fileTmpDes, $destination); 

      $rArray = [
         'name' => $name,
         'avt' => "/img/" . $fileNewName
      ];

      // add to database
      $pc = new PC($conn);
      $pc->addPC($rArray, $_GET['id']);

      header('Location: ./index.php');
   }
}

?>

<?php require_once("./header.php") ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>


   <div class="det-form-container">
      <h3 style="text-align: center;">Add pc</h3>
      <br>
      <form action="" enctype="multipart/form-data" method="post" class="det-form">
         <div class="container">
            <label for="uname">PC name:</label><br>
            <input type="text" placeholder="Enter pc name" name="name" required><br>
            <label for="err"><small style="color: red;"><?php echo $errors['name'] ?></small></label><br>
            <label for="lname">PC image:</label>
            <input type="file" placeholder="Enter last name" name="ill" required><br><br>
            <!-- <label for="err"><small style="color: red;"><?php echo $errors['lname'] ?></small></label><br> -->

            <input type="submit" value="Create">
            <br>
         </div>
      </form>
   </div>

   
</body>
</html>