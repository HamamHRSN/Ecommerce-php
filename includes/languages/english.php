<?php


function lang( $phrase ) {

   static $lang = array(

   	// Dashboard Page 

   	// All The Word Writings In Navbar Lanhuages Function

     'HOME_ADMIN' => 'Home', // Excembel For Translate

     'CATEGORIES' => 'Categories', // Excembel For Translate

     'ITEMS'	  =>'Items',

     'MEMBERS'	  =>'Members',

     'COMMENTS' => 'Comments',

     'STATISTICS' =>'Statistics',

     'LOGS'		  =>'Logs',

     'Default'    => ' Manegmant'


   	);

   return $lang[$phrase];

}


/*
$lang = array(

	'Hamam' => 'Hamou'

	);

echo $lang['Hamam'];
*/