<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
$pageTitle = "Add To Card";
include 'int.php';
$item_ID = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$stmt  = $conn->prepare("SELECT * FROM item WHERE itemID = ?");
$stmt->execute(array($item_ID));
if ($stmt->rowCount() > 0) {
$item = $stmt->fetch();
$img_src = 'uploade/itemIMAges//';

?>

<div class="container">
	<h1 class="text-center"><?php echo $item['name']; ?></h1>

	<div class="col-md-3">
		<img class="img-resposive img-thumbnail center-block" src="<?php echo $img_src . $item['img']?>">
	</div>

<div class="col-md-9 buy-form">
	
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?itemid=' .$item['itemID'] ?>" class="form-horizontal" enctype="multipart/form-data">

         <div class="form-group">
               <label class="col-sm-2">Full Name</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="text" 
                       name="name" 
                       class="form-control" 
                       placeholder="Full Name">
               </div>
          </div>

          <div class="form-group">
               <label class="col-sm-2">Phone</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="number" 
                       name="phone1" 
                       class="form-control"
						maxlength="11" 
                       placeholder="Phone">
               </div>
          </div>

            <div class="form-group">
               <label class="col-sm-2">Anthor Phone</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="number" 
                       name="phone2" 
                       class="form-control"
						maxlength="11" 
                       placeholder="Anthor Phone">
               </div>
          </div>

            <div class="form-group">
               <label class="col-sm-2">Address</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="text"
                       name="addres"
                       class="form-control"
                       placeholder="Address">
               </div>
          </div>

            <div class="form-group">
               <label class="col-sm-2">Email</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="text"
                       name="email"
                       class="form-control"
                       placeholder="Email">
               </div>
          </div>

            <div class="form-group">
               <label class="col-sm-2">Card-Number</label>
               <div class="col-sm-10 col-md-10">
                     <input 
                       type="text"
                       name="cardnum"
                       class="form-control"
                       placeholder="Card-Number"
                       maxlength="14" 
                       >
               </div>
          </div>
          <button name="buy" class="btn btn-success pull-right">Buy</button>
    </form>
</div>

<?php

if (isset($_POST['buy'])) {
	$stmt=$conn->prepare("SELECT member_ID FROM item WHERE itemID = ?");
	$stmt->execute(array($item_ID));
	$owner = $stmt->fetch();
	$customerID = isset($_SESSION['user']) ? $_SESSION['Normi_User'] : NULL;

	//form data
	$c_name  =  filter_var($_POST['name'] , FILTER_SANITIZE_STRING);
	$phone1  =  $_POST['phone1'];
	$phone2  =  $_POST['phone2'];
	$addres  =  filter_var($_POST['addres'] , FILTER_SANITIZE_STRING);
	$email   =  filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
	$cardnum =  $_POST['cardnum'];

	$formerror = array();

	if (empty($c_name)) {
	$formerror[] =   "Name Field can not be empty" ;
	}
    if (strlen($c_name) < 5 && !empty($c_name)) {
	$formerror[] =   "Name Field can not be Less Than 5 Characters" ;
	}
	if (empty($phone1)) {
	$formerror[] =  "Phone Field can not be empty" ;
	}
	if ( (strlen($phone1) != 11  || is_int($phone1) ) && (!empty($phone1))) {
	$formerror[] =   "Phone Field Must be 11 Integer Number" ;
	}
	if (empty($phone2)) {
	$formerror[] =  "Antor Phone Field can not be empty" ;
	}
	if ( (strlen($phone2) != 11  || is_int($phone2) ) && (!empty($phone2))) {
	$formerror[] =   "Antor Phone Field Must be 11 Integer Number" ;
	}
	if (empty($addres)) {
	$formerror[] =  "Address Field can not be empty" ;
	}
	if (empty($email)) {
	$formerror[] =  "Email Field can not be empty" ;
	}	
	if(filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) != true ){
    $formERRORS [] = "Your Email Isn't Valid";
    }
	if (empty($cardnum) || strlen($cardnum) != 14) {
	$formerror[] =  "Please Enter A valid Card Number" ;
	}

echo "<div class='col-md-3'></div>";
echo "<div class='col-md-9 msgs'>";
    if (!empty($formerror)) 
    {
        foreach ($formerror as $err) {
		 echo "<div class='alert alert-danger'>". $err . "</div>";
	        }
    }
    else
    {
    	$insert = "	INSERT INTO `paid_items`
    	(`customer_id`, `customer_name`, `c_phone1`, `c_phone2`, `card_num`, `email`, `address`, `itemID`, `owner_id`) VALUES
    	(:c_id, :c_name, :c_ph1, :c_ph2, :c_card, :c_email, :c_addres , :c_item, :c_owner)";
    	$stmt = $conn->prepare($insert);
    	$stmt->execute(array(
    		"c_id"=>$customerID,
    		"c_name"=>$c_name,
    		"c_ph1"=>$phone1,
    		"c_ph2"=>$phone2,
    		"c_card"=>$email,
    		"c_email"=>$cardnum,
    		"c_addres"=>$addres,
    		"c_item"=>$item_ID,
    		"c_owner" => $owner['member_ID']
    	));

    	if ($stmt) {
		  echo "<div class='alert alert-success'>You are successfully Paid This item , Please Wait Our Call</div>";
		  header ("refresh:8;url=profile.php");
    	}

    }




	echo "</div>";
}//end form control
}else {
	echo "<div class='container'><br><br><br><br><br><br><br>";
		echo "<div class='alert alert-danger'>Wrong Item !! Item Not Found</div>";
	echo "</div>";
}
echo "</div>";
include $tpl . 'footer.php';
ob_end_flush();
?>
