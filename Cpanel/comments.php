<?php
ob_start("ob_gzhandler");
session_start();
if (isset($_SESSION['user_loged'])) {
$pageTitle = 'Comments';
include 'int.php';

$do = isset($_GET['do']) ?strtolower($_GET['do']) : 'manage';

//start manage [Defulte Page Of Link Member]
if ($do == 'manage') {
  $stmt = $conn->prepare("SELECT 
                              comment.* , item.name AS itemName , users.fullname As member 
                              From comment 
                              INNER JOIN item ON item.itemID = comment.item_id
                              INNER JOIN users ON users.userID = comment.user_id
  ");
  $stmt->execute();
  $rows = $stmt->fetchAll();
if(!empty($rows)){
?>
  <h1 class="text-center">Manage Comments</h1><div class="line"></div>
    <div class="container par">
      <div class="table-responsive">
        <table class="main-table table table-striped table-bordered text-center">
          <tr>
            <td><strong>#ID</strong></td>
            <td><strong>Comment</strong></td>
            <td><strong>Date</strong></td>
            <td><strong>Item</strong></td>
            <td><strong>User</strong></td>
            <td><strong>Controll</strong></td>
          </tr>

            <?php
              foreach ($rows as $row) {
                echo "<tr>";
                  echo "<td>". $row['coment_id']  ."</td>";
                  echo "<td><p class='comnt-boxx'>". $row['comment']   ."</p></td>";
                  echo "<td>". $row['coment date']   ."</td>";
                  echo "<td>". $row['itemName']   ."</td>";
                  echo "<td>". $row['member']."</td>";
                  echo '<td>
                    <a class="btn btn-primary" href="?do=edit&id=' .$row['coment_id'] . '"><i class="fa fa-edit"></i>Edit</a>
                    <a class="btn btn-danger confirm" href="?do=delete&id='.$row['coment_id'].'"><i class="fa fa-close"></i>Delete</a>';
                  if($row['stat'] == 0){
                    echo '<a class="btn btn-success" href="?do=aprrove&id=' .$row['coment_id'] . '"><i class="fa fa-paper-plane"></i>Activate</a>';
                  }
                   echo'</td>';
                echo "</tr>";
              }

             ?>
        </table>
      </div>
    </div>
<?php
    }
    else
    {
        echo "<div class='container'>";
         echo ' <h1 class="text-center">Manage Comments</h1><div class="line"></div>';
                echo"<div class='alert alert-info'>There is no Comments !!</div>";
        echo "</div>";

    }
}
    
elseif ($do == 'edit'){
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";

    $stmt = $conn->prepare("SELECT * FROM  comment WHERE coment_id = ?  ");
    $stmt->execute(array($id));
    $result = $stmt->fetch();
    $count = $stmt->rowCount();
      if ($count > 0) {?>
        <h1 class="text-center">Edit Comment</h1>
        <div class="line"></div>
         <div class="container">
           <form method="post" action="?do=update" class="form-horizontal">
             <div class="form-group form-group-lg">
               <label class="col-sm-2">Comment</label>
               <div class="col-sm-10 col-md-4">
                 <input type="hidden" name="id" value="<?php echo $result['coment_id'];?>">
                   <textarea name="comment" class="form-control"><?php echo $result['comment'];?></textarea>
               </div>
             </div>

            
             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-primary btn-lg" name="edit"><i class="fa fa-save add"></i>Save</button>
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

elseif ($do == 'update')
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $id           =  $_POST['id'];
      $comment      =  $_POST['comment'];
      echo '<div class="container c"> <h1 class="text-center">Update Page</h1>';
          try{
           
          $stmt =$conn->prepare("UPDATE `comment` SET `comment`=? WHERE coment_id=?");
          $stmt->execute(array($comment , $id));
          $msg='<div class="alert alert-success">' . $stmt->rowCount() ." Comment Updated.......Redircting </div>";
          redirct($msg,'back');
          }
        catch(PDOException $e)
        {
            echo  $e->getMessage();//getting error of connection

        }
      echo "</div>";
    }

else {
  redirct('','back',0);
}
}//end update
    
elseif ($do == 'aprrove'){
$ID =isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";
$check= checkFound('coment_id','comment', $ID);
    if ($check > 0) {
    echo '<h1 class="text-center">Approve</h1><div class="line"></div>
          <div class="container">';
      $stmt = $conn->prepare("UPDATE comment SET stat = 1 WHERE coment_id = ?");
      $stmt->execute(array($ID));
      $msg= "<div class='alert alert-success'>Comment<strong> Approved </strong>successfully.........Redircting</div>";
      redirct($msg,"back",4);
      echo "</div>";
    }
      else
      {
          echo "Not Found";
      }
  }//end aprrove
    
    
elseif ($do == 'delete'){
      echo "<div class='container'>";
      echo "<h1 class='text-center'>Delete</h1>";
    $ID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id'])  : "Error";
    $check = checkFound('coment_id','comment',$ID);
      if ($check>0) {
       try{
        $stmt = $conn->prepare("DELETE FROM comment WHERE coment_id=?");
        $stmt->execute(array($ID));
        $msg= "<div class='alert alert-success'>" . $stmt->rowCount() . " Item DELETED </div>";
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
    
  include $tpl . 'footer.php';
} else {
  redirct($msg,"",0);
  exit();
}

ob_end_flush();
 ?>
