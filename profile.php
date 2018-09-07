<?php

ob_start();

session_start();

$pageTitle = 'Profile';


include 'init.php';

// echo $_SESSION['user'];  

/*  

 Using Variable $sessionUser From init.php so No Need Condition If Just Variable 

if (isset($_SESSION['user'])) {
	
	echo $_SESSION['user'];

}

*/

// echo $sessionUser;

if (isset($_SESSION['user'])) {

	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");

	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

  $userid = $info['UserID'];


?>


<?php // echo 'Welcome ' . $_SESSION['user']; ?>

<h1 class="text-center">My Profile</h1>

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">MY Information</div>
			<div class="panel-body">
  <ul class="list-unstyled">
    				<li>
            <i class="fa fa-unlock-alt fa-fw"></i>
            <span>LogIn Name </span> : <?php echo $info['Username'] ?>
            </li>
    			  <li>
            <i class="fa fa-envelope-o fa-fw"></i>
            <span> Email </span> : <?php echo $info['Email'] ?> 
            </li>
      			<li>
            <i class="fa fa-user fa-fw"></i>
            <span> FullName </span> : <?php echo $info['FullName'] ?> 
            </li>
            <li>
            <i class="fa fa-calendar fa-fw"></i>
            <span> Register Date </span> : <?php echo $info['Date'] . ' In Time' ?> 
            </li>
            <li>
            <i class="fa fa-tags fa-fw"></i>
            <span>Favourite Category</span> : <?php echo $info['UserID'] ?> 
            </li>
  </ul>
  <a href="#" class="btn btn-default">Edit Information</a>
			</div>	
		</div>
	</div>
</div>

<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">MY Advertisement</div>
			<div class="panel-body">
	
  <?php

  $myItems = getAllFrom("*", "items", "where Member_ID = $userid", "", "item_ID", "DESC");
         // getAllFrom($field, $table, $where = NULL, $and = NULL, $oredrfield, $ordering = "DESC") //

  if (! empty(/*getItems('Member_ID', $info['UserID']) Old*/ $myItems)) {

    echo '<div class="row">';
       // Foreach To Bring Items To The Categories Of It By Useing Function getItems
       foreach (/*getItems('Member_ID', $info['UserID'], 1)*/ $myItems as $item) {  
       	
       	// echo $item['Name'];

       	echo '<div class="col-sm-6 col-md-3">';
       	    echo '<div class="thumbnail item-box">';
         if ($item['Approve'] == 0) { echo '<span class="approve-status">Waiting For Approve Shortly</span>';}
  # Approved Items #
       	      echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                echo '<img class="img-responsive" src="img.jpg" alt="" />';
                echo '<div class="caption">';
                     echo '<h3><a href="items.php?itemid=' . $item['item_ID'] . '">' . $item['Name'] . '</a></h3>';
                     echo '<p>' . $item['Description'] . '</p>';
                     echo '<div class="date">' . $item['Add_Date'] . '</div>';
                echo '</div>';
            echo '</div>';
       	echo '</div>';

       }

    echo '</div>';

    } else {

      echo 'Sorry There Is No Ads To Show..!, Create <a href="newadd.php">New Ads</a>';
    }

  ?>
			</div>	
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comments</div>
			<div class="panel-body">
<?php

$myComments = getAllFrom("comment", "comments", "where user_id = $userid", "", "c_id", "DESC"); 

/*
// No need This Statment Efter Useing Function getAllFrom() //
		 // Select All Users Except Admin
     $stmt = $con->prepare("SELECT 
                                comment
                            FROM 
                                comments
                            WHERE 
                                user_id = ?");
     // Execute The Statement
     $stmt->execute(array($info['UserID']));
     // Assign To Vriable
     $comments = $stmt->fetchAll();
*/
     if (! empty(/*$comments Old*/ $myComments)) {

     	foreach (/*$comments old*/ $myComments as $comment) {

     		echo '<p>' . $comment['comment'] . '</p>';
     	}

     } else {

  echo 'There Is No Comments To Show..!';
  
  }

?> <br />
			</div>	
		</div>
	</div>
</div>

<?php

} else {


	header('Location: login.php');

	exit();

}

include $tpl . "footer.php";

ob_end_flush();

?>