<?php


function lang( $phrase ) {

   static $lang = array(
     
     'MASSAGE' => 'preve',

     'ADMIN' => 'chef'

   	);

   return $lang[$phrase];

}


/*
$lang = array(

	'Hamam' => 'Hamou'

	);

echo $lang['Hamam'];
*/