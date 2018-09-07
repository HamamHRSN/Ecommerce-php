<?php

/*
====================================================
== Items Page
====================================================
*/

ob_start();  // Output Buffering Start

session_start();

 $pageTitle = 'Items'; 

if (isset($_SESSION['Username'])) {  


    include "init.php";  
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
 

	if ($do == 'Manage') { // Manage Members Page

	  // echo "welcome";

     $stmt = $con->prepare("SELECT 
     	                        items.*, 
     	                        categories.Name AS category_name, users.Username 
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
                            ORDER BY
                                item_ID DESC");
       
     // Execute The Statement

     $stmt-> execute();

     // Assign To Vriable

     $items = $stmt->fetchAll();

     if (! empty($items)) {

    ?>
		
    <h1 class="text-center">Manage Items</h1>
    <div class="container">
    <div class="table-responsive">

      <table class="main-table text-center table table-bordered">
        
        <tr>
          <td>#ID</td>
          <td>Item Name</td>
          <td>Description</td>
          <td>Price</td>
          <td>Adding Date</td>
          <td>Category</td>
          <td>Username</td>
          <td>Control</td>
        </tr>

        <?php
         
         foreach ($items as $item) {
           
           echo "<tr>";
              echo "<td>" . $item['item_ID'] . "</td>";
              echo "<td>" . $item['Name'] . "</td>";
              echo "<td>" . $item['Description'] . "</td>";
              echo "<td>" . $item['Price'] . "</td>";
              echo "<td>" . $item['Add_Date'] . "</td>";
              echo "<td>" . $item['category_name'] . "</td>";
              echo "<td>" . $item['Username'] . "</td>";
              echo "<td>
<a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
<a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
            // Use It For Approve 
            if ($item['Approve'] == 0) {
          echo "<a href='items.php?do=Approve&itemid= " . $item['item_ID'] . "'class='btn btn-info activate'>
                <i class='fa fa-check'></i> Approve</a>";

                       }
                    echo "</td>";
           echo "</tr>";
         }

        ?>
        <tr>
       
      </table>

    </div>
      <a href="items.php?do=Add" class="btn btn-lg btn-primary">
      <i class="fa fa-plus"> Add New Item</i></a>
    </div>

   <?php }  else{

echo '<div class="container">';
  echo '<div class="nice-Massage">There Is No Items To Show..!</div>';
  echo '<a href="items.php?do=Add" class="btn btn-lg btn-primary"><i class="fa fa-plus"> Add New Item</i></a>';
echo '</div>';

  }  ?>
		
		<?php

	} elseif ($do == 'Add') { ?>

		 <h1 class="text-center">Add New Items</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Insert" method="POST" />
           	<!--<input type="hidden" name="userid" value="<?php //echo $userid ;?>" />-->

           	<!-- Start Name Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Name</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" 
                       name="name" 
                       class="form-control" 
                       required = "required" 
                       placeholder="Name Of The Item" />
           			</div>
           		</div>

           	<!-- Ends Name Field -->

           	<!-- Start Description Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Description</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" 
                       name="description" 
                       class="form-control" 
                       required = "required" 
                       placeholder="Description Of The Item" />
           			</div>
           		</div>

           	<!-- Ends Description Field -->

           	<!-- Start Price Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Price</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" 
                       name="price" 
                       class="form-control" 
                       required = "required" 
                       placeholder="Price Of The Item" />
           			</div>
           		</div>

           	<!-- Ends Price Field -->

           	<!-- Start Country Made Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Country Of Made</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" 
                       name="country" 
                       class="form-control" 
                       required = "required" 
                       placeholder="Country Of Made " />
           			</div>
           		</div>

           	<!-- Ends Country Made Field -->

           	<!-- Start Status Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Status</label>
           			<div class="col-sm-10 col-md-6">
           			  <select name="status">
           			     <option value="0">...</option>
           			  	 <option value="1">New</option>
           			  	 <option value="2">Like New</option>
           			  	 <option value="3">Used</option>
           			  	 <option value="4">Very Old</option>
           			  </select>
           			</div>
           		</div>

           	<!-- Ends Status Field -->

           	<!-- Start Members Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Member</label>
           			<div class="col-sm-10 col-md-6">
           			  <select name="member">
           			     <option value="0">...</option>
	     <?php

    $AllMember = getAllFrom("*", "users", "", "", "UserID", "DESC");

    foreach ($AllMember as $user) {

      echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
      

    }

    /*

    // efter Using New Function Upp //

	     // To pring User And Let hem Add The Item In Hes Name  

	     $stmt = $con->prepare("SELECT * FROM users");
	     $stmt->execute();
	     $users = $stmt->fetchAll();

	     foreach ($users as $user) {
	     	
          echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";

	     }

       */

	     ?>
           			  </select>
           			</div>
           		</div>

           	<!-- Ends Members Field -->

           	<!-- Start Categories Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Category</label>
           			<div class="col-sm-10 col-md-6">
           			  <select name="category">
           			     <option value="0">...</option>
		     <?php

         // Use Where To Show Just The Head Category  

         $AllCats = getAllFrom("*", "categories", "where Parent = 0", "", "ID", "DESC");

           foreach ($AllCats as $cat) {
          
              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

         $childCats = getAllFrom("*", "categories", "where Parent = {$cat['ID']}", "", "ID", "DESC");

         foreach ($childCats as $child) {

          echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
           
            }

         }

         /*

		     // To pring User And Let hem Add The Item In Hes Name  

		     $stmt2 = $con->prepare("SELECT * FROM categories");
		     $stmt2->execute();
		     $cats = $stmt2->fetchAll();

		     foreach ($cats as $cat) {
		     	
              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

		     }
         */

		     ?>
           			  </select>
           			</div>
           		</div>

           	<!-- Ends Categories Field -->

           	<!-- Start Rating Field -->
           	<!--	<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Rating</label>
           			<div class="col-sm-10 col-md-6">
           			  <select class="form-control" name="rating">
           			     <option value="0">...</option>
           			  	 <option value="1">1 . *</option>
           			  	 <option value="2">2 . **</option>
           			  	 <option value="3">3 . ***</option>
           			  	 <option value="4">4 . ****</option>
           			  	 <option value="5">5 . *****</option>
           			  </select>
           			</div>
           		</div>
            -->
           	<!-- Ends Rating Field -->

            <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" 
                       name="tags" 
                       class="form-control" 

                       placeholder="Separate Tags With Comma (,) " />
                </div>
              </div>

            <!-- Ends Tags Field -->

           	<!-- Start Submit Botton save Field -->

           		<div class="form-group form-group-lg">
           			<div class="col-sm-offset-2 col-sm-10">
           				<input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
           			</div>
           		</div>

           	<!-- Ends Submit Botton save Field -->
           	</form>
           </div>

           <?php
		
	} elseif ($do == 'Insert') {

		//  Insert Items Page 
 
     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     	echo '<h1 class="text-center">Insert Item</h1>';
     	echo '<div class="container">';
     		
     		// Get Vriables From The Form 

     		$name    = $_POST['name'];
     	  $desc    = $_POST['description'];
     		$price   = $_POST['price'];
     		$country = $_POST['country'];
     		$status  = $_POST['status'];
     		$cat     = $_POST['category'];
     		$member  = $_POST['member'];
        $tags    = $_POST['tags'];

     		// Validate The Form

     		$formErrors = array();

     		if (empty($name)) {
     			
     			$formErrors[] = "Name Can\'t Be <strong>Empty</strong>";
     		}
     		if (empty($desc)) {
     			
     			$formErrors[] = "Description Can\'t Be <strong>Empty</strong>";
     		}
     		if (empty($price)) {
     			
     			$formErrors[] = "Price Can\'t Be <strong>Empty</strong>";
     		}
     		if (empty($country)) {
     			
     			$formErrors[] = "Country Made Can\'t Be <strong>Empty</strong>";
     		}
     		if ($status == 0) {
     			
     		    $formErrors[] = "You Must Choose The <strong>Status</strong>";
     		}
     		if ($member == 0) {
     			
     		    $formErrors[] = "You Must Choose The <strong>Member</strong>";
     		}
     		if ($cat == 0) {
     			
     		    $formErrors[] = "You Must Choose The <strong>Category</strong>";
     		}

     		// Loop In To Errors Array And Echo It

     		foreach ($formErrors as $error) {
     			
     			echo '<div class="alert alert-danger">' . $error . '</div>';

     		}

     		// Check If There's No Error Proceed The Update Operation

     		if (empty($formErrors)) {

     		// Insert User Info In Database  

     		$stmt = $con->prepare("
                               INSERT INTO 
                               items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID,Tags)
                               VALUES
                               (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");

     		$stmt->execute(array(

               'zname'    => $name,
               'zdesc'    => $desc,
               'zprice'   => $price,
               'zcountry' => $country,
               'zstatus'  => $status,
               'zcat'     => $cat,
               'zmember'  => $member,
               'ztags'    => $tags
               
          ));

     		// Echo Success Massage.

     		$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Is Inserted</div>';

            redirectHome($theMsg, 'back');

     		}

     	} else {

        echo "<div class='container'>";

     	$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

        redirectHome($theMsg);

        echo "</div>";

     	}

     	echo '</div>';
		
	} elseif ($do == 'Edit') { 
		        
	  // check If Get Request item Is Numeric And Get The Integer Value Of IT
	     
	  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		$stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");

		// Select All Data Depend This ID

		$stmt->execute(array($itemid));   // Execute Query
		$item = $stmt->fetch(); // feach Function To Pring The Data To Use It 
		$count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

        // if There is Such ID Show The Form 

		if ($count > 0) { // $count = $stmt->rowCount() ?>

            <h1 class="text-center">Edit Items</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Update" method="POST" />
           	<input type="hidden" name="itemid" value="<?php echo $itemid ;?>" />

           	<!-- Start Name Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Name</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="name" class="form-control" required = "required" placeholder="Name Of The Item" value="<?php echo  $item['Name'] ;?>" />
           			</div>
           		</div>

           	<!-- Ends Name Field -->

           	<!-- Start Description Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Description</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="description" class="form-control" required = "required" placeholder="Description Of The Item" value="<?php echo  $item['Description'] ;?>"/>
           			</div>
           		</div>

           	<!-- Ends Description Field -->

           	<!-- Start Price Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Price</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="price" class="form-control" required = "required" placeholder="Price Of The Item" value="<?php echo  $item['Price'] ;?>"/>
           			</div>
           		</div>

           	<!-- Ends Price Field -->

           	<!-- Start Country Made Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Country Of Made</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="country" class="form-control" required = "required" placeholder="Country Of Made " value="<?php echo  $item['Country_Made'] ;?>"/>
           			</div>
           		</div>

           	<!-- Ends Country Made Field -->

       	<!-- Start Status Field -->
       		<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Status</label>
       			<div class="col-sm-10 col-md-6">
       			  <select name="status">
       			     <!--<option value="0">...</option>--><!-- No Need Because The Client Choose Alrady-->
       			  	 <option value="1" <?php if ($item['Status'] == 1) {echo 'selected';} ?>>New</option>
       			  	 <option value="2" <?php if ($item['Status'] == 2) {echo 'selected';} ?>>Like New</option>
       			  	 <option value="3" <?php if ($item['Status'] == 3) {echo 'selected';} ?>>Used</option>
       			  	 <option value="4" <?php if ($item['Status'] == 4) {echo 'selected';} ?>>Very Old</option>
       			  </select>
       			</div>
       		</div>

       	<!-- Ends Status Field -->

       	<!-- Start Members Field -->
       		<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Member</label>
       			<div class="col-sm-10 col-md-6">
       			  <select name="member">
       			     <!--<option value="0">...</option>--><!-- No Need Because The Client Choose Alrady-->
       			     <?php

       			     // To pring User And Let hem Add The Item In Hes Name  

       			     $stmt = $con->prepare("SELECT * FROM users");
       			     $stmt->execute();
       			     $users = $stmt->fetchAll();

       			     foreach ($users as $user) {
       			     	
                        echo "<option value='" . $user['UserID'] . "'"; 
                        if ($item['Member_ID'] == $user['UserID']) {echo 'selected';} 
                        echo">" . $user['Username'] . "</option>";

       			     }

       			     ?>
       			  </select>
       			</div>
       		</div>

       	<!-- Ends Members Field -->

           	<!-- Start Categories Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Category</label>
           			<div class="col-sm-10 col-md-6">
           			  <select class="form-control" name="category">
           			     <!--<option value="0">...</option>--><!-- No Need Because The Client Choose Alrady-->
           			     <?php

           			     // To pring User And Let hem Add The Item In Hes Name  

           			     $stmt2 = $con->prepare("SELECT * FROM categories");
           			     $stmt2->execute();
           			     $cats = $stmt2->fetchAll();

           			     foreach ($cats as $cat) {
           			     	
                            echo "<option value='" . $cat['ID'] . "'";
                            if ($item['Cat_ID'] == $cat['ID']) {echo 'selected';} 
                            echo">" . $cat['Name'] . "</option>";

           			     }

           			     ?>
           			  </select>
           			</div>
           		</div>

           	<!-- Ends Categories Field -->

           	<!-- Start Rating Field -->
           	<!--	<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Rating</label>
           			<div class="col-sm-10 col-md-6">
           			  <select class="form-control" name="rating">
           			     <option value="0">...</option>
           			  	 <option value="1">1 . *</option>
           			  	 <option value="2">2 . **</option>
           			  	 <option value="3">3 . ***</option>
           			  	 <option value="4">4 . ****</option>
           			  	 <option value="5">5 . *****</option>
           			  </select>
           			</div>
           		</div>
            -->
           	<!-- Ends Rating Field -->

            <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" 
                       name="tags" 
                       class="form-control" 

                       placeholder="Separate Tags With Comma (,)" 
                       value="<?php echo $item['Tags'] ;?>" />
                </div>
              </div>

            <!-- Ends Tags Field -->

           	<!-- Start Submit Botton save Field -->

           		<div class="form-group form-group-lg">
           			<div class="col-sm-offset-2 col-sm-10">
           				<input type="submit" value="Save Item" class="btn btn-primary btn-lg" />
           			</div>
           		</div>

           	<!-- Ends Submit Botton save Field -->
           	</form>

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
                                item_id = ?");

     // Useing As To Chaing Name Just //
       
     // Execute The Statement

     $stmt->execute(array($itemid));

     // Assign To Vriable

     $rows = $stmt->fetchAll();

     if (! empty($rows)) { // If There Is No Comment do Not Show The comment Details 

    ?>
    
    <h1 class="text-center">Manage [ <?php echo  $item['Name'] ;?> ] Comments</h1>

    <div class="table-responsive">

      <table class="main-table text-center table table-bordered">
        
        <tr>
          <td>Comments</td>
          <td>User Name</td>
          <td>Added Date</td>
          <td>Control</td>
        </tr>

        <?php
         
         foreach ($rows as $row) {
           
       echo "<tr>";
          echo "<td>" . $row['comment'] . "</td>";
        //  *= Because WE Use AS In $stmt Upp    =*
        // $row['user_id'] *= To Chaing The Name =*  
          echo "<td>" . $row['Member'] . "</td>";  
          echo "<td>" . $row['comment_date'] . "</td>";
          echo "<td>
<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                           
          if ($row['status'] == 0) {
            
          echo " <a href='comments.php?do=Approve&comid= " . $row['c_id'] . "' class='btn btn-info activate '><i class='fa fa-check'></i> Approve</a>";

          }
          
                    echo "</td>";
           echo "</tr>";

         }

        ?>
        <tr>
        </table>
      </div>
    <?php } ?>
</div>
		
	   <?php 
         
         // Else If There is No Such ID Show Error Massage. 

	      } else {

          echo "<div class='container'>";

	      	$theMsg = "<div class='alert alert-danger'>There Is No Such ID ... !</div>";

          redirectHome($theMsg);

          echo "</div>";
	      }	
		
	} elseif ($do == 'Update') {

    echo '<h1 class="text-center">Update Item</h1>';
      echo '<div class="container">';

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Get Vriables From The Form 

        $id       = $_POST['itemid'];
        $name     = $_POST['name'];
        $desc     = $_POST['description'];
        $price    = $_POST['price'];
        $country  = $_POST['country'];
        $status   = $_POST['status'];
        $cat      = $_POST['category'];
        $member   = $_POST['member'];
        $tags     = $_POST['tags'];
        

      // Validate The Form

        $formErrors = array();

        if (empty($name)) {
          
          $formErrors[] = "Name Can\'t Be <strong>Empty</strong>";
        }
        if (empty($desc)) {
          
          $formErrors[] = "Description Can\'t Be <strong>Empty</strong>";
        }
        if (empty($price)) {
          
          $formErrors[] = "Price Can\'t Be <strong>Empty</strong>";
        }
        if (empty($country)) {
          
          $formErrors[] = "Country Made Can\'t Be <strong>Empty</strong>";
        }
        if ($status == 0) {
          
            $formErrors[] = "You Must Choose The <strong>Status</strong>";
        }
        if ($member == 0) {
          
            $formErrors[] = "You Must Choose The <strong>Member</strong>";
        }
        if ($cat == 0) {
          
            $formErrors[] = "You Must Choose The <strong>Category</strong>";
        }

        // Loop In To Errors Array And Echo It

        foreach ($formErrors as $error) {
          
          echo '<div class="alert alert-danger">' . $error . '</div>';

        }

        // Check If There's No Error Proceed The Update Operation

        if (empty($formErrors)) {

        // Update The Database With This Info 

        $stmt = $con->prepare("UPDATE 
                                     items 
                                  SET 
                                  Name = ?, 
                                  Description = ?, 
                                  Price = ?, 
                                  Country_Made = ?, 
                                  Status = ?,
                                  Cat_ID = ?, 
                                  Member_ID = ?,
                                  Tags = ?  
                                WHERE 
                                  item_ID = ?");
        $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

        // Echo Success Massage.

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Is Updated</div>';



        redirectHome($theMsg, 'back', 3);


        }

      } else {

        $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

         redirectHome($theMsg);

      }

      echo '</div>';

	} elseif ($do == 'Delete') {

    // Delete Member Page 

      echo '<h1 class="text-center">Delete Item</h1>';
      echo '<div class="container">';

      // check If Get Request Is Numeric And Get The Integer Value Of IT

      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

      // Select All Data Depend This ID

      $check = checkItem('item_ID', 'items', $itemid);

        // if there is Such ID Show THe Form

        if ($check > 0) {
          
          // echo 'Good This ID Is Exist';

          $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");

          $stmt->bindParam(":zid", $itemid);

          $stmt->execute();

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

          redirectHome($theMsg, 'back');

        } else {

          $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

        }

  echo '</div>';
		
	} elseif ($do == 'Approve') {

         echo '<h1 class="text-center">Approve Items</h1>';
         echo '<div class="container">';

                  /* Statment */

           // check If Get Request Item ID Is Numeric And Get The Integer Value Of IT

           // itemid // Comes From ( If ) Condition In Manage Of (a href='items.php?do=Approve&itemid=...)   

          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

          // Select All The Data Depend On This ID

          $check = checkItem('Item_ID', 'items', $itemid);

         // Select All Data Depend This ID


              if ($check > 0) {
                
               // if Find ID do This Update Down $stmt  If Not  

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                $stmt->execute(array($itemid));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

                redirectHome($theMsg, 'back');

              } else {

                $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

              }

        echo '</div>';
		
	}

	include $tpl . 'footer.php';

} else {

	header('Location: indexAdmin.php');

	exit();
}

ob_end_flush();

?>