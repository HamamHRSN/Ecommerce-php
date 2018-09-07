<?php

/*
========================================================
== Manage Comments Pagen                              ==
== You Can Edit | Delete | Approve Comments From Hear ==
========================================================
*/

ob_start(); // Output Buffering Start

session_start();

 $pageTitle = 'Comments'; 

if (isset($_SESSION['Username'])) {  


    include "init.php";  
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

	// Start Manage Page  

	if ($do == 'Manage') { // Manage Comments Page 

      // Select All Users Except Admin

     $stmt = $con->prepare("SELECT 
                                comments.*, items.Name AS Item_Name, users.Username AS Member
                            FROM 
                                comments
                        INNER JOIN
                                items
                              ON 
                                items.item_ID = comments.item_id
                        INNER JOIN 
                                users
                              ON
                                users.UserID = comments.user_id
                        ORDER BY 
                               c_id DESC");

     // Useing As To Chaing Name Just //
       
     // Execute The Statement

     $stmt->execute();

     // Assign To Vriable

     $comments = $stmt->fetchAll();

     if (! empty($comments)) {
       
    ?>
		
    <h1 class="text-center">Manage Comments</h1>

    <div class="container">

    <div class="table-responsive">

      <table class="main-table text-center table table-bordered">
        
        <tr>
          <td>ID</td>
          <td>Comments</td>
          <td>Item Name</td>
          <td>User Name</td>
          <td>Added Date</td>
          <td>Control</td>
        </tr>

        <?php
          
      foreach ($comments as $comment) {
           
 echo "<tr>";
    echo "<td>" . $comment['c_id'] . "</td>";
    echo "<td>" . $comment['comment'] . "</td>";
    echo "<td>" . $comment['Item_Name'] . "</td>";// $comment['item_id'] *= Because WE Use AS In $stmt Upp =*  
    echo "<td>" . $comment['Member'] . "</td>";   // $comment['user_id'] *= To Chaing The Name             =*
    echo "<td>" . $comment['comment_date'] . "</td>";
    echo "<td>
<a href='comments.php?do=Edit&comid=" . $comment['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
<a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                           
          if ($comment['status'] == 0) {
            
          echo " <a href='comments.php?do=Approve&comid= " . $comment['c_id'] . "' class='btn btn-info activate '><i class='fa fa-check'></i> Approve</a>";

          }
          
                    echo "</td>";
           echo "</tr>";

         }

        ?>
        <tr>
        </table>
      </div>
    </div>

    <?php } else {

        echo '<div class="container">';
        echo '<div class="alert alert-info">There Is No Comments To Show..!</div>';
        echo '</div>';
       } 

       ?>
		
	<?php }  elseif ($do == 'Edit') {
		
		        /* Statment */
     // check If Get Request comid Is Numeric And Get The Integer Value Of IT

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    // Select All Data Depend This ID

		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

		$stmt->execute(array($comid));   // Execute Query
		$row = $stmt->fetch(); // feach Function To Pring The Data To Use It 
		$count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

        // if There is Such ID Show The Form 

		if ($count > 0) { // $count = $stmt->rowCount() ?>

           <h1 class="text-center">Edit Comment</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Update" method="POST" />
           	<input type="hidden" name="comid" value="<?php echo $comid ;?>" />

           	<!-- Start Comment Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Comment</label>
           			<div class="col-sm-10 col-md-6">
           			<textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
           			</div>
           		</div>

           	<!-- Start Comment Field -->

           	<!-- Start Submit Botton save Field -->

           		<div class="form-group">
           			
           			<div class="col-sm-offset-2 col-sm-10">
           				<input type="submit" value="Save" class="btn btn-primary btn-lg" />
           			</div>
           		</div>

           	<!-- Start Submit Botton save Field -->
           	</form>
           </div>
		
	   <?php 
         
         // Else If There is No Such ID Show Error Massage. 

	      } else {

          echo "<div class='container'>";

	      	$theMsg = "<div class='alert alert-danger'>There Is No Such ID ... !</div>";

          redirectHome($theMsg);

          echo "</div>";
	      }

     } elseif ($do == 'Update') { // Update Page

     	echo '<h1 class="text-center">Update Comment</h1>';
     	echo '<div class="container">';

     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     		
     		// Get Vriables From The Form 

     		$comid    = $_POST['comid'];
     		$comment  = $_POST['comment'];

     		// Update The Database With This Info 

        $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
        $stmt->execute(array($comment, $comid));

     		// Echo Success Massage.

     		$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Is Updated</div>';



        redirectHome($theMsg, 'back', 3);

     	} else {

     		$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

         redirectHome($theMsg);

     	}

     	echo '</div>';
     	
     } elseif ($do =='Delete') {
       
       // Delete Comment Page 

      echo '<h1 class="text-center">Delete Comment</h1>';
      echo '<div class="container">';

    // check If Get Request comid Is Numeric And Get The Integer Value Of IT

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    // Select All Data Depend This ID       

    $check = checkItem('c_id', 'comments', $comid);

    // if there is Such ID Show The Form

      if ($check > 0) {

        $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

        $stmt->bindParam(":zid", $comid);

        $stmt->execute();

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

        redirectHome($theMsg, 'back');

      } else {

        $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

        redirectHome($theMsg);

      }
        echo '</div>';

     } elseif ($do == 'Approve') {

       // echo "Activate";

     echo '<h1 class="text-center">Approve Comments</h1>';
     echo '<div class="container">';

    // check If Get Request Is Numeric And Get The Integer Value Of IT

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    // Select All Data Depend This ID

    $check = checkItem('c_id', 'comments', $comid);

    // if there is Such ID Show The Form

         
        if ($check > 0) {

          $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

          $stmt->execute(array($comid));

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approve</div>';

          redirectHome($theMsg, 'back');

        } else {

          $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

           redirectHome($theMsg);

        }

        echo '</div>';

     } 
	

	include $tpl . 'footer.php'; 

} else {    

   header('Location: indexAdmin.php'); // Direct Will Transfer Me To Login Page 

   exit(); // Efter Evry Header Must Be Exit Always...

}

ob_end_flush(); // Release The Output