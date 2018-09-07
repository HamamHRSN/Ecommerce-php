<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
  <link rel="stylesheet" href="layout/css/font-awesome.min.css" />
  <link rel="stylesheet" href="layout/css/jquery-ui.css" />
  <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css" />
  <link rel="stylesheet" href="layout/css/frontEnd.css" />
	<title><?php echo getTitle(); ?></title>
</head>
 <body>
<div class="upper-bar">
   <div class="container text-right">

   <?php

   // Any Plase You Wanna Print Name Of The User Exsipt isset You Can Use  This Var:  $sessionUser //

   if (isset($_SESSION['user'])) {// Wrong Replaseing $_SESSION['user'] To Right $sessionUser .. With isset//?>

    <img class="my-image img-thumbnail img-circle" src="userimg.jpg" alt="" />
    <div class="btn-group my-info pull-right">
      <span class="btn dropdown-toggle" data-toggle="dropdown"> 
        <?php echo $sessionUser ?>
        <span class="caret"></span>
      </span>
        <ul class="dropdown-menu">
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="newadd.php">New Item</a></li>
          <li><a href="profile.php#my-ads">My Ads</a></li>
          <li><a href="logout.php">LogOut</a></li>
        </ul>
     
    </div>

   <?php 

  /*         // Use Them In List Item HTML //
     echo 'Welcome ' . $sessionUser . ' ';   // here You Can Use The Variable Or Right $_SESSION['user']

     echo '<a href="profile.php">My Profile</a>';

     echo ' - <a href="newadd.php">New Item</a>';

     echo ' - <a href="logout.php">LogOut</a>';
  

   $usersStatus = checkUserStatus($sessionUser);

   if ($usersStatus == 1) {

       // User Is Not Active
     
       // echo 'Your MemberShip Need Activate From Admin...!';

      }

  */
  
   } else {

   ?>
     
     <a href="login.php">
        <span class="pull-right">LogIn / SignUp</span>
     </a>

    <?php } ?>

   </div>
</div>
 <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="indexAdmin.php">HomePage</a>
                      <!--/////////////////////-->
                      <!--Just To Finsh Working-->
      <a class="navbar-brand" href="admin/dashboard.php">(((Back To Control)))</a>
                      <!--/////////////////////-->
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php

        $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");

       /* $categories = getCat(); old Using New Function getAllFrom() */

        // I can Delete The Variable $categories And Write The Name Of The Function getCat() as $cat

        foreach (/*$categories old*/ $allCats  as $cat) {  
  
        echo '<li>
<a href="categories.php?pageid=' . $cat['ID']  . /* '&pagename=' . str_replace(' ', '-', $cat['Name']) . ' */ '">
                ' . $cat['Name'] . '
              </a>
              </li>';

        }

        ?>
    </div>
  </div>
</nav>
