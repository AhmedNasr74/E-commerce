<?php
session_start();
$pageTitle = "Login";
if (isset($_SESSION['user'])) {
  header ('location: index.php');
}
include 'int.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
if(isset($_POST['login'])){
    $user                   = $_POST['username'];
    $pass                   = $_POST['pass'];
    $hashedpass             = sha1($pass);//encript password

  //check if user is exist in database
$stmt = $conn->prepare("SELECT userID,usernname, password,user_img FROM users WHERE usernname = ? AND password = ? ");
$stmt->execute(array($user, $hashedpass));   
$userData = $stmt->fetch(); 
$count = $stmt->rowCount();
  if ($count > 0 && $userData['usernname'] == $user) {
    $_SESSION['user'] = $user;
    $_SESSION['Normi_User'] = $userData['userID'];
    $_SESSION['userIMG'] = $userData['user_img'];
    header ('location: index.php');
    exit();
  }
    }    //log in
    
elseif (isset($_POST['signup'])){    // sign UP
        $formERRORS = array();
    
    if(isset($_POST['username'])){
        $filtered_User = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
        if(strlen($filtered_User) < 4 ){
            $formERRORS [] = 'User Name Can\'t Be Less Than 4 Characters';}
        if(checkFound("usernname","users",$filtered_User) > 0){
            $formERRORS [] = 'Sorry This User Name isn\'t Availble';}
        }
    
    
    if(isset($_POST['pass'])){
        if(strlen($_POST['pass']) < 8 )
            $formERRORS [] = 'Password Must Be Complix and More than 8 Characters';
    }
    
    if(isset($_POST['email'])){
        $filtered_Email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
        if(filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) != true )
            $formERRORS [] = 'Your Email Isn\'t Valid';
    }
    
        if(isset($_POST['fullname'])){
        $filtered_Name = filter_var($_POST['fullname'] , FILTER_SANITIZE_STRING);
        if(strlen($filtered_Name) < 4 )
            $formERRORS [] = 'Full Name Can\'t Be Less Than 4 Characters';
    }
    //insert data if it is valid
    if(empty($formERRORS)){
        $insert = "INSERT INTO users(usernname , password,email,fullname,Datereg) 
                    VALUES
                    (:username, :pass, :email, :fname,now() )";
          $stmt =$conn->prepare ($insert);
          $stmt->execute(array
          (
            'username' =>$filtered_User,
            'pass'     =>sha1($_POST['pass']),
            'email'    =>$filtered_Email,
            'fname'    =>$filtered_Name
          ));
    }
}
}

elseif (isset($_SESSION['user_loged'])) {
$_SESSION['user'] = $_SESSION['user_loged'];
$stmt = $conn->prepare("SELECT userID,user_img FROM users WHERE usernname = ?");
$stmt->execute(array($_SESSION['user']));   
$userData = $stmt->fetch();
$_SESSION['Normi_User'] = $userData['userID'];
$_SESSION['userIMG'] = $userData['user_img'];
header ('location: index.php');
exit();

}



?>

<div class="container log-page">
    <h1 class="text-center"><span data-class="login" class="active">Login</span> | 
        <span data-class="signup">Sign Up</span></h1>
    
    <!--start Log in form-->
<form method="post" class="login" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
        <input class="form-control input-lg" type="text" name="username" placeholder="Type User Name" autocomplete="off">
        <input class="form-control input-lg" type="password" name="pass" placeholder="Type Password" autocomplete="new-password">
          <button class="btn btn-primary btn-block" name="login">Login</button>
</form><!--end Log in form-->

    
    
<!--start Sign UP form-->
<form method="post" class="signup" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
       <input class="form-control input-lg" type="text" name="username" placeholder="Type User Name" autocomplete="off">
       <input class="form-control input-lg" type="password" name="pass" placeholder="Type Password" autocomplete="new-password">
       <input class="form-control input-lg" type="email" name="email" placeholder="Type Email" autocomplete="off">
       <input class="form-control input-lg" type="text" name="fullname" placeholder="Type Full Name" autocomplete="off">
      <button class="btn btn-success btn-block" name="signup">Sign Up</button>
</form><!--End Sign UP form-->


<?php 
    if(!empty($formERRORS))
    {?>
        
    <div class="errors" >
        <?php
            foreach($formERRORS as $error)
            {
                echo '<div class="alert alert-danger">' .$error. '</div>';
            }
        ?>
    </div>

<?php 
    }
?>
</div>

<?php include $tpl . 'footer.php'; ?>

