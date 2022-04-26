<?php require_once("./header.php") ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>

<?php

require_once('../db/Database.php');
require_once('../models/PC.php');
$db = new Database();
$conn = $db->connect();

$pc = new PC($conn);
$pc_arr = $pc->getPC($_GET['pid']);


// error checking
$ram = "";
$hdd = "";
$screen = "";
$os = "";
$body = "";
$gr = "";
$grCard = "";
$grDesc = "";
$price = "";

$errors = [
   'ram' => "",
   'hdd' => "",
   'screen' => "",
   'os' => "",
   'body' => "",
   'gr' => "",
   'grCard' => "",
   'grDesc' => "",
   'price' => ""
];

// add data to database
if($_SERVER['REQUEST_METHOD'] === 'POST') {

   $name = $_POST['name'];

   $rArray = [
      'ram' => $_POST['ram'],
      'hdd' => $_POST['hdd'],
      'screen' => $_POST['screen'],
      'os' => $_POST['os'],
      'body' => $_POST['body'],
      'gr' => $_POST['gr'],
      'grCard' => $_POST['grCard'],
      'grDesc' => isset($_POST['grDesc']) ? $_POST['grDesc'] : "None",
      'price' => $_POST['price']
   ];

   // add to database
   
   $pc->updatePC($_GET['pid'], $name, $rArray);

   header('Location: ./index.php');
   
}

?>
   <div class="det-form-container">
      <h3 style="text-align: center;">Edit pc details</h3>
      <br>
      <form action="" enctype="multipart/form-data" method="post" class="det-form">
         <div class="container">  
            <label for="uname">Name:</label><br>
            <input type="text" placeholder="Enter pc name" name="name" required value="<?php echo $pc_arr['name'] ?>"><br>
            <label for="uname">RAM:</label><br>
            <input type="text" placeholder="Enter pc RAM" name="ram" required value="<?php echo $pc_arr['ram'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['ram'] ?></small></label><br>
            <label for="uname">HDD:</label><br>
            <input type="text" placeholder="Enter HDD" name="hdd" required value="<?php echo $pc_arr['hdd'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['hdd'] ?></small></label><br>
            <label for="uname">Screen:</label><br>
            <input type="text" placeholder="Enter Screen size" name="screen" required value="<?php echo $pc_arr['screen'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['screen'] ?></small></label><br>
            <label for="uname">Operating System:</label><br>
            <input type="text" placeholder="Enter operating system" name="os" required value="<?php echo $pc_arr['os'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['os'] ?></small></label><br>
            <label for="uname">Body (chasy):</label><br>
            <input type="text" placeholder="Enter pc's body type" name="body" required value="<?php echo $pc_arr['body'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['body'] ?></small></label><br>
            <label for="uname">Graphics:</label><br>
            <input type="text" placeholder="Enter pc Graphics" name="gr" required value="<?php echo $pc_arr['graphics'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['gr'] ?></small></label><br>
            <label for="uname">Has Graphic card:</label><br>
            <select name="grCard" id="" style="height: 30px; width:100%">
               <option value="1">Yes</option>
               <option value="0">No</option>
            </select><br><br>
            <label for="uname">Graphics card Description:</label><br>
            <input type="text" placeholder="Enter graphics card description" name="grDesc" value="<?php echo $pc_arr['grDesc'] ?>"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['grDesc'] ?></small></label><br>
            <label for="uname">Price:</label><br>
            <input type="number" placeholder="Enter pc price" name="price" required value="<?php echo $pc_arr['price'] ?>" style="width: 100%; height: 30px; padding-left: 5px;"><br>
            <label for="err"><small style="color: red;"><?php echo $errors['price'] ?></small></label><br>
            <input type="submit" value="Update details">
            <br>
         </div>
      </form>
   </div>

   
</body>
</html>