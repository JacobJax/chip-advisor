<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chip advisor</title>
   <link rel="stylesheet" href="../style.css">
</head>
<body>

   <nav class="flex-r">
      <div class="nav-header">
      <h3><a href="./index.php" style="color: #6a1b9a;">Chip advisor [ADMIN]</a></h3>
      </div>
      <div class="nav-options">
         <ul class="flex-r">
            <li><a href="<?php if(isset($_SESSION['uid'])){ echo './pcs.php'; } else {echo "#";} ?>">PCs</a></li>
            <li><a href="<?php if(isset($_SESSION['uid'])){ echo './users.php'; } else {echo "#";} ?>">Users</a></li>
            <li><a href="<?php if(isset($_SESSION['uid'])){ echo './retailers.php'; } else {echo "#";} ?>">Retailers</a></li>
         </ul>
      </div>
      <div class="nav-action">
         <ul class="flex-r">
            <li>
               <?php if(isset($_SESSION['uid'])) {?>
                  <a href="#">Welcome <?php echo $_SESSION['fname'] ?></a>
               <?php } ?>
            </li>
            <li>|</li>
            <li>
               <?php if(isset($_SESSION['uid'])) {?>
                  <a href="./logout.php">Log out</a>
               <?php } else {?>
                  <a href="./login.php">Log in</a>
               <?php }?>
            </li>
         </ul>
      </div>
   </nav>