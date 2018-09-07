<?php

/*
====================================================
== Category Page
====================================================
*/

ob_start();  // Output Buffering Start

session_start();

 $pageTitle = 'Categories'; 

if (isset($_SESSION['Username'])) {  


    include "init.php";  
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
 

	if ($do == 'Manage') { // Manage Members Page

		// echo "welcome";

    $sort = 'ASC';   // Use Variable To Sort AS Array 

    $sort_array = array('ASC', 'DESC');

    if ( isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
      
      $sort = $_GET['sort'];

    }

		$stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER BY Ordering $sort");

		$stmt2->execute();

		$cats = $stmt2->fetchAll();

    if (! empty($cats)) { ?>
         
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                 <i class="fa fa-edit"></i> Manage Categories
                  <div class="option pull-right">
                  <i class="fa fa-sort"></i> Ordering: [
                  <a class="<?php if ($sort == 'ASC') { echo 'active' ;} ?>" href="?sort=ASC">ASC</a>   |
                  <a class="<?php if ($sort == 'DESC') { echo 'active' ;} ?>" href="?sort=DESC">DESC</a> ]
                  <i class="fa fa-eye"></i> View: [
                  <span class="active" data-view="full">Full</span>   |
                  <span data-view="classic">Classic</span> ]
                        
                </div>
            </div>
        		<div class="panel-body">
		<?php

		foreach ($cats as $cat) { // Show Category Filde
			
echo "<div class='cat'>";
echo "<div class='hidden-buttons'>";
     echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
     echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
echo "</div>";
	echo "<h3>" . $cat['Name'] . "</h3>";

    echo "<div class='full-view'>";
	    echo "<p>"; 
    if($cat['Description'] == '') { echo 'This Category Has No Description'; } else { echo $cat['Description']; } echo "</p>";
	  //echo 'Ordering Is' . $cat['Ordering'] . '<br />';
    if ($cat['Visibility'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Hidden</span>'; }
    if ($cat['Allow_Comment'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i> Comment Desabled</span>'; }
    if ($cat['Allow_Ads'] == 1) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i> Ads Desabled</span>'; }
    echo "</div>";

    // Get Child Category

     $childCats = getAllFrom("*", "categories", "where Parent = {$cat['ID']}", "", "ID", "ASC");
     
     if (! empty($childCats)) {
     
     echo '<h4 class="child-head"> Child Categories</h4>';
     echo '<ul class="list-unstyled child-cats">';

        foreach ($childCats  as $c) {  
  
        echo "<li class='child-link'>
              <a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>" . $c['Name'] . "</a>
              <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'>Delete</a>
              </li>";

        }

     echo '</ul>';

      }

echo "</div>";
 echo "<hr>";

		} 

    ?>
	     </div>
     </div>
    <div>
    <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
    </div>


 <?php } else {
echo '<div class="container">';
  echo '<div class="nice-Massage">There Is No Categories To Show..!</div>';
  echo '<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>';
echo '</div>';
  } ?>

   		
		<?php

	} elseif ($do == 'Add') { ?>

      <h1 class="text-center">Add New Category</h1>
           <div class="container">
           	<form class="form-horizontal" action="?do=Insert" method="POST" />
           	<!--<input type="hidden" name="userid" value="<?php //echo $userid ;?>" />-->

           	<!-- Start Name Field -->
           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Name</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="name" class="form-control" autocomplete="off" required = "required" placeholder="Name Of The Category" />
           			</div>
           		</div>

           	<!-- Ends Name Field -->

           	<!-- Start Description Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Description</label>
           			<div class="col-sm-10 col-md-6">
           			<input type="text" name="description" class="form-control" placeholder="Describe The Category" />
           			</div>
           		</div>

           	<!-- Ends Description Field -->

           	<!-- Start Ordering Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Ordering</label>
           			<div class="col-sm-10 col-md-6">
           				<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
           			</div>
           		</div>

           	<!-- Ends Ordering Field -->

            <!-- Start Parent Category Type --> 

            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Parent?</label>
                <div class="col-sm-10 col-md-6">
                  <select name="parent">
                    <option value="0">None</option>
                    <?php
        $allCats = getAllFrom("*", "categories", "where Parent = 0", "", "ID", "DESC");

        foreach ($allCats as $cat) {
          
          echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';

        }
                    ?>
                  </select>
                </div>
              </div>

            <!-- End Parent Category Type -->

           	<!-- Start Visibility Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Visible</label>
           			<div class="col-sm-10 col-md-6">
           				<div>
           					<input id="vis-yes" type="radio" name="visibility" value="0" checked />
           					<label for="vis-yes">Yes</label>
           				</div>
           				<div>
           					<input id="vis-no" type="radio" name="visibility" value="1" />
           					<label for="vis-no">No</label>
           				</div>
           			</div>
           		</div>

           	<!-- Ends Visibility Field -->

           	<!-- Start Commenting Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Allow Commenting</label>
           			<div class="col-sm-10 col-md-6">
           				<div>
           					<input id="com-yes" type="radio" name="commenting" value="0" checked />
           					<label for="com-yes">Yes</label>
           				</div>
           				<div>
           					<input id="com-no" type="radio" name="commenting" value="1" />
           					<label for="com-no">No</label>
           				</div>
           			</div>
           		</div>

           	<!-- Ends Commenting Field -->

           	<!-- Start Ads Field -->

           		<div class="form-group form-group-lg">
           			<label class="col-sm-2 control-label">Allow Ads</label>
           			<div class="col-sm-10 col-md-6">
           				<div>
           					<input id="ads-yes" type="radio" name="ads" value="0" checked />
           					<label for="ads-yes">Yes</label>
           				</div>
           				<div>
           					<input id="ads-no" type="radio" name="ads" value="1" />
           					<label for="ads-no">No</label>
           				</div>
           			</div>
           		</div>

           	<!-- Ends Ads Field -->

           	<!-- Start Submit Botton save Field -->

           		<div class="form-group form-group-lg">
           			
           			<div class="col-sm-offset-2 col-sm-10">
           				<input type="submit" value="Add New Category" class="btn btn-primary btn-lg" />
           			</div>
           		</div>

           	<!-- Ends Submit Botton save Field -->
           	</form>
           </div>

	<?php

	} elseif ($do == 'Insert') {

		//  Insert Categories 

     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     	echo '<h1 class="text-center">Insert Category</h1>';
     	echo '<div class="container">';
     		
     		// Get Vriables From The Form 

     	
     		$name     = $_POST['name'];
     	  $desc     = $_POST['description'];
        $parent   = $_POST['parent'];
     		$order    = $_POST['ordering'];
     		$visible  = $_POST['visibility'];
     		$comment  = $_POST['commenting'];
     		$ads      = $_POST['ads'];

          // Check If Category Exist In Database

      $check = checkItem("Name", "categories", $name);

      if ($check == 1 ) {
        
        $theMsg = "<div class='alert alert-danger'>Sorry This Category Is Exist</div>";

        redirectHome($theMsg, 'back');

      } else {

     		// Insert Category Info In Database  

     		$stmt = $con->prepare("
                               INSERT INTO categories(Name, Description, Parent, Ordering, Visibility, Allow_Comment, Allow_Ads)
                               VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads) ");

     		$stmt->execute(array(

               'zname'    => $name,
               'zdesc'    => $desc,
               'zparent'  => $parent,
               'zorder'   => $order,
               'zvisible' => $visible,
               'zcomment' => $comment,
               'zads'     => $ads

          ));

     		// Echo Success Massage.

     		$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Is Inserted</div>';

            redirectHome($theMsg, 'back');

     		}

     	} else {

        echo "<div class='container'>";

     	$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

        redirectHome($theMsg, 'back');

        echo "</div>";

     	}

     	echo '</div>'; 

		
	} elseif ($do == 'Edit') {

    // check If Get Request catid Is Numeric & Get Its Integer Value 

    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    // Select All Data Depend This ID

    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

    

    $stmt->execute(array($catid));   // Execute Query

    $cat = $stmt->fetch(); // feach Function To Pring The Data To Use It 

    $count = $stmt->rowCount(); // if there is Any Chaing (The Row Count)

        // if There is Such ID Show The Form 

    if ($count > 0) { // $count = $stmt->rowCount() ?>

           <h1 class="text-center">Edit Category</h1>
           <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST" />
            <input type="hidden" name="catid" value="<?php $catid ;?>" />

            <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control"  required = "required" placeholder="Name Of The Category" value="<?php echo $cat['Name'] ?>" />
                </div>
              </div>

            <!-- Ends Name Field -->

            <!-- Start Description Field -->

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?php echo $cat['Description'] ?>" />
                </div>
              </div>

            <!-- Ends Description Field -->

            <!-- Start Ordering Field -->

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering'] ?>" />
                </div>
              </div>

            <!-- Ends Ordering Field -->

            <!-- Start Parent Category Type --> 

            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Parent?</label>
                <div class="col-sm-10 col-md-6">
                  <select name="parent">
                    <option value="0">None</option>
                    <?php
        $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "DESC");

        foreach ($allCats as $c) {
          
          echo "<option value='" . $c['ID'] . "'";
          if ($cat['Parent'] == $c['ID']) { echo 'selected' ;}
          echo ">" . $c['Name'] . "</option>";

        }
                    ?>
                  </select>
                </div>
              </div>

            <!-- End Parent Category Type -->

            <!-- Start Visibility Field -->

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visible</label>
                <div class="col-sm-10 col-md-6">
                  <div>
                    <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) { echo 'checked'; } ?> />
                    <label for="vis-yes">Yes</label>
                  </div>
                  <div>
                    <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1) { echo 'checked'; } ?> />
                    <label for="vis-no">No</label>
                  </div>
                </div>
              </div>

            <!-- Ends Visibility Field -->

            <!-- Start Commenting Field -->

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Commenting</label>
                <div class="col-sm-10 col-md-6">
                  <div>
                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo 'checked'; } ?> />
                    <label for="com-yes">Yes</label>
                  </div>
                  <div>
                    <input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) { echo 'checked'; } ?>/>
                    <label for="com-no">No</label>
                  </div>
                </div>
              </div>

            <!-- Ends Commenting Field -->

            <!-- Start Ads Field -->

              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                  <div>
                    <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) { echo 'checked'; } ?> />
                    <label for="ads-yes">Yes</label>
                  </div>
                  <div>
                    <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) { echo 'checked'; } ?>/>
                    <label for="ads-no">No</label>
                  </div>
                </div>
              </div>

            <!-- Ends Ads Field -->

            <!-- Start Submit Botton save Field -->

              <div class="form-group">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Save Category" class="btn btn-primary btn-lg" />
                </div>
              </div>

            <!-- Ends Submit Botton save Field -->
            </form>
           </div>
    
     <?php 
         
         // Else If There is No Such ID Show Error Massage. 

        } else {

          echo "<div class='container'>";

          $theMsg = "<div class='alert alert-danger'>There Is No Such ID ... !</div>";

          redirectHome($theMsg);

          echo "</div>";
        }

		
	} elseif ($do == 'Update') {

      echo '<h1 class="text-center">Update Category</h1>';
      echo '<div class="container">';

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Vriables From The Form 
        
        $id     = $_POST['catid'];
        $name   = $_POST['name'];
        $desc   = $_POST['description'];
        $order  = $_POST['ordering'];
        $parent  = $_POST['parent'];

        $visible = $_POST['visibility'];
        $comment = $_POST['commenting'];
        $ads     = $_POST['ads'];

         // Update The Database With This Info 

        $stmt = $con->prepare("UPDATE
                                     categories
                                  SET
                                  Name = ?,
                                  Description = ?,
                                  Ordering = ?,
                                  parent = ?,
                                  Visibility = ?,
                                  Allow_Comment = ?,
                                  Allow_Ads = ?
                                WHERE
                                  ID = ?");

        $stmt->execute(array($name, $desc, $order, $parent, $visible, $comment, $ads, $id));

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Is Updated</div>';

   redirectHome($theMsg, 'back');

      } else {

        // Echo Success Massage

        $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

         redirectHome($theMsg);

      }

      echo '</div>';
		
	} elseif ($do == 'Delete') {

      echo '<h1 class="text-center">Delete Category</h1>';
      echo '<div class="container">';

       // check If Get Request Catid Is Numeric And Get The Integer Value Of IT

         $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
           

         // Select All Data Depend This ID

          $check = checkItem('ID', 'categories', $catid);

              // if there is Such ID Show The Form

              if ($check > 0) {
                
                // echo 'Good This ID Is Exist';

                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

                $stmt->bindParam(":zid", $catid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

                redirectHome($theMsg, 'back');

              } else {

                $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

              }



        echo '</div>';

		
	}

	include $tpl . 'footer.php';

} else {

	header('Location: indexAdmin.php');

	exit();
}

ob_end_flush();

?>