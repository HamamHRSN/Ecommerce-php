<?php

// Error Reporting

ini_set('display_errors', 'On');   // To Show The Error 

error_reporting(E_ALL);            // To Show The Error

include 'admin/connect.php';

$sessionUser = '';    //  Use It For Sefty so If There Is Empty Session Will Put It In This Variable 

if (isset($_SESSION['user'])) {
	
	$sessionUser = $_SESSION['user'];
}

// Routes

$tpl  = 'includes/templates/'; // Tempalte Directory

$lang = 'includes/languages/'; // Language Directory

$func = 'includes/functions/'; // Functions Directory

$css  = 'layout/css/';  // Css Directory

$js   = 'layout/js/';   // Js Directory




// Include The Important Files



include $lang . 'english.php';

include $func . 'functions.php';

include $tpl . 'head.php';  // include Head And Navbar




