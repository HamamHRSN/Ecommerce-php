<?php

ob_start();
session_start();
$pageTitle = 'Show Items';

include 'init.php';

// check If Get Request item Is Numeric And Get The Integer Value Of IT
	     
	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	$stmt = $con->prepare("SELECT 
		                        items.*, categories.Name AS category_name,
		                        users.Username
		                    FROM 
		                        items
		              INNER JOIN 
		                        categories
		                      ON
		                      categories.ID = items.Cat_ID 
		              INNER JOIN
		                       users
		                      ON
		                      users.UserID = items.Member_ID
		                   WHERE 
		                        item_ID = ?
                         AND
                            Approve = 1");

	// Select All Data Depend This ID

	$stmt->execute(array($itemid));   // Execute Query
	
	$count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

	if ($count > 0) {

	$item = $stmt->fetch(); // feach Function To Pring The Data To Use It 
?>

<h1 class="text-center"><?php echo $item['Name']?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail center-block" src="img.jpg" alt="" />
		</div>
		<div class="col-md-9 item-info"> 
			<h2>Item Name : <strong><?php echo $item['Name']; ?></strong></h2>
			<p>Description : <?php echo $item['Description']; ?></p>
		<ul class="list-unstyled">
		    <li>
		       <i class="fa fa-calendar fa-fw"></i>
		       <span>Adding Date&Time : <strong><?php echo $item['Add_Date']; ?></strong></span>
		    </li>
			<li>
			   <i class="fa fa-Tags fa-fw"></i>
			   <div>Category : <strong><a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ;?></a></strong></div>
			</li>
			<li>
			   <i class="fa fa-money fa-fw"></i>
			   <div>Price : <strong><?php echo $item['Price']; ?></strong></div>
			</li>
			<li>
			   <i class="fa fa-building fa-fw"></i>
			   <div>Made In : <strong><?php echo $item['Country_Made']; ?></strong></div>
			</li>
			<li>
			   <i class="fa fa-user fa-fw"></i>
			   <div>Added By : <strong><a href="profile.php?id='<?php echo $item['Member_ID'] ?>'"><?php echo $item['Username'] ;?></a></strong></div>
			</li>
      <li class="tags-items">
         <i class="fa fa-tags fa-fw"></i>
         <div>Tags : </div>
         <?php
                
            $allTags = explode(",", $item['Tags']);

            foreach ($allTags as $tag) {

              $tag = str_replace(' ', '', $tag);
              $lowertag = strtolower($tag);

              if (! empty($tag)) {
              
               echo "<a href='tags.php?name={$lowertag}'>" . $tag . "</a>";

               }

            }
              
         ?>
      </li>
		</ul>
		</div>
	</div>
	<hr class="custom-hr">

	<!-- Start Add Comment -->
	<?php if (isset($_SESSION['user'])) { ?>
        <div class="row">
        	<div class="col-md-offset-3">
        	  <div class="add-comment">
        		<h3>Add Your Comment</h3>
        		<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['item_ID'] ?>" method="POST">
        			<textarea name="comment" required></textarea>
        			<input class="btn btn-primary"  type="submit" value="Add Comment">
        		</form>
		<?php

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          	
            //  echo $_POST['comment'];

            $comment   = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
            $itemid    = $item['item_ID'];
            $userid    = $_SESSION['uid'];
            
            if (! empty($comment)) {
            	
              $stmt = $con->prepare("INSERT INTO
              	                            comments(comment, status, comment_date, item_id, user_id)
              	                         VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");

              $stmt->execute(array(

                    'zcomment' => $comment,
                    'zitemid'  => $itemid,
                    'zuserid'  => $userid

              	));
              
              if ($stmt) {
              	
                echo '<div class="alert alert-success">Comment Has Been Added</div>';

              } else {

              	 echo '<div class="alert alert-danger">Write a Comment</div>';

              	 redirectHome($theMsg, 'back');

              }

            }

          }

		?>
        	  </div>
        	</div>
        </div>
<?php } else {

            echo '<a href="login.php">LogIn </a>Or <a href="login.php"> Reegister </a>To Add Comments ...!';

    	     } ?>
     <!-- End Add Comment -->

	<hr class="custom-hr">

<?php

             // Select All Users Except Admin

     $stmt = $con->prepare("SELECT 
                                comments.*, users.Username AS Member
                            FROM 
                                comments
                        INNER JOIN 
                                users
                              ON
                                users.UserID = comments.user_id
                           WHERE 
                                item_id = ?
                             AND 
                                status = 1
                        ORDER BY 
                               c_id DESC");
       
     // Execute The Statement

     $stmt->execute(array($item['item_ID']));

     // Assign To Vriable

     $comments = $stmt->fetchAll();

?>
	
<?php

    foreach ($comments as $comment) { ?>

    <div class="comment-box">
      <div class="row">
        <div class="col-sm-2 text-center">
            <img class="img-responsive img-thumbnail img-circle center-block" src="userimg.jpg" alt="" />
            <?php echo $comment['Member'] ?>
        </div>
        <div class="col-sm-10">
           <p class="lead"><?php echo $comment['comment'] ?></p>
        </div>
     </div>
   </div>
   <hr class="custom-hr">

   <?php  } ?>

</div>
<?php

} else {

  echo "<div class='container'>";

$theMsg = '<div class="alert alert-danger">There Is No Such ID ... Or This Item Is Waiting Approve.. !</div>';

  redirectHome($theMsg, 'back');

  echo "</div>";

                   }

include $tpl . "footer.php";
ob_end_flush();
?>
