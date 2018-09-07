<?php

ob_start();
session_start();

$pageTitle = 'Homepage';


include 'init.php';

/* 
// To Bring All Gategories Name And Use It In Li In Nave Bar Front End //

$categoris = getCat();

foreach ($categoris as $cat) {
	
	echo $cat['Name'];
}
*/
?>

<div class="container">  <!--     Copy From Categories Page      -->
  <div class="row">
  <?php
       $allItem = getAllFrom('*', 'items', 'where Approve = 1', '', 'item_ID', 'DESC');
       // If I Remove 'where Approve = 1' Will Give Me All Ads Even Not Approved
       foreach ($allItem as $item) {  
       	echo '<div class="col-sm-6 col-md-3">';
       	    echo '<div class="thumbnail item-box">';
       	      echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                echo '<img class="img-responsive" src="img.jpg" alt="" />';
                echo '<div class="caption">';
                     echo '<h3><a href="items.php?itemid=' . $item['item_ID'] . '">' . $item['Name'] . '</a></h3>';
                     echo '<p>' . $item['Description'] . '</p>';
                     echo '<div class="date">' . $item['Add_Date'] . '</div>';
                echo '</div>';
            echo '</div>';
       	echo '</div>';
       }
  ?>
  </div>
</div>

<?php

include $tpl . "footer.php";

ob_end_flush();

?>