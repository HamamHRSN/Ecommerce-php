<?php

ob_start(/*"ob_gzhandler"*//*if i want to try it one days*/);  // Output Buffaring Starts

session_start();

 // $noNavbar = ''; // To Remove Navbar From Pages I Use This Variable // Hear I Want Navebar //

if (isset($_SESSION['Username'])) {  // isset Mean If Is Exssest And The Password Is Right

   $pageTitle = 'Dashbouard'; 

    include 'init.php';  
	
	//echo 'Welcome ' . $_SESSION['Username']; // The Name Of The User Account We Inter From 

	//print_r($_SESSION);

	/* ***************Start Dashboard Page***************** */

	$latestUsersNumber = 5;  // Number Of Latest Users

	$theLatestUser = getLatest("*", "users", "UserID", $latestUsersNumber); // Get Title Func Latest Users Array

	$latestItemsNumber = 5;  // Number Of Latest Items


	$theLatestItems = getLatest("*", "items", "item_ID", $latestItemsNumber); // Latest Items Array

	$latestCommentNumber = 5; // Number Of Comments

	$theLatestComments = getLatest("*", "comments", "c_id", $latestCommentNumber);

	/*$stmt2 = $con->prepare("SELECT COUNT(UserID) FROM users");

	$stmt2->execute();

    $stmt2->fetchColumn();*/

    /********************************************************************************/

    /*echo "<pre>";

    print_r(getLatest("*", "users", "UserID", 3));

    echo "</pre>";*/

   /* $theLatest = getLatest("*", "users", "UserID", 3);

    foreach ($theLatest as $user) {
    	
    	echo $user['Username'] . '<br>';
    }*/

	?>

	<div class="home-stats">
     
	     <div class="container text-center">
	     <h1>Dashboard</h1>
	     <div class="row">
	     	<div class="col-md-3">
	     	    <div class="stat st-members">
	     	        <i class="fa fa-users"></i>
	     	        <div class="info">
		     	        Total Member
		     	        <span>
		     	           <a href="members.php"><?php echo countItems('UserID', 'users') ;?></a>
		     	        </span>
	     	        </div>
	     	    </div>
	     	</div>
	     	<div class="col-md-3">
	     	    <div class="stat st-pending">
	     	        <i class="fa fa-user-plus"></i>
	     	     <div class="info">
	     	        Pendings Members
	     	        <span>
	     	            <a href="members.php?do=Manage&page=Pending"><?php echo checkItem("RegisterStatus", "users", 0) ?></a>
	     	        </span>
	     	      </div>
	     	    </div>
	     	</div>
	     	<div class="col-md-3">
	     	    <div class="stat st-items">
	     	       <i class="fa fa-tags"></i>
	     	        <div class="info">
	     	        Total Items
	     	        <span><a href="items.php"><?php echo countItems('item_ID', 'items') ;?></a></span>
	     	        </div>
	     	    </div>
	     	</div>
	     	<div class="col-md-3">
	     	    <div class="stat st-comments">
	     	    <i class="fa fa-comments"></i>
	     	        <div class="info">
	     	        Total Comments
	     	        <span><a href="comments.php"><?php echo countItems('c_id', 'comments') ;?></a></span>
	     	        </div>
	     	    </div>
	     	</div>
	     </div>
	   </div>
   </div>


   <div class="latest">
     <div class="container">
     	<div class="row">
     		<div class="col-sm-6">
     			<div class="panel panel-default">
	     			<div class="panel-heading">
	     				<i class="fa fa-users"></i> 
	     				Latest <?php echo $latestUsersNumber ?> Registerd Users
	     				<span class="toggle-info pull-right">
	     					<i class="fa fa-plus fa-lg"></i>
	     				</span>
	     			</div>
	     			<div class="panel-body">
                    <ul class="list-unstyled latest-users">
	     			<?php

	     			if (! empty($theLatestUser)) {
	    
				    foreach ($theLatestUser as $user) {
				    	
				    	echo '<li>'; 
				    	   echo $user['Username'];
				    	   echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">'; 
				    	    echo '<span class="btn btn-success pull-right">';
	                        echo '<i class="fa fa-edit"></i> Edit';
	      if ($user['RegisterStatus'] == 0) {
            
          echo " <a href='members.php?do=Activate&userid= " . $user['UserID'] . "' class='btn btn-info pull-right activate '><i class='fa fa-check'></i> Activate</a>";

          }
				    	    echo '</span>';
				    	    echo '</a>';
				    	echo '</li>';
				    }
				  } else {

echo '<div class="container">';
  echo '<div class="nice-Massage">There Is No Members To Show ..!</div>';
echo '</div>';
				  }

	     			?>
	     			</ul>
 	     			</div>
     			</div>
     		</div>
     		<div class="col-sm-6">
     			<div class="panel panel-default">
		     			<div class="panel-heading">
		     				<i class="fa fa-tag"></i>
		     				Latest <?php echo $latestItemsNumber ?> Items
		     				<span class="toggle-info pull-right">
	     					<i class="fa fa-plus fa-lg"></i>
	     				</span>
		     			</div>
	     			<div class="panel-body">

	     			 <ul class="list-unstyled latest-users">
	     			<?php

	     			if (! empty($theLatestItems)) {

				    foreach ($theLatestItems as $item) {
				    	
				    	echo '<li>'; 
				    	   echo $item['Name'];
				    	   echo '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] . '">'; 
				    	    echo '<span class="btn btn-success pull-right">';
	                        echo '<i class="fa fa-edit"></i> Edit';
	      if ($item['Approve'] == 0) {
            
          echo " <a href='items.php?do=Approve&itemid= " . $item['item_ID'] . "' class='btn btn-info pull-right activate '><i class='fa fa-check'></i> Approve</a>";

          }
				    	    echo '</span>';
				    	    echo '</a>';
				    	echo '</li>';
				    }

				} else {


				echo '<div class="container">';
				  echo '<div class="nice-Massage">There Is No Items To Show ..!</div>';
				echo '</div>';
				}

	     			?>
	     			</ul>
 	     			  </div>
     			   </div>
     		    </div>
			</div>
			<!-- Start Latest Comment -->

			<div class="row">
     		<div class="col-sm-6">
     			<div class="panel panel-default">
	     			<div class="panel-heading">
	     				<i class="fa fa-comments-o"></i> 
	     				Latest <?php echo $latestCommentNumber ?> Comments
	     				<span class="toggle-info pull-right">
	     					<i class="fa fa-plus fa-lg"></i>
	     				</span>
	     			</div>
	     			<div class="panel-body">

                      <?php

     $stmt = $con->prepare("SELECT 
                                comments.*, users.Username AS Member
                            FROM 
                                comments
                        INNER JOIN 
                                users
                              ON
                                users.UserID = comments.user_id
                         ORDER BY 
                                c_id DESC
                            LIMIT 
                            $latestCommentNumber");
       
     // Execute The Statement

     $stmt->execute();

     // Assign To Vriable

     $comments = $stmt->fetchAll();

     if (! empty($comments)) {

     foreach ($comments as $comment) {
     	
     	echo '<div class="comment-box">';

     	// As I Name It Number Upp In Statement

     	echo '<span class="member-name"><a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">' . $comment['Member'] . '</a></span>'; 

     	echo '<p class="member-comment">' . $comment['comment'] . '</p>';

     	echo '</div>';

     }

          } else { 

          	     echo '<div class="container">';
				  echo '<div class="nice-Massage">There Is No Comments To Show ..!</div>';
				echo '</div>';


             }

                      ?>

 	     			</div>
     			</div>
     		</div>
		</div>

			<!-- End Latest Comment -->
		</div>
	</div>
     
    <?php

	/* Ends Dashboard Page */

	include $tpl . 'footer.php'; 

} else {   // Or Return Me Back To 

   // echo 'You Are Not Authorized To View This Page....!'; // Will Not Show This Massage but In Case. 

   header('Location: indexAdmin.php'); // Direct Will Transfer Me To Login Page 

   exit(); // Efter Evry Header Must Be Exit Always...

}

ob_end_flush();


//======================================
// All My Pages Will Use What Writing Up. 
//=======================================

?>