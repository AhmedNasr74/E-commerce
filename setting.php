<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
$pageTitle = isset($_SESSION['user']) ? $_SESSION['user'] . "-Setting" :"Home";
include 'int.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE usernname=?") ;
$stmt->execute(array($user_session));
$user_data =  $stmt->fetch();


?>

<h1 class="text-center">Edit Settings</h1>

 <div class="container">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" 
   	class="form-horizontal" enctype="multipart/form-data">

     <div class="form-group form-group-lg">
       <label class="col-sm-2">User Name</label>
       <div class="col-sm-10 col-md-4">

         <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $user_data['usernname']; ?>" placeholder="User Name">

         <input type="hidden" name="oldname" value="<?php echo $user_data['usernname']; ?>">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Password</label>
       <div class="col-sm-10 col-md-4">

         <input type="hidden" name="oldpass" value="<?php echo $user_data['password'];?>">

         <input type="password" name="npass" class="form-control" placeholder="Leave It if you Don't want to change" autocomplete="new-password">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Email</label>
       <div class="col-sm-10 col-md-4">
         <input type="email" name="email" class="form-control" value="<?php echo $user_data['email']; ?>" placeholder="Email">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Full Name</label>
       <div class="col-sm-10 col-md-4">
         <input type="text" name="fname" class="form-control" value="<?php echo $user_data['fullname']; ?>" placeholder="Full Name">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Phone</label>
       <div class="col-sm-10 col-md-4">
         <input type="text" name="phone" class="form-control" value="<?php echo $user_data['phone']; ?>" placeholder="Phone Number">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Address</label>
       <div class="col-sm-10 col-md-4">
         <input type="text" name="adres" class="form-control" value="<?php echo $user_data['address']; ?>" placeholder="Address">
       </div>
     </div>

      <div class="form-group form-group-lg">
         <label class="col-sm-2">User Image</label>
         <div class="col-sm-10 col-md-4">
           <input type="file" name="img" class="form-control">
         </div>
       </div>

     <div class="form-group">
       <div class="col-sm-offset-2 col-sm-10">
         <button class="btn btn-primary btn-lg" name="update">
         	<i class="fa fa-save"></i>
         Save</button>
       </div>
     </div>
   </form>
   	
   	
   	 



<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$formERRORS = array();
    

   
 
    $filtered_User = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
    if(strlen($filtered_User) < 4 ){
        $formERRORS [] = 'User Name Can\'t Be Less Than 4 Characters';}
    if(($_POST['username'] != $_POST['oldname'])&&(checkFound("usernname","users",$filtered_User) > 0)){
        $formERRORS [] = 'Sorry This User Name isn\'t Availble';}
    
  $pass = empty($_POST['npass']) ? $_POST['oldpass'] : sha1($_POST['npass']);
	if(strlen($pass)  < 8){
        $formERRORS [] = 'Password Must Be Complix and More than 8 Characters';
    }

	if(isset($_POST['email'])){
    $filtered_Email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
    if(filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) != true )
        $formERRORS [] = 'Your Email Isn\'t Valid';
}

    if(isset($_POST['fname'])){
    $filtered_Name = filter_var($_POST['fname'] , FILTER_SANITIZE_STRING);
    if(strlen($filtered_Name) < 4 )
        $formERRORS [] = 'Full Name Can\'t Be Less Than 4 Characters';
}
    if(isset($_POST['phone'])){
    $phone = filter_var($_POST['phone'] , FILTER_SANITIZE_STRING);
    if(strlen($phone) < 11)
        $formERRORS [] = 'Phone Number Can\'t Be Less Than 11 Numbers';
}
    if(isset($_POST['adres'])){
    $adress = filter_var($_POST['adres'] , FILTER_SANITIZE_STRING);
    if(empty($adress))
        $formERRORS [] = 'Address Field Can\'t Be Less Empty';
}
      $img_name = $_FILES['img']['name'];
      $img_size = $_FILES['img']['size'];
      $img_tmp  = $_FILES['img']['tmp_name'];
      $img_type = $_FILES['img']['type'];
      $imgerror = $_FILES['img']['error'];
      $allowed_img_ex = array("jpeg","jpg","png","gif");
      @$check_Extetion = end(explode('.', $img_name));

     if ( !empty($img_name) && !in_array(strtolower($check_Extetion) , $allowed_img_ex)) {
        $formERRORS[] = 'This img is not allowed to to upload';
      }
      if ($img_size > 4194304) {
        $formERRORS[] = 'Img Size is too much';
      }

	if (!empty($formERRORS)) {
		  echo '<div class="erroer">';
		  foreach ($formERRORS as $err) {
		  	echo "<div class='alert alert-danger'>";
		  		echo $err;
		  	 echo '</div>';
			}
		 echo '</div>';
   		}
   		else {
        if (!isset($_FILES['img'])) { 
          $oldimg = getimg($user_session);
          $img_inDB =  $oldimg['user_img'];
        } elseif (isset($_FILES['img'])) {//that is meaning that user has choosed photo
            $img_inDB = rand(0,1000000) . '_' .$img_name;
            move_uploaded_file($img_tmp, 'uploade//' . $img_inDB);
        }
       $stmt = $conn->prepare("Update users SET usernname = ?,email=? ,fullname=? ,password=?,phone=?,address=?,user_img=? 
          WHERE usernname =?");
        $stmt->execute(array(
          $filtered_User,$filtered_Email,$filtered_Name,$pass,$phone,$adress,$img_inDB,$_SESSION['user']));
                if ($stmt) {
          $_SESSION['user'] = $filtered_User;
          $_SESSION['userIMG'] = $img_inDB;
          header("location:profile.php");

          }
      }

}
echo "</div>";
include $tpl . 'footer.php';
ob_end_flush();
?>