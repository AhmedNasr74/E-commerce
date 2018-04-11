<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
if(isset($_SESSION['user'])){
$pageTitle = "Create New Item";
include 'int.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
$title              = filter_var($_POST['item-name'],FILTER_SANITIZE_STRING); 
$description        = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
$price              = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);  
$maker              = filter_var($_POST['maker'],FILTER_SANITIZE_STRING);  
$stat               = filter_var($_POST['stat'],FILTER_SANITIZE_STRING);  
$category           = filter_var($_POST['category'],FILTER_SANITIZE_STRING);  
$member             = $_SESSION['Normi_User'];
$img_name           = $_FILES['img']['name'];
$img_size           = $_FILES['img']['size'];
$img_tmp            = $_FILES['img']['tmp_name'];
$img_type           = $_FILES['img']['type'];
$imgerror           = $_FILES['img']['error'];
$allowed_img_ex     = array("jpeg","jpg","png","gif");
@$check_Extetion = end(explode('.', $img_name));

$form_errors = array();

if (strlen($title) < 3) {
  $form_errors []= "Item's Name Can\'t Be Less Than 4 Characters"; 
}
if (empty($description)) {
  $form_errors []= "Item's Description Can\'t Be Empty"; 
}
if (empty($maker) || strlen($maker) < 3) {
  $form_errors []= "Item's Country Maker Must Be Valid"; 
}
if (empty($price)) {
  $form_errors []= "Item's price Can\'t Be Empty"; 
}
if (filter_var($price, FILTER_VALIDATE_INT) != true) {
  $form_errors []= "Item's price Must Be Number"; 
}
if ( !empty($img_name) && !in_array(strtolower($check_Extetion) , $allowed_img_ex)) {
  $form_errors[] = 'This img is not allowed to to upload';
}
if ($img_size > 4194304) {
   $form_errors[] = 'Img Size is too much';
}
  if (empty($form_errors)) {

    $img_inDB = rand(0,1000000) . '_' .$img_name;
    move_uploaded_file($img_tmp, 'uploade//' . $img_inDB);
    $insert = "INSERT INTO item
    (name,description,price,add_date,maker,stat,img,category_ID,member_ID)
    VALUES 
    (:name , :descrip ,:price ,CURRENT_TIMESTAMP ,:make ,:stat,:zimg,:cat ,:mem)";
          
          $stmt =$conn->prepare ($insert);
          $stmt->execute(array(
            'name'     =>$title,
            'descrip'  =>$description,
            'price'    =>$price,
            'make'     =>$maker,
            'stat'     =>$stat,
            'zimg'     =>$img_inDB,
            'cat'      =>$category,
            'mem'      =>$member

          ));
          if ($stmt) {
          header('location:profile.php');
          }
        }

      echo "</div>";
    }

?>
<h1 class="text-center"><?php echo $pageTitle?></h1>
<section class="ad block">

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <span style="font-size: 24px;font-weight: bold;"><?php echo $pageTitle?></span> 

        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal" enctype="multipart/form-data">
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2">Item Name</label>
                       <div class="col-sm-10 col-md-8">
                             <input 
                               type="text" 
                               name="item-name" 
                               class="form-control live-name" 
                               placeholder="Item Name" >
                       </div>
                     </div>

                      <div class="form-group form-group-lg">
                         <label class="col-sm-2">Description</label>
                         <div class="col-sm-10 col-md-8">
                             <input 
                               type="text" 
                               name="description" 
                               class="form-control live-desc" 
                               placeholder="Description Of Item" >
                         </div>
                       </div>

                       <div class="form-group form-group-lg">
                       <label class="col-sm-2">Price</label>
                       <div class="col-sm-10 col-md-8">
                         <input 
                           type="text"
                            name="price" 
                            class="form-control live-price" 
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
                            placeholder="Country Maker" >
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
                       </div>
                     </div>

                      <div class="form-group form-group-lg">
                       <label class="col-sm-2">Statue</label>
                       <div class="col-sm-10 col-md-8">
                         <select name="stat">
                           <option value="New">New</option>
                           <option value="Like New">Like New</option>
                           <option value="Used">Used</option>
                           <option value="Old">Old</option>

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
                                echo"<option value='".$cat['ID']."'>".$cat['name']."</option>";
                              }
                            ?>
                         </select>
                       </div>
                     </div>

                     <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                         <button class="btn btn-primary btn-lg" name="add">
                             <i class="fa fa-save fa-fw"></i>Save</button>
                       </div>
                     </div>
                   </form>
                </div>
                
                <div class="col-md-4">
                 <div class="thumbnail item-box live-preview">
                    <span class="price-tag gg">0$</span>
                  <img style="width: 100%;" class="img-resposive item-image" src="<?php echo $img?>empty.png" alt="...">
                  <div class="caption">
                    <h3>Title</h3>
                    <p class="desc">Description</p>
                  </div>
                </div>
                </div>
            </div>
            <?php 
              if (!empty($form_errors)) {
                foreach ($form_errors as $error) {
                  echo "<div class='col-md-12'>";
                  echo "<div class='alert alert-danger'>" .$error . "</div>";
                  echo "</div>";
                }
              }
            ?>
        </div>
    </div>
</div>
</section>

<?php
}  else {
   header('location:login.php');
}
include $tpl . 'footer.php';
ob_end_flush();
  ?>










