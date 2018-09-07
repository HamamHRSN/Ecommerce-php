<?php

ob_start();

session_start();

$pageTitle = 'Create New Ads';

include 'init.php';

if (isset($_SESSION['user'])) {

  // print_r($_SESSION);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
     // echo $_POST['name'] . '<br>';
     // echo $_POST['description'] . '<br>';

    $formErrors = array();

      $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
      $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
      $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
      $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
      $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

      if (strlen($name) < 4) {
        
         $formErrors[] = 'Item Title Must Be Larger Than 4 Characters';

      }
      if (strlen($desc) < 10) {
        
         $formErrors[] = 'Item Description Must Be Larger Than 10 Characters';

      }
      if (strlen($country) < 1) {
        
         $formErrors[] = 'Item Title Must Be Larger Than 1 Characters';

      }
      if (empty($price)) {
        
         $formErrors[] = 'Price Must Be Not Empty';

      }
      if (empty($status)) {
        
         $formErrors[] = 'Status Must Be Not Empty';

      }
      if (empty($category)) {
        
         $formErrors[] = 'Category Must Be Not Empty';

      }
      
      // Check If There's No Error Proceed The Update Operation

      if (empty($formErrors)) {

      // Insert User Info In Database  

      $stmt = $con->prepare("
                             INSERT INTO 
                             items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, Tags)
                             VALUES
                             (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcategory, :zmember, :ztags)");

      $stmt->execute(array(

             'zname'      => $name,
             'zdesc'      => $desc,
             'zprice'     => $price,
             'zcountry'   => $country,
             'zstatus'    => $status,
             'zcategory'  => $category,
             'zmember'    => $_SESSION['uid'],
             'ztags'      => $tags
             
        ));

          // Echo Success Massage.

          if ($stmt) {
            
            $successMsg = 'Item Has Been Added';

          }

      }

  }

?>

<?php // echo 'Welcome ' . $_SESSION['user']; ?>

<h1 class="text-center">Create New Ads</h1>

<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Create New Ads</div>
  			<div class="panel-body">
          <div class="row">
            <div class="col-md-8">
                 <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" />

              <!-- Start Name Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10 col-md-9">
                  <input
                         pattern=".{4,}"
                         title="This Field Required More Than 4 Characters" 
                         type="text" 
                         name="name" 
                         class="form-control live" 
                         required
                         placeholder="Name Of The Item"
                         data-class=".live-title" />
                  </div>
                </div>

              <!-- Ends Name Field -->

              <!-- Start Description Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-10 col-md-9">
                  <input 
                         pattern=".{10,}"
                         title="This Field Required More Than 10 Characters"
                         type="text" 
                         name="description" 
                         class="form-control live" 
                         required 
                         placeholder="Description Of The Item"
                         data-class=".live-desc" />
                  </div>
                </div>

              <!-- Ends Description Field -->

              <!-- Start Price Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Price</label>
                  <div class="col-sm-10 col-md-9">
                  <input 
                         type="text" 
                         name="price" 
                         class="form-control live" 
                         required 
                         placeholder="Price Of The Item"
                         data-class=".live-price" />
                  </div>
                </div>

              <!-- Ends Price Field -->

              <!-- Start Country Made Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Country Of Made</label>
                  <div class="col-sm-10 col-md-9">
                  <input type="text" 
                         name="country" 
                         class="form-control" 
                         required 
                         placeholder="Country Of Made " />
                  </div>
                </div>

              <!-- Ends Country Made Field -->

              <!-- Start Status Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10 col-md-9">
                    <select name="status" required>
                       <option value="">...</option>
                       <option value="1">New</option>
                       <option value="2">Like New</option>
                       <option value="3">Used</option>
                       <option value="4">Very Old</option>
                    </select>
                  </div>
                </div>

              <!-- Ends Status Field -->

              <!-- Start Categories Field -->

                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10 col-md-9">
                    <select name="category" required>
                       <option value="">...</option>
                       <?php

                       $cats = getAllFrom('*', 'categories', '', '', 'ID', 'DESC');

                       /*

                       // To pring User And Let hem Add The Item In Hes Name  

                       $stmt2 = $con->prepare("SELECT * FROM categories");
                       $stmt2->execute();
                       $cats = $stmt2->fetchAll();

                       */

                       foreach ($cats as $cat) {
                        
                              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

                       }

                       ?>
                    </select>
                  </div>
                </div>

              <!-- Ends Categories Field -->

               <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-9">
                <input type="text" 
                       name="tags" 
                       class="form-control" 

                       placeholder="Separate Tags With Comma (,)"/>
                </div>
              </div>

            <!-- Ends Tags Field -->

              <!-- Start Submit Botton save Field -->

                <div class="form-group form-group-lg">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
                  </div>
                </div>

              <!-- Ends Submit Botton save Field -->
              </form>
            </div>

              <div class="col-md-4">
                  <div class="thumbnail item-box live-preview">
                    <span class="price-tag">
                      $<span class="live-price">0</span>
                    </span>
                    <img class="img-responsive" src="img.jpg" alt="" />
                    <div class="caption">
                         <h3 class="live-title">Title</h3>
                         <p class="live-desc">Description</p>
                    </div>
                 </div>
              </div>

        </div>

        <!-- Start Looping Through Errors -->
        <?php
            
            if (! empty($formErrors)) {
              
              foreach ($formErrors as $error) {
                
                 echo '<div class="alert alert-danger">' . $error . '</div>';
              }

            }

           if (isset($successMsg)) {
            
            echo '<div class="alert alert-success">' . $successMsg . '</div>' ;
          }

        ?>
        <!-- End Looping Through Errors -->
			</div>	
		</div>
	</div>
</div>

<?php

} else {


	header('Location: login.php');

	exit();

}

include $tpl . "footer.php";

ob_end_flush();

?>