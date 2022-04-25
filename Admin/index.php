
   <?php require_once("./header.php") ?>
   <?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>

   <?php

      require_once('../db/Database.php');

      $db = new Database();
      $conn = $db->connect();

      function get_u_count($conn)
      {
         $query = "SELECT COUNT(user_id) FROM users";
         $stmt = $conn->prepare($query);
         $stmt->execute();

         return $stmt->fetchColumn();
      }
      function get_r_count($conn)
      {
         $query = "SELECT COUNT(retailer_id) FROM retailers";
         $stmt = $conn->prepare($query);
         $stmt->execute();

         return $stmt->fetchColumn();
      }
      function get_p_count($conn)
      {
         $query = "SELECT COUNT(pc_id) FROM pc";
         $stmt = $conn->prepare($query);
         $stmt->execute();

         return $stmt->fetchColumn();
      }
   ?>

   <section class="r-pc-cont">
      <div class="cont-r">
         <div class="cont-r-head p-10 bg-diff">
            <p>Users</p>
         </div>
         <h1 class="p-10"><?php echo get_u_count($conn) ?> Users</h1>
         <div class="cont-r-action p-10 bg-diff">
            <a href="./users.php">View</a>
            |
            <a href="./users.php" onclick="window.open(this.href).print(); return false">Generate report</a>
         </div>
      </div>
      <div class="cont-r">
         <div class="cont-r-head p-10 bg-diff">
            <p>Retailers</p>
         </div>
         <h1 class="p-10" ><?php echo get_r_count($conn) ?> Retailers</h1>
         <div class="cont-r-action p-10 bg-diff">
            <a href="./retailers.php">View</a>
            |
            <a href="./retailers.php" onclick="window.open(this.href).print(); return false">Generate report</a>
         </div>
      </div>
      <div class="cont-r">
         <div class="cont-r-head p-10 bg-diff">
            <p>PCs</p>
         </div>
         <h1 class="p-10" ><?php echo get_p_count($conn) ?> PCs</h1>
         <div class="cont-r-action p-10 bg-diff">
            <a href="./pcs.php">View</a>
            |
            <a href="./pcs.php" onclick="window.open(this.href).print(); return false">Generate report</a>
         </div>
      </div>
   </section>
</body>
</html>