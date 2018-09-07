<?php

/*
===================================================
== Manage Members Pagen                          ==
== You Can Add | Edit | Delete Members From Hear ==
===================================================
*/

ob_start(); // Output Buffering Start

session_start();

 $pageTitle = 'Members'; 

if (isset($_SESSION['Username'])) {  


    include "init.php";  
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

	// Start Manage Page  

	if ($do == 'Manage') { // Manage Members Page 

    $query ='';

    if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
      
      $query = 'AND RegisterStatus = 0';

    }


     // Select All Users Except Admin

     $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
       
     // Execute The Statement

     $stmt-> execute();

     // Assign To Vriable

     $rows = $stmt->fetchAll();

     if (! empty($rows)) {
       
    ?>
		
    <h1 class="text-center">Manage Members</h1>

    <div class="container">

    <div class="table-responsive">

      <table class="main-table manage-members text-center table table-bordered">
        
        <tr>
          <td>#ID</td>
          <td>Avatar</td>
          <td>Username</td>
          <td>Email</td>
          <td>Full Name</td>
          <td>Registerd Date</td>
          <td>Control</td>
        </tr>

        <?php
         
         foreach ($rows as $row) {
           
           echo "<tr>";
              echo "<td>" . $row['UserID'] . "</td>";
              echo "<td>";
              if (empty($row['Avatar'])) { echo 'No Image';} else {
              echo "<img src='uploads/avatars/" . $row['Avatar'] . "' alt='' />";
                                                                  }
              echo "</td>";
              echo "<td>" . $row['Username'] . "</td>";
              echo "<td>" . $row['Email'] . "</td>";
              echo "<td>" . $row['FullName'] . "</td>";
              echo "<td>" . $row['Date'] . "</td>";
              echo "<td>
<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                           
          if ($row['RegisterStatus'] == 0) {
            
          echo " <a href='members.php?do=Activate&userid= " . $row['UserID'] . "' class='btn btn-info activate '><i class='fa fa-check'></i> Activate</a>";

          }
          
                    echo "</td>";
           echo "</tr>";

         }

        ?>
        <tr>
       
      </table>

      </div>
    <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"> Add New Member</i></a>
  </div>
		
		<?php  } else{

  echo '<div class="container">';
    echo '<div class="nice-Massage">There Is No Members To Show..!</div>';
    echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"> Add New Member</i></a>';
  echo '</div>';

  }  ?>

	<?php } elseif ($do == 'Add') { // Add Members Page  ?>

		 <h1 class="text-center">Add New Members</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data" />
            <!--  enctype="application/x-www-form-urlencoded"  # Default # -->

           	<!-- Start Username Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Username</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="username" class="form-control" autocomplete="off" required = "required" placeholder="Username To Login Into Shop" />
           			</div>
           		</div>

           	<!-- Ends Username Field -->

           	<!-- Start Password Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Password</label>
           			<div class="col-sm-10 col-md-6">
           			 <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password Must Be Hard & Complex" required = "required"/>
           			 <i class="show-pass fa fa-eye fa-2x"></i>
           			</div>
           		</div>

           	<!-- Ends Password Field -->

           	<!-- Start Email Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Email</label>
           			<div class="col-sm-10 col-md-6">
           				<input type="email" name="email" class="form-control" required = "required" placeholder="Email Must Be Valid" />
           			</div>
           		</div>

           	<!-- Ends Email Field -->

           	<!-- Start Full Name Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Full Name</label>
           			<div class="col-sm-10 col-md-6">
           				<input type="text" name="full" class="form-control" required = "required" placeholder=" Full Name Apear In Your Profile Page" />
           			</div>
           		</div>

           	<!-- Ends Full Name Field -->



            <!-- Start Avatar Field Upluad Image--> 

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">User Avatar</label>
                <div class="col-sm-10 col-md-6">
                  <input type="file" name="avatar" class="form-control" required = "required" />
                </div>
              </div>

            <!-- Ends Avatar Field -->



           	<!-- Start Submit Botton save Field -->

           		<div class="form-group">
           			
           			<div class="col-sm-offset-2 col-sm-10">
           				<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
           			</div>
           		</div>

           	<!-- Ends Submit Botton save Field -->
           	</form>
           </div>

     <?php


    } elseif ($do == 'Insert') {

    	//  Insert Members Page 
 
	    // echo $_POST['username'] . $_POST['password'] . $_POST['email'] . $_POST['full'];	


     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     	echo '<h1 class="text-center">Insert Members</h1>';
     	echo '<div class="container">';


      // Upluad Variable 

      $avatar = $_FILES['avatar']; 
/*
      // print_r($avatar) . '<br/>';

      echo $_FILES['avatar']['name'] . '<br/>';
      echo $_FILES['avatar']['size'] . '<br/>';
      echo $_FILES['avatar']['tmp_name'] . '<br/>';
      echo $_FILES['avatar']['type'] . '<br/>';
      echo $_FILES['avatar']['error'] . '<br/>';
*/
      $avatarName = $_FILES['avatar']['name'];
      $avatarSize = $_FILES['avatar']['size'];
      $avatarTmp  = $_FILES['avatar']['tmp_name'];
      $avatarType = $_FILES['avatar']['type'];

      // List Of Allwoed File Typed To Upload

      $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");
       
       // Get Avatar Extension

      //EX.// $string = 'Hamam.Ziad.Abdulfatah.SaadEldin.Hamou';  
      // Using End To print The Last word In Array
      // Using strtolower To return All Word In Small Letter

       $avatarExtension = strtolower(end(explode(".", $avatarName)));
/*
       if (in_array($avatarExtension, $avatarAllowedExtension)) {
         
         echo 'Good This Type Is Allowed';

    // Means The File Of The Pic Is One from my array $avatarAllowedExtension else Will not Print It
       }
*/

       // print_r($avatarExtension);
     		
     		// Get Vriables From The Form 

     	
     		$user  = $_POST['username'];
     	  $pass  = $_POST['password'];
     		$email = $_POST['email'];
     		$name  = $_POST['full'];


     		$hashPass = sha1($_POST['password']);

     		// Validate The Form

     		$formErrors = array();

     		if (strlen($user) < 4) {
     			
     			$formErrors[] = "Username Cant Be Less Than <strong>4 Characters</strong>";
     		}
     		if (strlen($user) > 20) {
     			
     			$formErrors[] = "Username Cant Be More Than <strong>20 Characters</strong>";
     		}
     		if (empty($user)) {
     			
     			$formErrors[] = "Username Cant Be <strong>Empty</strong>";
     		}
     		if (empty($pass)) {
     			
     			$formErrors[] = "Password Cant Be <strong>Empty</strong>";
     		}
     		if (empty($name)) {
     			
     			$formErrors[] = "Full Name Cant Be <strong>Empty</strong>";
     		}
     		if (empty($email)) {
     			
     		    $formErrors[] = "Email Cant Be <strong>Empty</strong>";
     		}

        if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
         
            $formErrors[] = "This Extension Is Not <strong>Allwoed</strong>";
        }
        if (empty($avatarName)) {
         
            $formErrors[] = "Avatar Is <strong>Required</strong>";
        }
        if ($avatarSize > 4194304) {

        // We Have 1024 pet and We Need 4 MG ,So , 1024x4= (4096) x 1024 = 4194304 In Pit
        // This Calcolate To Know The Size Of Avatar Will Not Be More Than 
         
            $formErrors[] = "Avatar Cant Be Larger <strong>4MB</strong>";
        }

     		// Loop In To Errors Array And Echo It

     		foreach ($formErrors as $error) {
     			
     			echo '<div class="alert alert-danger">' . $error . '</div>';

     		}

     		// Check If There's No Error Proceed The Update Operation

     		if (empty($formErrors)) {

         // echo rand(0,100000);

          $avatar = rand(0,1000000000) . '_' . $avatarName;

         // echo $avatar;

          move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

        /*
        **  $avatarTmp is The diraction Of The Avatar Pic 
        **  uploads\avatars\\ plase Of Moving The Avatar in admin 
        */

          // Check If User Exist In Database

      $check = checkItem("Username", "users", $user);

      if ($check == 1 ) {
        
        $theMsg = "<div class='alert alert-danger'>Sorry This User Is Exist</div>";

        redirectHome($theMsg, 'back');


      } else {

     		// Insert User Info In Database  

     		$stmt = $con->prepare("
                               INSERT INTO 
                               users(Username, Password, Email, FullName, RegisterStatus, Date, Avatar)
                               VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar)");

     		$stmt->execute(array(

               'zuser' => $user,
               'zpass' => $hashPass,
               'zmail' => $email,
               'zname' => $name,
             'zavatar' => $avatar

          ));

     		// Echo Success Massage.

     		$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Is Inserted</div>';

        redirectHome($theMsg, 'back');

     		    }

         }

     	} else {

        echo "<div class='container'>";

     		$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

        redirectHome($theMsg, 'back');

        echo "</div>";

     	}

     	echo '</div>'; 


	} elseif ($do == 'Edit') {
		
		// Edit Page 
		//echo "Welcome To Edit Page Your Id Is " . $_GET['userid']; 

	   /* 
	   if ( isset($_GET['userid']) && is_numeric($_GET['userid'])) {  // safty to return numeric Get

             echo intval($_GET['userid']);

		} else {

			echo 0;
		} 

		*/

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		// echo $userid; 

		        /* Statment */
     // check If Get Request userid Is Numeric And Get The Integer Value Of IT

		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

		// Select All Data Depend This ID

		$stmt->execute(array($userid));   // Execute Query
		$row = $stmt->fetch(); // feach Function To Pring The Data To Use It 
		$count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

        // if There is Such ID Show The Form 

		if ($count > 0) { // $count = $stmt->rowCount() ?>

           <h1 class="text-center">Edit Members</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Update" method="POST" />
           	<input type="hidden" name="userid" value="<?php echo $userid ;?>" />

           	<!-- Start Username Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Username</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="username" class="form-control" value="<?php echo $row['Username'];?>" autocomplete="off" required = "required" />
           			</div>
           		</div>

           	<!-- Start Username Field -->

           	<!-- Start Password Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Password</label>
           			<div class="col-sm-10 col-md-6">
           			 <input type="hidden" name="oldpassword" value="<?php echo $row['Password'];?>" />
           			 <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change "/>
           			</div>
           		</div>

           	<!-- Start Password Field -->

           	<!-- Start Email Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Email</label>
           			<div class="col-sm-10 col-md-6">
           				<input type="email" name="email" value="<?php echo $row['Email'];?>" class="form-control" required = "required"/>
           			</div>
           		</div>

           	<!-- Start Email Field -->

           	<!-- Start Full Name Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Full Name</label>
           			<div class="col-sm-10 col-md-6">
           				<input type="text" name="full" value="<?php echo $row['FullName'];?>" class="form-control" required = "required"/>
           			</div>
           		</div>

           	<!-- Start Full Name Field -->

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

     	echo '<h1 class="text-center">Update Members</h1>';
     	echo '<div class="container">';

     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     		
     		// Get Vriables From The Form 

     		$id    = $_POST['userid'];
     		$user  = $_POST['username'];
     		$email = $_POST['email'];
     		$name  = $_POST['full'];

     		//================// Password Trick //==================//

     		$pass = empty($_POST['newpassword']) ? empty($_POST['oldpassword']) : sha1($_POST['newpassword']);

     		/*

     		if (empty($_POST['newpassword'])) { // if write password will record It Else Will Return Old Password
     			
     			$pass = $_POST['oldpassword'];  // old Password 

     		} else {

     			$pass = sha1($_POST['newpassword']);
     		}

     		// echo $id . $user . $email . $name;

     		*/

     		// Validate The Form

     		$formErrors = array();

     		if (strlen($user) < 4) {
     			
     			$formErrors[] = "<div class='alert alert-danger'>Username Cant Be Less Than <strong>4 Characters</strong></div>";
     		}
     		if (strlen($user) > 20) {
     			
     			$formErrors[] = "<div class='alert alert-danger'>Username Cant Be More Than <strong>20 Characters</strong></div>";
     		}
     		if (empty($user)) {
     			
     			$formErrors[] = "<div class='alert alert-danger'>Username Cant Be <strong>Empty</strong></div>";
     		}
     		if (empty($name)) {
     			
     			$formErrors[] = "<div class='alert alert-danger'>Full Name Cant Be <strong>Empty</strong></div>";
     		}
     		if (empty($email)) {
     			
     		    $formErrors[] = "<div class='alert alert-danger'>Email Cant Be <strong>Empty</strong></div>";
     		}

     		// Loop In To Errors Array And Echo It

     		foreach ($formErrors as $error) {
     			
     			echo $error ;
     		}

     		// Check If There's No Error Proceed The Update Operation

     		if (empty($formErrors)) {


          $stmt2 = $con->prepare("SELECT 
                                         * 
                                    FROM 
                                        users 
                                  WHERE 
                                        Username = ? 
                                    AND 
                                        UserID != ?");

          $stmt2->execute(array($user, $id));

          $count = $stmt2->rowCount();

         //  echo $count;

          if ($count == 1) {
            
            echo '<div class="alert alert-danger">Sorry This User Is Exist</div>';

            redirectHome($theMsg, 'back');

          } else {

            // Update The Database With This Info 

        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
        $stmt->execute(array($user, $email, $name, $pass, $id));

        // Echo Success Massage.

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Is Updated</div>';



        redirectHome($theMsg, 'back', 3);

          }

     		}

     	} else {

     		$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

         redirectHome($theMsg);

     	}

     	echo '</div>';
     	
     } elseif ($do =='Delete') {
       
       // Delete Member Page 

      echo '<h1 class="text-center">Delete Members</h1>';
      echo '<div class="container">';

       // echo 'Welcome To Delete Page';

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

          // echo $userid; 

                  /* Statment */
           // check If Get Request Is Numeric And Get The Integer Value Of IT

          // $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

          $check = checkItem('userid', 'users', $userid);

         //echo $check;

         // Select All Data Depend This ID

         // $stmt->execute(array($userid));   // Execute Query

         // $row = $stmt->fetch(); // feach Function To Pring The Data To Use It 

         // $count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

              if ($check > 0) {
                
                // echo 'Good This ID Is Exist';

                $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

                $stmt->bindParam(":zuser", $userid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

                redirectHome($theMsg, 'back');

              } else {

                $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

                redirectHome($theMsg);

              }



        echo '</div>';

     } elseif ($do == 'Activate') {

       // echo "Activate";

         echo '<h1 class="text-center">Activate Members</h1>';
         echo '<div class="container">';

       // echo 'Welcome To Delete Page';

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                  /* Statment */
           // check If Get Request Is Numeric And Get The Integer Value Of IT


          $check = checkItem('userid', 'users', $userid);

         // Select All Data Depend This ID


              if ($check > 0) {
                
                // echo 'Good This ID Is Exist';

                $stmt = $con->prepare("UPDATE users SET RegisterStatus = 1 WHERE UserID = ?");

                $stmt->execute(array($userid));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

                redirectHome($theMsg);

              } else {

                $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

              }

        echo '</div>';

     } 
	

	include $tpl . 'footer.php'; 

} else {    

   header('Location: indexAdmin.php'); // Direct Will Transfer Me To Login Page 

   exit(); // Efter Evry Header Must Be Exit Always...

}

ob_end_flush(); // Release The Output