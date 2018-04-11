<?php
/////////////////////////Edit User item
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
$pageTitle = $_SESSION['user'];
include 'int.php';
if (isset($_SESSION['user'])) {

$userID = $_SESSION['Normi_User'];
$do = isset($_GET['do']) ?strtolower($_GET['do']) : 'manage';
$_itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;

$stmt_check=$conn->prepare("SELECT * FROM item WHERE itemID=? AND member_ID=?");
$stmt_check->execute(array($_itemid,$userID));
$count = $stmt_check->rowCount();
if ($do == "edititem" && $count > 0) {
$result =	$stmt_check->fetch();
?>
<section class="ad block">
	<h1 class="text-center">Edit Item</h1>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <span style="font-size: 24px;font-weight: bold;"><?php echo $pageTitle?></span> 

        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?do=edititem&itemid=' .$result['itemID'] ?>" class="form-horizontal" enctype="multipart/form-data">
                     
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2">Item Name</label>
                       <div class="col-sm-10 col-md-8">
                             <input 
                               type="text" 
                               name="item-name" 
                               class="form-control live-name" 
                               value="<?php echo $result['name']?>" 
                               placeholder="Item Name">
                       </div>
                     </div>

                      <div class="form-group form-group-lg">
                         <label class="col-sm-2">Description</label>
                         <div class="col-sm-10 col-md-8">
                             <input 
                               type="text" 
                               name="description" 
                               class="form-control live-desc"
                               value="<?php echo $result['description']?>" 
                               placeholder="Description Of Item">
                         </div>
                       </div>

                       <div class="form-group form-group-lg">
                       <label class="col-sm-2">Price</label>
                       <div class="col-sm-10 col-md-8">
                         <input 
                           type="text"
                            name="price" 
                            class="form-control live-price" 
                            value="<?php echo $result['price']?>"
                            placeholder="price Of Item" >
                       </div>
                     </div>

                       <div class="form-group form-group-lg">
                       <label class="col-sm-2">Country Maker</label>
                       <div class="col-sm-10 col-md-8">
                         <input 
                           type="text"
                            name="maker" 
                            class="form-control" 
                            value="<?php echo $result['maker']?>" 
                            placeholder="Country Maker">
                       </div>
                     </div>

                      <div class="form-group">
                       <label class="col-sm-2">Item Img</label>
                       <div class="col-sm-10 col-md-8">
                         <input 
                           type="file"
                            name="img" 
                            class="form-control" 
                            id="itemIMGsrc"
                             >
                             <input type="hidden" name="oldimg" value="<?php echo $result['img']?>" >
                       </div>
                     </div>

                      <div class="form-group form-group-lg">
                       <label class="col-sm-2">Statue</label>
                       <div class="col-sm-10 col-md-8">
                         <select name="stat">
                           <option value="New" 
			               <?php if($result['stat']=='New'){echo "selected";}?> >
			               New</option>
			               <option value="Like New" 
			               <?php if($result['stat']=='Like New'){echo "selected";}?> >
			               Like New</option>
			               <option value="Used" 
			               <?php if($result['stat']=='Used'){echo "selected";}?> >
			               Used</option>
			               <option value="Old" 
			               <?php if($result['stat']=='Old'){echo "selected";} ?> >
			               Old</option>
                         </select>
                       </div>
                     </div>

                     <div class="form-group form-group-lg">
                       <label class="col-sm-2">Category</label>
                       <div class="col-sm-10 col-md-8">
                         <select name="category">
                         	<?php 
			                  $cats = getTable("*","category");
			                  foreach ($cats as $cat) {
			                    echo "<option value='".$cat['ID']."'";
			                if($cat['ID']==$result['category_ID']){echo "selected";}
			                    echo ">" .$cat['name'] ."</option>";
			                  }
			                ?>
                         </select>
                       </div>
                     </div>

                     <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                         <button class="btn btn-primary btn-lg" name="save">
                             <i class="fa fa-save fa-fw"></i>Save</button>
                       </div>
                     </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<?php
if (isset($_POST['save']) && $_SERVER['REQUEST_METHOD'] == "POST") {
	    $name         =  $_POST['item-name'];
      $description  =  $_POST['description'];
      $price        =  $_POST['price'];
      $maker        =  $_POST['maker'];
      $stat         =  $_POST['stat'];
      $category     =  $_POST['category'];
	    $img_name 	  =  $_FILES['img']['name'];
      $img_size	 	  =  $_FILES['img']['size'];
      $img_tmp  	  =  $_FILES['img']['tmp_name'];
      $img_type 	  =  $_FILES['img']['type'];
      $imgerror     =  $_FILES['img']['error'];
      $allowed_img_ex = array("jpeg","jpg","png","gif");

      @$check_Extetion = end(explode('.', $img_name));
      $errors =array();
	 
        if (empty($name)) {
         $errors[] = 'Item Name Field Can not Be <strong>Empty</strong>';
        } if (empty($description)) {
          $errors[] = 'Description Field Can not Be <strong>Empty</strong>';
        } if (empty($price)) {
          $errors[] = 'Price Field Can not Be <strong>Empty</strong>';
        } if (empty($maker)) {
          $errors[] = 'Country Maker Field Can not Be <strong>Empty</strong>';
        }
        if ( !empty($img_name) && !in_array(strtolower($check_Extetion) , $allowed_img_ex)) {
        $errors[] = 'This img is not allowed to to upload';
        }
      if ($img_size > 4194304) {
        $errors[] = 'Img Size is too much';
        }
   
       if (empty($errors)) {
        if ($imgerror == 4) { // didn't Choose an image !!
          $Query = "UPDATE item SET 
                          name=?, description=? , price=? , maker=? , stat=?,category_ID=?
                          WHERE itemID=?";
          $stmt =$conn->prepare($Query);
          $stmt->execute(array($name,$description,$price,$maker,$stat,$category,$_itemid));
           }


           if ($imgerror == 0) { //Choose an image
            $img_inDB = rand(0,1000000) . '_' .$img_name;
            move_uploaded_file($img_tmp, 'uploade/itemIMAges//' . $img_inDB);
            $Query = "UPDATE item SET img=? WHERE itemID=?";
             $stmt2 =$conn->prepare($Query);
            $stmt2->execute(array($img_inDB,$_itemid));
           }

          if ($stmt || $stmt2 ) {
          	header("location:profile.php");
          }

          }
          else
          {
             foreach ($errors as $err) {
              echo $err . "<br>";
            }
          }

}
}
else
{
	echo "<div class='container'>";
	echo "<br><br><br><br><br><br><br>";
		echo "<div class='alert alert-danger'>
			<strong>You don't have permession To View This Item</strong>
		</div>";
	echo "</div>";
}

}  else {
   header('location:login.php');
}
include $tpl . 'footer.php';
ob_end_flush();
  ?>