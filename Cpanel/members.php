<?php
ob_start("ob_gzhandler");
/*
  ===========================================================
  ==Manage users                                            =
  ==[add | edit | delete | Control room |update] from here  =
  ===========================================================
*/
session_start();
if (isset($_SESSION['user_loged'])) {
$pageTitle = 'Members';
include 'int.php';

$do = isset($_GET['do']) ?strtolower($_GET['do']) : 'manage';

//start manage [Defulte Page Of Link Member]
if ($do == 'manage') {
$EXquery = isset($_GET['page']) && ($_GET['page']=='pending') ? "AND RegState =0":'';
  $stmt = $conn->prepare("SELECT * FROM users WHERE GroupID = 0 $EXquery");
  $stmt->execute();
  $rows = $stmt->fetchAll();
    if(!empty($rows)){
?>
  <h1 class="text-center">Manage Page</h1><div class="line"></div>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table table table-striped table-bordered text-center">
          <tr>
            <td><strong>#ID</strong></td>
            <td><strong>User Name</strong></td>
            <td><strong>E-mail</strong></td>
            <td><strong>Full Name</strong></td>
            <td><strong>Regestration Time</strong></td>
            <td><strong>Controll</strong></td>
          </tr>
            <?php
              foreach ($rows as $row) {
                echo "<tr>";
                  echo "<td>". $row['userID']  ."</td>";
                  echo "<td>". $row['usernname']   ."</td>";
                  echo "<td>". $row['email']   ."</td>";
                  echo "<td>". $row['fullname']   ."</td>";
                  echo "<td>". $row['Datereg']."</td>";
                  echo '<td>
                    <a class="btn btn-primary" href="?do=edit&userid=' .$row['userID'] . '"><i class="fa fa-edit"></i>Edit</a>
                    <a class="btn btn-danger confirm" href="?do=delete&userid='.$row['userID'].'"><i class="fa fa-close"></i>Delete</a>';
                  if($row['RegState'] == 0){
                    echo '<a class="btn btn-success" href="?do=activate&userid=' .$row['userID'] . '"><i class="fa fa-paper-plane"></i>Activate</a>';
                  }
                   echo'</td>';
                echo "</tr>";
              }

             ?>
        </table>
      </div>
      <?php echo '<a class="btn btn-primary" href="?do=add"><i class="fa fa-plus"></i> New Member</a>';?>
    </div>

<?php
    }
    else
    {
        echo "<div class='container'>";
        echo '  <h1 class="text-center">Manage Page</h1><div class="line"></div>';
           echo"<div class='alert alert-info'>There is no Users !!</div>";
         echo '<a class="btn btn-primary" href="?do=add"><i class="fa fa-plus"></i> New Member</a>';

        echo "</div>";

    }
//Add Page
} 
    elseif ($do == 'add') {?>

  <h1 class="text-center">Add New Member</h1>
  <div class="line"></div>
   <div class="container">
     <form method="post" action="?do=insert" class="form-horizontal"
     enctype="multipart/form-data"><!--onsubmit="return validateForm()"-->
       <div class="form-group form-group-lg">
         <label class="col-sm-2">User Name</label>
         <div class="col-sm-10 col-md-4">
           <input type="text" name="username" class="form-control" placeholder="User Name" autocomplete="off">
         </div>
       </div>

       <div class="form-group form-group-lg">
         <label class="col-sm-2">Password</label>
         <div class="col-sm-10 col-md-4">
           <input type="password" name="pass" class="form-control" placeholder="Password" autocomplete="new-password">
         </div>
       </div>

       <div class="form-group form-group-lg">
         <label class="col-sm-2">Email</label>
         <div class="col-sm-10 col-md-4">
           <input type="email" name="email" class="form-control" placeholder="Email">
         </div>
       </div>

       <div class="form-group form-group-lg">
         <label class="col-sm-2">Full Name</label>
         <div class="col-sm-10 col-md-4">
           <input type="text" name="fname" class="form-control" placeholder="Full Name" autocomplete="off">
         </div>
       </div>

       <div class="form-group form-group-lg">
         <label class="col-sm-2">User Image</label>
         <div class="col-sm-10 col-md-4">
           <input type="file" name="img" class="form-control">
         </div>
       </div>

       <div class="col-sm-offset-2 checks">
              <span>
               <input id="admin" type="checkbox" name="add_admin">
               <label for="admin">Add As Admin</label>
              </span>
      </div>
       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
           <button class="btn btn-primary btn-lg" name="add">Add Meber</button>
         </div>
       </div>
     </form>

   </div>

<?php
//insert
}
    elseif ($do== "insert") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $name        =  $_POST['username'];
      $email       =  $_POST['email'];
      $flname      =  $_POST['fname'];
      $pass        =  $_POST['pass'];
      $chk_admin   = isset($_POST['add_admin']) ? 1 : 0;

      //get img

      $img_name = $_FILES['img']['name'];
      $img_size = $_FILES['img']['size'];
      $img_tmp  = $_FILES['img']['tmp_name'];
      $img_type = $_FILES['img']['type'];
      $imgerror = $_FILES['img']['error'];
      $allowed_img_ex = array("jpeg","jpg","png","gif");
      @$check_Extetion = end(explode('.', $img_name));
      

      $adderrors =array();

      $check=checkFound("usernname","users",$name);

      if (empty($name) || strlen($name) > 15 || strlen($name) < 5 || $check > 0) {
        if (empty($name)) {
          $adderrors[] = 'User Name Field Can not Be <strong>Empty</strong>';
        } elseif (strlen($name) < 5) {
          $adderrors[] = 'User Name Field Can not Be Less than 5 Characters';
        }elseif ($check > 0) {
          $adderrors[] = 'Sorry , This User Name is <strong>reserved</strong>';
        }else {
          $adderrors[] = 'User Name Field Can not Be More than 15 Characters';
        }
        } if (empty($email)) {
        $adderrors[] = 'Email Field Can not Be <strong>Empty</strong>';
      }
      if (empty($flname) || strlen($flname) < 10) {
        if (empty($flname)) {
          $adderrors[] = 'Full Name Field Can not Be <strong>Empty</strong>';
        }else {
          $adderrors[] = 'Full Name Field Can not Be Less Than 10 Characters';}
      }
      if (empty($pass) || strlen($pass) < 8) {
        if (empty($pass)) {
          $adderrors[] = 'Password Field Can not Be <strong>Empty</strong>';
        }else {
          $adderrors[] = 'Password Field Can not Be Less than 8 Characters';
        }
      }
      if ( !empty($img_name) && !in_array(strtolower($check_Extetion) , $allowed_img_ex)) {
        $adderrors[] = 'This img is not allowed to to upload';
      }
      if ($img_size > 4194304) {
        $adderrors[] = 'Img Size is too much';
      }

      echo '<div class="container c">';
      echo '<h1 class="text-center">Insert User</h1>';
      foreach ($adderrors as $error) {
        echo 
        '<div class="alert alert-danger"> 
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <span class="sr-only">Error:</span>' . $error . '</div>';
      }
        if (empty($adderrors)) {
          if ($imgerror == 0){
          $img_inDB = rand(0,1000000) . '_' .$img_name;
          move_uploaded_file($img_tmp, '..\uploade\\' . $img_inDB);
          }
          elseif ($imgerror == 4) {
           $img_inDB = "emptyuser.png";
          }

          $insert = "INSERT INTO users
          (usernname , password,email,fullname,RegState,GroupID,Datereg,user_img)
           VALUES
          (:username, :pass, :email, :fname,1,:postion,now(),:userimg )";
          $stmt =$conn->prepare ($insert);
          $stmt->execute(array(
            'username' => $name,
            'pass'     => sha1($pass),
            'email'    => $email,
            'fname'    => $flname,
            'postion'  => $chk_admin,
            'userimg'  => $img_inDB

          ));
          echo '<div class="alert alert-success">' . $stmt->rowCount() ." User Inserted </div>";
          redirct("",'back',6);
        }
        
      echo "</div>";
    }

else {
  redirct('','back',0);
}

}
//delete Page
elseif ($do == 'delete') {
  $ID = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : "Error";
        $check= checkFound('userID','users', $ID);
    if ($check > 0) {
      echo '<h1 class="text-center">Delete</h1><div class="line"></div>
          <div class="container">';
        $stmt = $conn->prepare("DELETE FROM users WHERE userID = ?  LIMIT 1");
        $stmt->execute(array($ID));
        $msg= "<div class='alert alert-success'><strong>User </strong> has been Deleted successfully</div>";
        redirct($msg,"back",4);
        echo "</div>";

  } else {
  redirct('',"members.php",0);
}


//edit
} elseif ($do == 'edit') {
  $_SESSION['userid'] = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : "Error";
  $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?  LIMIT 1");
  $stmt->execute(array($_SESSION['userid']));
  $result = $stmt->fetch();
  $count = $stmt->rowCount();
    if ($count > 0) {
    include $tpl . 'editform.php';

  } else  {

      echo "<div class='container c'>";
      echo '<div class="alert alert-danger">Some thing error with id!!</div>';
      echo "</div>";
    }

} elseif (($do =='activate')) {
  $ID =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : "Error";
  $check= checkFound('userID','users', $ID);
if ($check > 0) {
echo '<h1 class="text-center">Activate</h1><div class="line"></div>
    <div class="container">';
  $stmt = $conn->prepare("UPDATE users SET RegState = 1 WHERE userID = ?  LIMIT 1");
  $stmt->execute(array($ID));
  $msg= "<div class='alert alert-success'>User has been<strong> Activated </strong>successfully.........Redircting</div>";
  redirct($msg,"back",2);
  echo "</div>";
}
else {
  redirct('',"",0);
}

} elseif ($do == 'update') {
  //update
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<h1 class='text-center'>Update Member</h1>";
      $id        = $_SESSION['userid'];
      $user      = $_POST['username'];
      $oldname   = $_POST['oldname'];
      $email     = $_POST['email'];
      $fname     = $_POST['fname'];
      $pass       = empty($_POST['npass']) ? $_POST['oldpass'] : sha1($_POST['npass']);

      $img_name = $_FILES['img']['name'];
      $img_size = $_FILES['img']['size'];
      $img_tmp  = $_FILES['img']['tmp_name'];
      $img_type = $_FILES['img']['type'];
      $allowed_img_ex = array("jpeg","jpg","png","gif");
      @$check_Extetion = end(explode('.', $img_name));



      //validation
      $formerrors =array();
     
      if ( !empty($img_name) && !in_array(strtolower($check_Extetion) , $allowed_img_ex)) {
        $formerrors[] = 'This img is not allowed to to upload';
      }
      if ($img_size > 4194304) {
        $formerrors[] = 'Img Size is too much';
      }

       //Check if user not repeated in my db
      if ($user != $oldname) {
        $check = checkFound("usernname",'users',$user);
        if ($check > 0)
         {$formerrors[] = 'Sorry , This User Name is <strong>reserved</strong>';}
      }
      if (empty($user)) {
        $formerrors[] = 'User Name Field Can not Be <strong>Empty</strong>';
      }
      if (empty($email)) {
        $formerrors[] = 'Email Name Field Can not Be <strong>Empty</strong>';
      }
      if (empty($fname)) {
        $formerrors[] = 'Full Name Field Can not Be <strong>Empty</strong>';
      }
      if (strlen($user) <5) {
        $formerrors[] = 'User Name Field Can not Be Less than <strong>4 Characters</strong>';
      }
      echo '<div class="container">';
      foreach ($formerrors as $error) {
        echo '<div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>' . $error . '</div>';
      }

      if (empty($formerrors)) {
        $img_inDB = rand(0,1000000) . '_' .$img_name;
        move_uploaded_file($img_tmp, '..\uploade\\' . $img_inDB);

        $stmt = $conn->prepare("Update users SET usernname = ?,email=? ,fullname=? ,password=? , user_img=? WHERE userID =?");
        $stmt->execute(array($user,$email,$fname,$pass,$img_inDB,$id));
        $msg= '<div class="alert alert-success">Your Data Has been <strong>Updated</strong> successfully .....Redircting </div>';
        if ($_SESSION['userid'] == $_SESSION['ID']) {
          $_SESSION['user_loged'] = $user;
        }
        redirct($msg,"back",6);
      }
      echo "</div>";


  } else {
    redirct('','back',0);
  }
}


  include $tpl . 'footer.php';
} else {
  redirct("","",0);
  exit();
}

ob_end_flush();
 ?>
