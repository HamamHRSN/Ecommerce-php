<?php


function lang( $phrase ) {

   static $lang = array(
     
     'MASSAGE' => 'رسالة',

     'ADMIN' => 'الادارة'

   	);

   return $lang[$phrase];

}


/*
$lang = array(

	'Hamam' => 'Hamou'

	);

echo $lang['Hamam'];
*/