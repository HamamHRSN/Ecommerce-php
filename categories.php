<?php 
ob_start();
include 'init.php'; ?>

<?php
/* 
# To Bring Name Of All The Data #        //# Just For Test #//

echo 'Welcome To Categories Page<br>';

echo 'Your Page ID IS ' . $_GET['pageid'] . '<br>';

echo 'Your Page Name IS ' . str_replace('-', ' ', $_GET['pagename']); 
*/
?>

<div class="container">
<h1 class="text-center"><?php echo  'Show Category Items' /* str_replace('-', ' ', $_GET['pagename']) */?></h1>
                        <!--      Use It To Show The Name OF Category      -->
  <div class="row">
  <?php
  
// $category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;

    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {

        $category = intval($_GET['pageid']);

$allItem = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "item_ID", "DESC");
       // Foreach To Bring Items To The Categories Of It By Useing Function getItems
       foreach (/*getItems('Cat_ID', $_GET['pageid']) Old FUNC*/$allItem as $item) {  
       	
       	// echo $item['Name'];

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

      } else {

        $theMsg = '<div class="alert alert-danger"> You Didnt Specify Page ID ...! Please Add Page ID.</div>';

        redirectHome($theMsg);

       }

  ?>
  </div>
</div>

<?php include $tpl . "footer.php"; 
ob_end_flush();
?>