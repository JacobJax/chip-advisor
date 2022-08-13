<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chip advisor</title>
   <link rel="stylesheet" href="../style.css">
   <script src="./js/app.js" defer></script>
</head>
<body style="background:#fafafa">

   <nav style="border-radius: 3px;">
      <div class="flex-r nav-flex span-max">
         <div class="nav-header">
            <h3><a href="./index.php">Chip advisor</a></h3>
         </div>
         <div class="dissapear">
            <div class="nav-options">
               <ul class="flex-r">
                  <!-- <li><a href="<?php if(isset($_SESSION['uid'])){ echo './index.php'; } else {echo "#";} ?>">My PCs</a></li>
                  <li><a href="<?php if(isset($_SESSION['uid'])){ echo './add.php?id=' . $_SESSION['uid']; } else {echo "#";} ?>">Add PC</a></li> -->
                  <li><a href="<?php if(isset($_SESSION['uid'])){ echo '../forum/index.php'; } else {echo "#";} ?>" style="color: #fff;">Forum</a></li>
               </ul>
            </div>
            <div class="nav-action">
               <ul class="flex-r">
                  <li>
                     <?php if(isset($_SESSION['uid'])) {?>
                        <a href="#" style="color: #fff;">Hi <?php echo $_SESSION['fname'] ?></a>
                     <?php } else {?>
                        <a href="./register.php" style="color: #fff;">Sign up</a>
                     <?php }?>
                  </li>
                  <li>|</li>
                  <li>
                     <?php if(isset($_SESSION['uid'])) {?>
                        <a href="./logout.php" style="color: #fff;">Log out</a>
                     <?php } else {?>
                        <a href="./login.php" style="color: #fff;">Log in</a>
                     <?php }?>
                  </li>
               </ul>
            </div>
         </div>
         <div class="link-toggle">
            <img src="../assets/Hamburger Menu.svg" alt="hambuger menu">
         </div>
      </div>
   </nav>
