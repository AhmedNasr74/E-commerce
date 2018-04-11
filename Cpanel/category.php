<?php
/*****************************CATIGORIES PAGE*****************************************/
ob_start("ob_gzhandler");
session_start();
if (isset($_SESSION['user_loged'])) {
  $pageTitle = "Category";
  include 'int.php';

$do = isset($_GET['do']) ?strtolower($_GET['do']) : 'manage';

  if ($do == 'manage'){
    $order = 'ASC';
    if (isset($_GET['sortby']) &&(isset($_GET['sortby'])=='ASC' || isset($_GET['sortby'])=='DESC')) {
      $order =$_GET['sortby'];
    }
    $stmt = $conn->prepare("SELECT * FROM category ORDER BY ordering $order");
    $stmt->execute();
    $rows = $stmt->fetchAll(); ?>
    <h1 class="text-center">Manage Page</h1><div class="line"></div>
    <div class="container catigories">
      <div class="panel panel-default">
        <div class="panel-heading">Manage Categories
            <div class="option pull-right"><i class="fa fa-sort"></i>
              <strong style="color:#ff7979">Ordered By:</strong>[
                <a class='<?php if($order == 'ASC'){echo "active";} ?>' href="?sortby=ASC">ASC</a> |
                <a class="<?php if($order == 'DESC'){echo "active";} ?>" href="?sortby=DESC">DESC</a>]
                <strong style="color:#d63031"><span style="color: #000">||</span> View:</strong>[
                <span class="active" data-view="full">Full</span> |
                <span>Classc</span>]
            </div>
        </div>
        <div class="panel-body">
          <?php
            foreach ($rows as $cat) {
              echo "<div class='cat'>";?>
              <div class='hidden-btns'>
                  <a href='?do=edit&id=<?php echo $cat['ID']?>' class='btn btn-info'><i class='fa fa-edit'></i>Edit</a>
                  <a href='?do=delete&id=<?php echo $cat['ID']?>' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>
                </div>
                <?php
              echo '<h3>'.$cat['name'].'</h3>';
              echo "<div class='ful-view'>";
              echo "<p>";
                if(empty($cat['description'])){echo "There is no Descreption of this Category";}
                else{echo $cat['description'];}
              "</p>";
              echo "<div>";
              if ($cat['allow_coment'] == 0) {echo "<span class='comnt'><i class='fa fa-close'></i>Commenting Disapled</span>";}
              if ($cat['allow_ads'] == 0) {echo "<span class='ads'><i class='fa fa-close'></i>Ads Disapled</span>";}
              if ($cat['visibilty'] == 0) {echo "<span class='vis'><i class='fa fa-eye-slash'></i>Hidden</span>";}
              echo "</div>";
              echo "</div>";

              echo "</div>";
            }
          ?>
        </div>
      </div>
      <a class="btn btn-success" href="?do=add"><i class="fa fa-plus"></i>Add Category</a>
    </div>
    <?php
  }//end manage
    
  elseif ($do == 'edit'){
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";

    $stmt = $conn->prepare("SELECT * FROM category WHERE ID = ?  LIMIT 1");
    $stmt->execute(array($id));
    $result = $stmt->fetch();
    $count = $stmt->rowCount();
      if ($count > 0) {?>
        <h1 class="text-center">Edit Category</h1>
        <div class="line"></div>
         <div class="container">
           <form method="post" action="category.php?do=update" class="form-horizontal">
             <div class="form-group form-group-lg">
               <label class="col-sm-2">Category Name</label>
               <div class="col-sm-10 col-md-4">
                 <input type="hidden" name="id" value="<?php echo $result['ID'];?>">
                 <input type="hidden" name="oldname" value="<?php echo $result['name'];?>">
                 <input type="text" name="cat-name" class="form-control" placeholder="Category Name" value="<?php echo $result['name'];?>">
               </div>
             </div>

             <div class="form-group form-group-lg">
               <label class="col-sm-2">Description</label>
               <div class="col-sm-10 col-md-4">
                 <input type="text" name="description" class="form-control" value="<?php echo $result['description'];?>" placeholder="Description Of Category">
               </div>
             </div>

             <div class="form-group form-group-lg">
               <label class="col-sm-2">Ordering</label>
               <div class="col-sm-10 col-md-4">
                 <input type="text" name="ordering" class="form-control" value="<?php echo $result['ordering'];?>" placeholder="Rate of Category">
               </div>
             </div>

              <div class="col-sm-offset-2 checks">
                <span>
                  <input id="vis" type="checkbox" name="visibilty" <?php if($result['visibilty']==1){echo "checked";}?> >
                   <label for="vis">Visibilty</label>
                </span>
                 <span>
                   <input id="com" type="checkbox" name="allow_coment" <?php if($result['allow_coment']==1){echo "checked";}?>>
                   <label for="com">Allow Coment</label>
                 </span>
                 <span>
                   <input id="Ads" type="checkbox" name="allow_ads" <?php if($result['allow_ads']==1){echo "checked";}?>>
                   <label for="Ads">Allow Ads</label>
                 </span>

               </div>


             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-primary btn-lg" name="add"><i class="fa fa-edit add"></i>Edit</button>
               </div>
             </div>
           </form>

         </div>

        <?php
    } else  {

        echo "<div class='container c'>";
        echo '<div class="alert alert-danger">Some thing error with id!!</div>';
        echo "</div>";
      }
  }//end edit
    
  elseif ($do == 'delete'){
    
    $catid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";
    $check = checkFound('ID','category',$catid);
      if ($check>0) {
        $stmt = $conn->prepare("DELETE FROM category WHERE ID= $catid");
        
        $stmt->execute();
        echo $stmt->rowCount() . "RECORD DELETED";
      }
  }//end delete
    
  elseif ($do == 'update'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id       = $_POST['id'];
    $oldname  = $_POST['oldname'];
    $cName    = $_POST['cat-name'];
    $cDesc    = $_POST['description'];
    $crate    = $_POST['ordering'];
    $cVis     = isset($_POST['visibilty']) ? 1 : 0;
    $ccmnt    = isset($_POST['allow_coment']) ? 1 : 0;
    $cads     = isset($_POST['allow_ads']) ? 1 : 0;
    $formerror=array();
    $check = checkFound("ID","category",$id);
    if ($check > 0) {
      if (empty($cName)) {
        $formerror[] = "Name Field Can not be <strong>Empty</strong>";
      }
      if (checkFound("name","category",$cName)>0) {
        if ($cName != $oldname) {
          $formerror[] = "Sorry, This Name is <strong>Reserved</strong>";
        }
      }
      echo "<div class='container'><h1 class='text-center'>Update Category</h1>";
      foreach ($formerror as $err) {
        echo "<div class='alert alert-danger'>" . $err ."</div>";
      }
      if (empty($formerror)) {
        $q="UPDATE category SET name=?,description=?,ordering=?,visibilty=?,allow_coment=?,allow_ads=? WHERE ID =?";
      $stmt = $conn->prepare($q);
      $stmt->execute(array($cName,$cDesc,$crate,$cVis,$ccmnt,$cads,$id));
      $msg ="<div class='alert alert-success'>Category Has been Updated Successfully.....Redircting";
      redirct($msg,'category.php',4);
      }
    }
    echo "</div>";
  
    }else{
      redirct('','',0);
    }
 }//end update
    
  elseif ($do == 'add'){ ?>
    <h1 class="text-center">Add New Category</h1>
    <div class="line"></div>
     <div class="container">
       <form method="post" action="?do=insert" class="form-horizontal">
         <div class="form-group form-group-lg">
           <label class="col-sm-2">Category Name</label>
           <div class="col-sm-10 col-md-4">
             <input type="text" name="cat-name" class="form-control" placeholder="Category Name" autocomplete="off">
           </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2">Description</label>
           <div class="col-sm-10 col-md-4">
             <input type="text" name="description" class="form-control" placeholder="Description Of Category">
           </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2">Ordering</label>
           <div class="col-sm-10 col-md-4">
             <input type="text" name="ordering" class="form-control" placeholder="Rate of Category">
           </div>
         </div>

          <div class="col-sm-offset-2 checks">
            <span>
              <input id="vis" type="checkbox" name="visibilty" checked>
               <label for="vis">Visibilty</label>
            </span>
             <span>
               <input id="com" type="checkbox" name="allow_coment" checked>
               <label for="com">Allow Coment</label>
             </span>
             <span>
               <input id="Ads" type="checkbox" name="allow_ads" checked>
               <label for="Ads">Allow Ads</label>
             </span>

           </div>


         <div class="form-group">
           <div class="col-sm-offset-2 col-sm-10">
             <button class="btn btn-primary btn-lg" name="add"><i class="fa fa-plus add"></i>Add Category</button>
           </div>
         </div>
       </form>

     </div>
<?php
}//end add
    
  elseif ($do == 'insert'){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $name         =  $_POST['cat-name'];
      $description  =  $_POST['description'];
      $ordering     =  $_POST['ordering'];
      $visibilty    =  isset($_POST['visibilty']) ? 1 :0;
      $allow_coment =  isset($_POST['allow_coment']) ? 1 :0;
      $allow_ads    =  isset($_POST['allow_ads']) ? 1 :0;
      $adderrors =array();

       $check=checkFound("name","category",$name);

      if (empty($name) || $check > 0) {
        if (empty($name)) {
          $adderrors[] = 'Category Name Field Can not Be <strong>Empty</strong>';
        }elseif ($check > 0) {
          $adderrors[] = 'Sorry , This Category Name is<strong> reserved</strong>';
        }
        }


      echo '<div class="container c">';
      foreach ($adderrors as $error) {
        echo '<div class="alert alert-danger"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>' . $error . '</div>';
      }
        if (empty($adderrors)) {
          $insert = "INSERT INTO category(name,description,ordering,visibilty,allow_coment,allow_ads,Datereg)
          VALUES
          (:name,:descrep,:order,:vis,:coment,:ad,now())";
          $stmt =$conn->prepare ($insert);
          $stmt->execute(array(
              'name'    =>  $name,
              'descrep' =>  $description,
              'order'   =>  $ordering,
              'vis'     =>  $visibilty,
              'coment'  =>  $allow_coment,
              'ad'      =>  $allow_ads
          ));
          $themsg= '<div class="alert alert-success">' . $stmt->rowCount() ." Category Inserted Successfully</div>";
            redirct($themsg,'back');
        } else { redirct('','back'); }

      echo "</div>";
    }  else {
      redirct('','category.php?do=add',0);
    }
  }//end insert
    



include $tpl . 'footer.php';
} else {
  redirct('','',0);
  exit();
}
  ob_end_flush();
  ?>
