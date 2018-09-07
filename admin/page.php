<?php

/*
   Categories => [ Manage | Edit | Update | Add | Insert | Delete | Statstics ]

   Condition ? Trou : False 

*/
 
  //  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; //shortar Way//

 $do = ''; // GET Recuest Name do 

   if ( isset ($_GET['do']) ) { // i can shoos any word (like Fikra in do plase)
   	
      $do = $_GET['do'];

   } else {

   	   $do ='Manage';


   }
   // echo $do;

   // If The Page Is Main Page

   if ($do == 'Manage') {

   	    echo "Welcom You Are In Manage Category Page.";
   	    echo "<a href='page.php?do=Add'>Add New Category +</a>";
   	
   } elseif ($do == 'Add') {

     	echo "Welcom You Are In Add Category Page.";
   	
   } elseif ($do == 'Insert') {
   	
        echo "Welcom You Are In Insert Category Page.";

   } elseif ($do == 'Delete') {
   	
        echo "Welcom You Are In Insert Category Page.";

   } else {
    
    echo "Error There Is No Page With This Name..!";

   }