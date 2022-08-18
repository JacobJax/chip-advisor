<?php

require_once('../db/Database.php');
$db = new Database();
$conn = $db->connect();

function getPosts($conn)
{
   $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_on DESC");
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
      <div class="post-t-form">
         <form id="post-f">
            <input type="text" name="post" id="" placeholder="Whats on your mind" required>
            <input type="submit" value="Post">
         </form>
      </div>

      <?php $posts = getPosts($conn); ?>
      <?php if($posts) { ?>
         <?php foreach($posts as $post) {?>
            <div class="post">
               <div class="post-top">
                  <div class="post-head push-in">
                     <p><?php if($post['user_id'] == $_SESSION['uid']){echo "<span>👩‍🚀</span> You";} else {echo "<span>👩‍🚀</span> " . getName($post['user_id'], $conn)[0]['f_name'];} ?></p>
                     <p><small><?php echo $post['created_on'] ?></small></p>
                  </div>
                  <div class="push-in">
                     <p style="font-size: 1.1rem;"><?php echo $post['caption'] ?></p>
                  </div>
                  <div class="action push-in">
                     <details>
                        <summary style="color: blue; cursor: pointer; font-size: 14px;">Comments</summary>
                        <div class="coment">
                           <?php $cmts = getComments($post['post_id'], $conn) ?>
                           <?php foreach($cmts as $cmt) {?>
                              <p style="font-size: .9rem;"><span style="color: #bdbdbd; font-size: .9rem;"><?php echo getName($cmt['user_id'], $conn)[0]['f_name'] . ": " ?></span><?php echo $cmt['comment'] ?></p>
                           <?php }?>
                        </div>
                     </details>
                  </div>
               </div>
               <div class="post-btm">
                  <form class="cmt-frm">
                     <input type="hidden" name="uid" value="<?php echo $_SESSION['uid'] ?>">
                     <input type="hidden" name="pid" value="<?php echo $post['post_id'] ?>">
                     <input type="button" value="🙂" style="cursor: pointer; width: 2rem; height: 2rem; border-radius: 50%; display:flex; align-items:center; justify-content: center; font-size: 1rem;">
                     <input type="text" name="cmt" id="cmnt" placeholder="Enter comment" required style="width: 90%; padding: .8rem; font-size: 13px; border: none; background-color:#fafafa;" class="round-edge">
                  </form>
               </div>
            </div>
         <?php } ?>
      <?php }?>
   </div>
</section>

</body>
</html>