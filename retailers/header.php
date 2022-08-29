<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chip advisor</title>
   <link rel="stylesheet" href="../style.css">
   <script src="../js/dropdown.js" defer></script>
</head>
<body>

   <nav>
      <div class="flex-r nav-flex span-max nav-cont">
         <div class="nav-header">
            <h3><a href="./index.php" style="color: #6a1b9a;">Chip advisor</a></h3>
         </div>
         <div class="dissapear dropdown">
            <div class="drop-elms">
               <a href="<?php if(isset($_SESSION['uid'])){ echo './index.php'; } else {echo "#";} ?>">My PCs</a>
               <a href="<?php if(isset($_SESSION['uid'])){ echo './add.php?id=' . $_SESSION['uid']; } else {echo "#";} ?>">Add PC</a>
               <br>
               <?php if(isset($_SESSION['uid'])) {?>
                  <a href="#">Hi <?php echo $_SESSION['fname'] ?></a>
               <?php } else {?>
                  <a href="./register.php">Sign up</a>
               <?php }?>
               <?php if(isset($_SESSION['uid'])) {?>
                  <a href="./logout.php">Log out</a>
               <?php } else {?>
                  <a href="./login.php">Log in</a>
               <?php }?>
            </div>
         </div>
         <div class="link-toggle">
            <img src="../assets/Hamburger Menu.svg" alt="hambuger menu">
         </div>
      </div>
   </nav>