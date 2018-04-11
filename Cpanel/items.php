<?php
ob_start("ob_gzhandler");
session_start();
if (isset($_SESSION['user_loged'])) {
$pageTitle = 'Items';
include 'int.php';

$do = isset($_GET['do']) ? strtolower($_GET['do']) : 'manage';

  if ($do == 'manage'){
    
 $Query="SELECT item.* , 
               category.name AS CategoryName ,
                users.fullname AS Owner 
                FROM 
                item
              INNER JOIN category ON category.ID = item.category_ID
              INNER JOIN users ON users.userID = item.member_ID ORDER BY aprov ASC";
    $stmt = $conn->prepare($Query);
    $stmt->execute();
  $rows = $stmt->fetchAll(); ?>
  <h1 class="text-center">Manage Items</h1><div class="line"></div>
    <div class="">
      <div class="table-responsive">
        <table class="main-table table table-striped table-bordered text-center">
          <tr>
            <td><strong>#ID</strong></td>
            <td><strong>Name</strong></td>
            <td><strong>Description</strong></td>
            <td><strong>Price</strong></td>
            <td><strong>Date</strong></td>
            <td><strong>Maker</strong></td>
            <td><strong>Owner</strong></td>
            <td><strong>Category</strong></td>
            <td><strong>Controll</strong></td>
          </tr>
            <?php
              foreach ($rows as $row) {
                echo "<tr>";
                  echo "<td>". $row['itemID']  ."</td>";
                  echo "<td>". $row['name']   ."</td>";
                  echo "<td>". $row['description']   ."</td>";
                  echo "<td>". $row['price'].'$'."</td>";
                  $date = date_create($row['add_date']);
                  $x    = date_format($date,'g:ia \o\n l jS F Y');
                  echo "<td>".  $x ."</td>";
                  echo "<td>". $row['maker']."</td>";
                  echo "<td>". $row['Owner']."</td>";;
                  echo "<td>". $row['CategoryName']."</td>";

                  echo '<td>
                    <a class="btn btn-primary" href="?do=edit&id=' .$row['itemID'] . '"><i class="fa fa-edit"></i>Edit</a>
                    <a class="btn btn-danger confirm" href="?do=delete&id='.$row['itemID'].'"><i class="fa fa-close confirm"></i>Delete</a>';
                  if($row['aprov'] == 0){
                    echo '<a style="margin-left: 1px;"
                    class="btn btn-warning" href="?do=aprrove&id=' .$row['itemID'] . '"><i class="fa fa-check"></i>Accept</a>';
                  }
                 echo '</td>';                 
                echo "</tr>";
              }

             ?>
        </table>
      </div>
      <?php echo '<a class="btn btn-lg btn-primary pull-right" href="?do=add"><i class="fa fa-plus"></i> New Item</a>';?>
    </div>
<?php
  }//end manage
    
  elseif ($do == 'edit'){
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";

    $stmt = $conn->prepare("SELECT * FROM item WHERE itemID = ?");
    $stmt->execute(array($id));
    $result = $stmt->fetch();
    $count = $stmt->rowCount();
      if ($count > 0) { ?>
      <h1 class="text-center">Edit Item</h1>
      <div class="line"></div>
       <div class="container">
         <form method="post" action="?do=update" class="form-horizontal" enctype="multipart/form-data"><!--onsubmit="return validateForm()"-->
          <input type="hidden" name="id" value="<?php echo $id;?>">

           <div class="form-group form-group-lg">
             <label class="col-sm-2">Name</label>
             <div class="col-sm-10 col-md-4">
               <input type="text" name="name" class="form-control" autocomplete="off" value="<?php echo $result['name']; ?>">
               <input type="hidden" name="oldname" 
               value="<?php echo $result['name']; ?>">
             </div>
           </div>

           <div class="form-group form-group-lg">
             <label class="col-sm-2">Description</label>
             <div class="col-sm-10 col-md-4">
              <textarea name="description" class="form-control" placeholder="Description" ><?php echo $result['description']; ?></textarea>
             </div>
           </div>

           <div class="form-group form-group-lg">
             <label class="col-sm-2">Price</label>
             <div class="col-sm-10 col-md-4">
               <input type="text" name="price" class="form-control" value="<?php echo $result['price']; ?>">
             </div>
           </div>

           <div class="form-group form-group-lg">
             <label class="col-sm-2">Country Maker</label>
             <div class="col-sm-10 col-md-4">
               <input type="text" name="maker" class="form-control" value="<?php echo $result['maker']; ?>">
             </div>
           </div>

          <div class="form-group">
               <label class="col-sm-2">Item Img</label>
               <div class="col-sm-10 col-md-4">
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
           <div class="col-sm-10 col-md-4">
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
           <label class="col-sm-2">Member</label>
           <div class="col-sm-10 col-md-4">
             <select name="member">
                <?php 
                  $users = getTable("*","users");
                  foreach ($users as $user) {
                    echo "<option value='".$user['userID']."'";
                    if($user['userID']==$result['member_ID']){echo "selected";}
                    echo ">" .$user['fullname'] ."</option>";
                  }
                ?>
             </select>
           </div>
         </div>
                      <div class="form-group form-group-lg">
           <label class="col-sm-2">Member</label>
           <div class="col-sm-10 col-md-4">
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
               <button class="btn btn-primary btn-lg" name="update">Save</button>
             </div>
           </div>
         </form>
           <?php
           $stmt = $conn->prepare("SELECT 
                              comment.* , users.fullname As member 
                              From comment 
                              INNER JOIN users ON users.userID = comment.user_id
                              WHERE item_id = $id
  ");
  $stmt->execute();
  $rows = $stmt->fetchAll();
           if(! empty($rows)){
           ?>
          <h1 class="text-center">Manage [<?php echo $result['name']; ?>] Comments</h1>
              <div class="table-responsive">
                <table class="main-table table table-striped table-bordered text-center">
                  <tr>
                    <td><strong>Comment</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>User</strong></td>
                    <td><strong>Controll</strong></td>
                  </tr>
                    <?php
                      foreach ($rows as $row) {
                        echo "<tr>";
                          echo "<td>". $row['comment']   ."</td>";
                          echo "<td>". $row['coment date']   ."</td>";
                          echo "<td>". $row['member']."</td>";
                          echo '<td>
                            <a class="btn btn-primary" href="comments.php?do=edit&id=' .$row['coment_id'] . '"><i class="fa fa-edit"></i>Edit</a>
                            <a class="btn btn-danger confirm" href="comments.php?do=delete&id='.$row['coment_id'].'"><i class="fa fa-close"></i>Delete</a>';
                          if($row['stat'] == 0){
                            echo '<a class="btn btn-success" href="comments.php?do=aprrove&id=' .$row['coment_id'] . '"><i class="fa fa-paper-plane"></i>Activate</a>';
                          }
                           echo'</td>';
                        echo "</tr>";
                      }

                     ?>
                </table>
              </div>
    <?php } ?>
    </div>

<?php
}
  }//end edit
    
  elseif ($do == 'update'){
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $id           =  $_POST['id'];
      $name         =  $_POST['name'];
      $oldname      =  $_POST['oldname'];
      $description  =  $_POST['description'];
      $price        =  $_POST['price'];
      $maker        =  $_POST['maker'];
      $stat         =  $_POST['stat'];
      $category     =  $_POST['category'];
      $member       =  $_POST['member'];

      $img_name     =  $_FILES['img']['name'];
      $img_size     =  $_FILES['img']['size'];
      $img_tmp      =  $_FILES['img']['tmp_name'];
      $img_type     =  $_FILES['img']['type'];
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

      echo '<div class="container c">';
      foreach ($errors as $error) {
        echo '<div class="alert alert-danger"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>' . $error . '</div>';
      }
        if (empty($errors)) {
          if ($imgerror == 4) {
          $Query = "UPDATE item SET 
                          name=?, description=? , price=? , maker=? , stat=?,category_ID=?,member_ID=?
                          WHERE itemID=?";
          $stmt =$conn->prepare($Query);
          $stmt->execute(array($name,$description,$price,$maker,$stat,$category,$member,$id));          
          }

          if ($imgerror == 0) {
            $img_inDB = rand(0,1000000) . '_' .$img_name;
            move_uploaded_file($img_tmp, "..\uploade/itemIMAges\\" . $img_inDB);
            $Query = "UPDATE item SET img=? WHERE itemID=?";
             $stmt2 =$conn->prepare($Query);
            $stmt2->execute(array($img_inDB,$id));
           }
        $msg='<div class="alert alert-success">' . 1 ." Item Updated.......Redircting </div>";

        redirct($msg,'back');
}
      echo "</div>";
    }

else {
  redirct('','back',0);
}

  }//end update
    
  elseif ($do == 'delete'){
      echo "<div class='container'>";
      echo "<h1 class='text-center'>Delete Page</h1>";
    $itemID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";
    $check = checkFound('itemID','item',$itemID);
      if ($check>0) {
       try{
        $stmt = $conn->prepare("DELETE FROM item WHERE itemID=?");
        $stmt->execute(array($itemID));
        $msg= "<div class='alert alert-success'>" . $stmt->rowCount() . "Item DELETED </div>";
        redirct($msg,'back');
       }
          catch (PDOException $e) {
            echo "Faild " . $e->getMessage();//getting error of connection
      }
      }else{
          echo "<div class='alert alert-danger'>Sorry , This Item dosnot Exist</div>";
      }
      echo "</div>";
  }//end delete
    
  elseif ($do == 'aprrove'){
    $ID =isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";
  $check= checkFound('itemID','item', $ID);
if ($check > 0) {
    echo '<h1 class="text-center">Approve</h1><div class="line"></div>
          <div class="container">';
      $stmt = $conn->prepare("UPDATE item SET aprov = 1 WHERE itemID = ?  LIMIT 1");
      $stmt->execute(array($ID));
      $msg= "<div class='alert alert-success'>Item<strong> Approved </strong>successfully.........Redircting</div>";
      redirct($msg,"back",4);
      echo "</div>";
  }
      else
      {
          echo "Not Found";
      }
  }//end aprrove
    
  elseif ($do == 'add'){ ?>
  <h1 class="text-center">Add New Item</h1>
    <div class="line"></div>
     <div class="container">
       <form method="post" action="?do=insert" class="form-horizontal">
         <div class="form-group form-group-lg">
           <label class="col-sm-2">Item Name</label>
           <div class="col-sm-10 col-md-4">
                 <input 
                   type="text" 
                   name="item-name" 
                   class="form-control" 
                   placeholder="Item Name">
           </div>
         </div>

          <div class="form-group form-group-lg">
             <label class="col-sm-2">Description</label>
             <div class="col-sm-10 col-md-4">
                 
                   <textarea name="description" 
                   class="form-control" 
                   placeholder="Description Of Item"></textarea>
             </div>
           </div>

           <div class="form-group form-group-lg">
           <label class="col-sm-2">Price</label>
           <div class="col-sm-10 col-md-4">
             <input 
               type="text"
                name="price" 
                class="form-control" 
                placeholder="price Of Item">
           </div>
         </div>

           <div class="form-group form-group-lg">
           <label class="col-sm-2">Country Maker</label>
           <div class="col-sm-10 col-md-4">
             <input 
               type="text"
                name="maker" 
                class="form-control" 
                placeholder="Country Maker">
           </div>
         </div>

          <div class="form-group form-group-lg">
           <label class="col-sm-2">Statue</label>
           <div class="col-sm-10 col-md-4">
             <select name="stat">
               <option value="New">New</option>
               <option value="Like New">Like New</option>
               <option value="Used">Used</option>
               <option value="Old">Old</option>

             </select>
           </div>
         </div>

          <div class="form-group form-group-lg">
           <label class="col-sm-2">Members</label>
           <div class="col-sm-10 col-md-4">
             <select name="member">
                <?php
                  $users = getTable("*","users");
                  foreach ($users as $user) {
                    echo"<option value='".$user['userID']."'>".$user['fullname']."</option>";
                  }
                ?>
             </select>
           </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2">Category</label>
           <div class="col-sm-10 col-md-4">
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
             <button class="btn btn-primary btn-lg" name="add"><i class="fa fa-plus add"></i>Add Item</button>
           </div>
         </div>
       </form>

     </div>
<?php

  }//end add
    
  elseif ($do == 'insert'){
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $name         =  $_POST['item-name'];
      $description  =  $_POST['description'];
      $price        =  $_POST['price'];
      $maker        =  $_POST['maker'];
      $stat         =  $_POST['stat'];
      $category     =  $_POST['category'];
      $member       =  $_POST['member'];

      $adderrors =array();

      $check=checkFound("name","item",$name);

      if (empty($name) || $check > 0) {
          $adderrors[] = 'Item Name Field Can not Be <strong>Empty</strong>';
        } if (empty($description)) {
          $adderrors[] = 'Description Field Can not Be <strong>Empty</strong>';
        } if (empty($price)) {
          $adderrors[] = 'Price Field Can not Be <strong>Empty</strong>';
        } if (empty($maker)) {
          $adderrors[] = 'Country Maker Field Can not Be <strong>Empty</strong>';
        }
          echo '<h1 class="text-center">Insert item</h1>';
      echo '<div class="container c">';
      foreach ($adderrors as $error) {
        echo '<div class="alert alert-danger"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>' . $error . '</div>';
      }
        if (empty($adderrors)) {

     $insert = "INSERT INTO item
                    (name,description,price,add_date,maker,stat,aprov,category_ID,member_ID)     VALUES 
                    (:name , :descrip ,:price ,CURRENT_TIMESTAMP ,:make ,:stat,1 ,:cat ,:mem)";
          
          $stmt =$conn->prepare ($insert);
          $stmt->execute(array(
            'name'     =>$name,
            'descrip'  =>$description,
            'price'    =>$price,
            'make'     =>$maker,
            'stat'     =>$stat,
            'cat'      =>$category,
            'mem'      =>$member

          ));
          $msg='<div class="alert alert-success">' . $stmt->rowCount() ." Item Inserted </div>";
          redirct($msg,'back');
        }

      echo "</div>";
    }

else {
  redirct('','back',0);
}
  }//end insert



include $tpl . 'footer.php';
} else {
  redirct($msg,"",0);
  exit();
}
  ob_end_flush();
  ?>
