<?php

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function getPosts($conn)
{
   $stmt = $conn->prepare("SELECT * FROM posts");
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getComments($id, $conn) 
{
   $stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = :id");
   $stmt->bindValue(':id', $id);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getName($id, $conn) 
{
   $stmt = $conn->prepare("SELECT f_name FROM users WHERE user_id = :id");
   $stmt->bindValue(':id', $id);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php include_once "./header.php"; ?>
<?php if(!isset($_SESSION['uid'])) { header('Location: ./login.php'); } ?>

<section class="r-pc-container">
   <div class="post-t">
      <form class="post-t-form" id="post-f">
         <input type="text" name="post" id="" placeholder="Whats on your mind" required>
         <input type="submit" value="Post">
      </form>

      <?php $posts = getPosts($conn); ?>
      <?php if($posts) { ?>
         <?php foreach($posts as $post) {?>
            <div class="post">
               <div class="post-head">
                  <p><?php if($post['user_id'] == $_SESSION['uid']){echo "You";} else {echo getName($post['user_id'], $conn)[0]['f_name'];} ?></p>
                  <small><?php echo $post['created_on'] ?></small>
               </div>
               <div class="body">
                  <p><?php echo $post['caption'] ?></p>
               </div>
               <br>
               <div class="action">
                  <details style="width: 80%;">
                     <summary style="color: blue; cursor: pointer;">Comment | <a href="#">Like</a></summary>
                     <form class="cmt-frm">
                        <br>
                        <input type="hidden" name="uid" value="<?php echo $_SESSION['uid'] ?>">
                        <input type="hidden" name="pid" value="<?php echo $post['post_id'] ?>">
                        <input type="text" name="cmt" id="cmnt" placeholder="Enter comment" required style="width: 68%; padding: 3px; font-size: 13px; border: none; border-bottom: 2px #6a1b9a solid;">
                        <input type="submit" value="Comment" style="padding: 3px 10px; background-color: #fafafa;">
                        <br><br>
                     </form>
                     <div class="coment">
                        <?php $cmts = getComments($post['post_id'], $conn) ?>
                        <?php foreach($cmts as $cmt) {?>
                           <p style="font-weight: lighter; font-size: 15px;"><span style="color: #bdbdbd; font-size: 13px;"><?php echo getName($cmt['user_id'], $conn)[0]['f_name'] . ": " ?></span><?php echo $cmt['comment'] ?></p>
                        <?php }?>
                     </div>
                  </details>
               </div>
            </div>
         <?php } ?>
      <?php }?>
   </div>
</section>

</body>
</html>