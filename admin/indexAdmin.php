<?php
session_start();
// print_r($_SESSION);

$noNavbar = ''; // Class No Navbar: To Remove Or Keep The Navbar From Pages I Use Now From Bootstrap

$pageTitle = 'Login';

if (isset($_SESSION['Username'])) {
	
	header('Location: dashboard.php'); // Redirect To Dashboard Page

	// If I Comment This Header Will Keep Me In Login Page But I Enter To The Controle Page   
}

include 'init.php';

//include $tpl . 'head.php';

//include 'includes/languages/english.php';


   // Check If User Coming From HTTP POST Request 

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);  // Safty For Password  # sha1($var);

		// echo $username . ' ' . $hashedPass;

		// Check If User Exist In Database 

        /* Statment */
		$stmt = $con->prepare("SELECT
		                            UserID, Username, Password 
			                     FROM 
			                         users 
			                    WHERE 
			                         Username = ? 
			                      AND 
			                         Password = ? 
			                      AND 
			                         GroupID = 1
			                      LIMIT 1");

		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch(); // feach Function To Pring The Data To Use It 
		$count = $stmt->rowCount();

		//echo $count;

		// If Count > 0 This Is Mean The Database Contain Information Record About This Username

		if ($count > 0) {

			// echo "Welcome " . $username;

			$_SESSION['Username'] = $username; // Registr Session Name 

			$_SESSION['ID'] = $row['UserID'];  // Register Session ID

			header('Location: dashboard.php'); // Redirect To Dashboard Page

			exit(); // if i leavet Open That Will Give Me An Error In Evry Condetion I Do Efter So Must Exit();
            

            //print_r($row);
		}

	}


?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
 <h4 class="text-center">Admin Login</h4>
<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
<input class="form-control input-lg" 
       type="password" 
       name="pass" 
       placeholder="Password" 
       autocomplete="new-password" />
<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" />
</form>

<?php

include $tpl . "footer.php";



?>