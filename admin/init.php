<?php

include 'connect.php';

// Routes

$tpl  = 'includes/templates/'; // Tempalte Directory

$lang = 'includes/languages/'; // Language Directory

$func = 'includes/functions/'; // Functions Directory

$css  = 'layout/css/';  // Css Directory

$js   = 'layout/js/';   // Js Directory




// Include The Important Files



include $lang . 'english.php';

include $func . 'functions.php';

include $tpl . 'head.php';





// Include Navbar On All Pages Exccept The One With $noNavbar Variable

    if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }


