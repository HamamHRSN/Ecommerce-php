<?php

ob_start();

  session_start();

  // print_r($_SESSION);

  $pageTitle = 'Login';

  if (isset($_SESSION['user'])) {
	
	header('Location: indexAdmin.php'); 
  
}

  include 'init.php';

  // Check If User Coming From HTTP POST Request 

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['login'])) {   // Use It To Know If I'm Comming From Login Or SignUp 
					
		$user = $_POST['username'];
		$pass = $_POST['password'];

		// echo $user . ' ' . $pass;

		$hashedPass = sha1($pass);  // Safty For Password  # sha1($var);

		// Check If User Exist In Database 

        /* Statment */

		$stmt = $con->prepare("SELECT
		                            UserID, Username, Password 
			                     FROM 
			                         users 
			                    WHERE 
			                         Username = ? 
			                      AND 
			                         Password = ?");

		$stmt->execute(array($user, $hashedPass));

		$get = $stmt->fetch();

		$count = $stmt->rowCount();

		//echo $count;

		// If Count > 0 This Is Mean The Database Contain Information Record About This Username

		if ($count > 0) {

			// echo "Welcome " . $user;

			$_SESSION['user'] = $user; // Registr Session Name 

			$_SESSION['uid'] = $get['UserID'];  // Register User ID In Session

	    // print_r($_SESSION);

		 header('Location: indexAdmin.php'); // Redirect To Dashboard Page

		 exit(); // if i leavet Open That Will Give Me An Error In Evry Condetion I Do Efter So Must Exit();

		    }
           
		} else {

		// $test = $_POST['username'];  // Not Sefty Cuz Any Thing Even Wrong Writing Can It Shows In Src

        $formErrors = array();

        $username = $_POST['username'];

        $password = $_POST['password'];

        $password2 = $_POST['password2'];

        $email = $_POST['email']; 

        // Keep All My Errors In This Array

	        if (isset($_POST['username'])) {

	        	// FILTER_SANITIZE_STRING = Clean & Sefe The POST Username From Any Tags
	        	
	        	$filterdUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

	        	// echo $filterdUser;

	        	if (strlen($filterdUser) < 4) {
	        		
	        		$formErrors[] = 'Username Must Be Larger Than 4 Characters ';
	        	}

	        }

	        if (isset($_POST['password']) && isset($_POST['password2'])) {

	        	if (empty($_POST['password'])) {  // Must The Check Be Before Hashed
	        		
	        		$formErrors[] = 'Sorry Password Cant Be Empty ';
	        	}
	        	
	        	$pass1 = sha1($_POST['password']);

	        	$pass2 = sha1($_POST['password2']);

	        	if ($pass1 !== $pass2) {
	        		
	        		$formErrors[] = 'Sorry Password Is Not Match ';
	        	}

	        }

	        if (isset($_POST['email'])) {

	        	// FILTER_SANITIZE_EMAIL = Clean & Sefe The POST Email From Any Tags
	        	
	        	$filterdEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	        	if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
	        		
	        		$formErrors[] = 'This Email Is Not Valid ';

	        	}

	        }

  // Check If There's No Error Proceed The Insert  (User Add)


	if (empty($formErrors)) {

      // Check If User Exist In Database

      $check = checkItem("Username", "users", $username);

      if ($check == 1 ) {
        
        $formErrors[] = 'Sorry This User Is Exists ';

      } else {

     		// Insert User Info In Database  

 		$stmt = $con->prepare("
                           INSERT INTO users(Username, Password, Email, RegisterStatus, Date)
                           VALUES(:zuser, :zpass, :zmail, 0, now()) ");

 		$stmt->execute(array(

           'zuser' => $username,
           'zpass' => sha1($password),
           'zmail' => $email

      ));

     		// Echo Success Massage.

  $successMsg = 'Congrats You Are Now Registred User';

     	  }
        
      }

		}

	}

  ?>

	<div class="container login-page">
	  <h1 class="text-center">
	        <span class="selected" data-class="login">LogIn</span> | 
	        <span data-class="signup">SignUp</span>
	  </h1>
	  <!-- Start LogIn Form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		 <div class="input-container">
			<input class="form-control" 
			        type="text" 
			        name="username" 
			        autocomplete="off" 
			        placeholder="Type UserName"
			        required="required" />
	     </div>
	     <div class="input-container">
			<input class="form-control" 
			        type="password" 
			        name="password" 
			        autocomplete="new-password"
			        placeholder="Type Password"
			        required="required" />
		</div>
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
		</form>
	  <!-- End LogIn Form -->

	  <!-- Start SignUp Form -->
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<div class="input-container">
		            <!-- pattern=".{4,8}"
			        title="Username Must Between 4 , 8 Caracters" 
			        ### From HTML5 Write It In Input 
			        ### minlength="4"  Characters --> 
			<input  pattern=".{4,}"
			        title="Username Must Be 4 Caracters" 
			        class="form-control" 
			        type="text" 
			        name="username" 
			        autocomplete="off" 
			        placeholder="Type UserName"
			         />
	    </div>
	    <div class="input-container">
			<input class="form-control" 
			        type="password" 
			        name="password" 
			        autocomplete="new-password"
			        placeholder="Type a Complex Password"
			         />
	    </div>
	    <div class="input-container">
			<input class="form-control" 
			        type="password" 
			        name="password2" 
			        autocomplete="new-password"
			        placeholder="Type Password Again"
			         />
	    </div>
	    <div class="input-container">
			 <input class="form-control" 
			        type="email" 
			        name="email" 
			        autocomplete="off"
			        placeholder="Type a Valid Email"
			         />
		</div>
			<input class="btn btn-success btn-block" name="signup" type="submit" value="signup" />
		</form>
		<!-- End SignUp Form -->

		<div class="the-errors text-center">
      	   <?php  // echo $test ; //

      	   if (! empty($formErrors)) {
      	   	
      	   	foreach ($formErrors as $error) {
      	   		
      	   		echo '<div class="msg error">' . $error . '</div>';
      	   	}

      	  }

      	  if (isset($successMsg)) {
      	  	
      	  	echo '<div class="msg success">' . $successMsg . '</div>' ;
      	  }

      	     ?>
        </div>

	  </div>
        
  <?php

   include $tpl . 'footer.php';

   ob_end_flush();

  ?>