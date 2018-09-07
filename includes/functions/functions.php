<?php

// All Function In Front End Start From Here //

/*
 ** Get ALL Function V2.0
 ** Function To Get All Records Field From Any Table In Database  
 */

 function getAllFrom($field, $table, $where = NULL, $and = NULL, $oredrfield, $ordering = "DESC") {

 global $con;
 
 $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $oredrfield $ordering");

 $getAll->execute();

 $all = $getAll->fetchAll();

 return $all;

 // indexAdmin Page And newadd Page //

 }

/*
 ** Get ALL Function V1.0
 ** Function To Get All Records Field From Any Table In Database  
 

 function getAllFrom($tableName, $oredrBy, $where = NULL) {

 global $con;
 
 $getAll = $con->prepare("SELECT * FROM $tableName $where ORDER BY $oredrBy DESC");

 $getAll->execute();

 $all = $getAll->fetchAll();

 return $all;

 }

 // use It In IndexAdmin Page 

 $allItem = getAllFrom('items', 'item_ID', 'where Approve = 1'); 

 //

 */

/*
 ** Get ALL Function V1.0
 ** Function To Get All Records Field From Any Table In Database  
 

 function getAllFrom($tableName, $oredrBy, $where = NULL) {

 global $con;

 $sql = $where == NULL ? '' : $where;

 #short Condition# 
 //if ($where == NULL) {
 //  $sql = '';
 //} else {
 //  $sql = 'where Approve = 1'; //$sql = $where;//
 //}
 
 $getAll = $con->prepare("SELECT * FROM $tableName $sql ORDER BY $oredrBy DESC");

 $getAll->execute();

 $all = $getAll->fetchAll();

 return $all;

 }

 */

/*
 ** Get ALL Function V1.0
 ** Function To Get All Records Field From Any Table In Database  
 

 function getAllFrom($tableName, $oredrBy) {

 global $con;

 $getAll = $con->prepare("SELECT * FROM $tableName ORDER BY $oredrBy DESC");

 $getAll->execute();

 $all = $getAll->fetchAll();

 return $all;

 }

 */

/*
 ** Get Categories Function V1.0
 ** Function To Get Categories From Database  
 

 function getCat() {

 global $con;

 $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

 $getCat->execute();

 $cats = $getCat->fetchAll();

 return $cats;

 }

 #  Use It In Function getAllFrom() # 

 */

 /*
 ** Get Items Function V1.0
 ** Function To Get Items From Database 
 ** $CatID = The Value Comming From The $_GET['pageid'] 

 function getItems($CatID) {  

 global $con;

 // Use WHERE To Bring Items Just Of Each Category    

 $getItems = $con->prepare("SELECT * FROM items WHERE Cat_ID = ? ORDER BY item_ID DESC");

 $getItems->execute(array($CatID));

 $Items = $getItems->fetchAll();

 return $Items;

 }

 If I Find This Function In Any Page Must Chaing It To getAllFrom();

 */

 /*
 ** Get Items Function V2.0
 ** Function To Get AD Items From Database 
 **  

 #  Use It In Function getAllFrom() # 


 

 function getItems($where,$value, $approve = NULL) {  

 global $con;

 $sql = $approve == NULL ? 'AND Approve = 1' : ''; 

  // Short If Conditions Same Upp

  // if ($approve == NULL) { $sql = 'AND Approve = 1'; } else { $sql = NULL; } 
 
 $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY item_ID DESC");

 $getItems->execute(array($value));

 $Items = $getItems->fetchAll();

 return $Items;

 }

  */


 /*
 ** check If User Is Not Activated Function V1.0
 ** Function To check The RegisterStatus Of The User  
 */

    function checkUserStatus($user) {

      global $con;

    $stmtx = $con->prepare("SELECT
                                Username, RegisterStatus 
                           FROM 
                               users 
                          WHERE 
                               Username = ? 
                            AND 
                               RegisterStatus = 0");

    $stmtx->execute(array($user));

    $status = $stmtx->rowCount();

    return $status;

    }


#================================================================================#
// All Function In Back End Start From Here //      #  Useing For front End Too  #
#================================================================================#

/*
**  Title Function ...( version 1.0 )
**  Title Function That Echo The Page Title In Case The Page 
**  Has The Variable $pageTitle And Echo Default For Other Pages
*/

  function getTitle() {

    global $pageTitle;  // To Bring Any Varyable By Useing global Function

	    if (isset($pageTitle)) {  // If Var Here Means isset Function
	    
	         echo $pageTitle;

	       } else {


	    	echo "Default"; // Default Is The Name Is Showing On Title By Opening Pages Error
	    }

  }


  /*
  ** Home Redirect Function  ...( version 1.0 )
  ** [ This Function Accept Parameters ] 
  ** $errorMsg = Echo The Error Massage 
  ** $seconds = Seconds Before Redirecting

  function redirectHome($errorMsg, $seconds = 3) {

  	echo "<div class='alert alert-danger'>$errorMsg</div>";

  	echo "<div class='alert alert-info'>You Will Be Redirected To Home Page Efter $seconds Seconds. </div>";


  	header("refresh:$seconds;url=indexAdmin.php");

  	exit();

  }
  */

  /*
  ** Home Redirect Function  ...( version 2.0 )
  ** [ This Function Accept Parameters ] 
  ** $theMsg = Echo The Massage [ Error | Success | Warning ]
  ** $url = the Link You Want To Redirect To   
  ** $seconds = Seconds Before Redirecting
  */

  function redirectHome($theMsg, $url = null, $seconds = 3) {

    if ($url === null) {

      $url =  'indexAdmin.php';

      $link = 'Homepage';


    } else {

    /*  
      $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'indexAdmin.php'; 
    */  

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
        
        $url = $_SERVER['HTTP_REFERER'];

        $link = 'previous Page';

      } else {

         $url = 'indexAdmin.php';

         $link = 'Homepage';

      }

     // $link = 'Previous Page';

    }

    echo $theMsg;

    echo "<div class='alert alert-info'>You Will Be Redirected To $link Efter $seconds Seconds. </div>";


    header("refresh:$seconds;url=$url");

    exit();

  }

  /*
  ** Check Item Function  ...( version 1.0 )
  ** Function To Check Item In Database  [ Function Accept Parameters ]
  ** $select = The Item To Select [ Example: user, item, category] 
  ** $from = The Table To Select From [ Example: user, item, categories ]
  ** $value = The Value Of Select [ Example: hamam, box, Electronics ]
  */

 function checkItem($select, $from, $value) {

  global $con;
   
   $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

   $statement->execute(array($value));

   $count = $statement->rowCount();

   return $count;

 }


 /*
 ** Count Number Of Items (v1.0)
 ** Function To Count Number Of Items Rows
 ** $item = The Item To Count
 ** $table = The Table To Choos From
 */

 function countItems($item, $table) {

  global $con;

  $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

  $stmt2->execute();

  return $stmt2->fetchColumn();

 }

 /*
 ** Get Latest Records Function V1.0
 ** Function To Get Latest From Database [ Users, Items, Comments ]
 ** $select = Field To Select
 ** $table = The Table To Choose From
 ** $order = The DESC Ordering 
 ** $limit = Number Of Records To Get .  Limit 
 */

 function getLatest($select, $table, $order, $limit = 5) {

 global $con;

 $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

 $getStmt->execute();

 $rows = $getStmt->fetchAll();

 return $rows;

 }