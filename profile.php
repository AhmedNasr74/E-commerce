<?php
ob_start("ob_gzhandler");  //compressing data on servrer
    session_start();
    if(isset($_SESSION['user'])){
    $pageTitle = "Profile";
    include 'int.php';
    $get_User_stmt = $conn->prepare("SELECT * FROM users WHERE usernname = ?");
    $get_User_stmt->execute(array($user_session));
    $user_info = $get_User_stmt->fetch();

?>
<h1 class="text-center">My Profile</h1>
<section class="infos block">

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                My information
            <a style="color:#fff" class="pull-right" href="setting.php">Edit</a>
            </div>
            <div class="panel-body"><div class="row">
                <div class="col-sm-9">

                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-fw fa-user"></i>
                        <span>Full Name</span> <strong>:</strong> <?php echo "<strong>".$user_info['fullname']."</strong>";  ?> 
                    </li>
                    <li>
                        <i class="fa fa-fw fa-envelope-o"></i>
                        <span>Email</span> <strong>:</strong> <?php echo "<strong>".$user_info['email']."</strong>";     ?>
                    </li>

                         <li>
                        <i class="fa fa-fw fa-phone"></i>
                        <span>Phone</span> <strong>:</strong> <?php echo "<strong>".$user_info['phone']."</strong>";   ?> 
                    </li>

                    <li>
                        <i class="fa fa-fw fa-map-marker"></i>
                        <span>Address</span> <strong>:</strong> <?php echo "<strong>".$user_info['address']."</strong>";     ?>
                    </li>
                </ul>
                </div>
                <div class="col-sm-3">
                  <img style="width: 100%;max-height: 200px" src="<?php echo $img_src?>">
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="my-ads block">

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>My Ads</strong>
                <span class="pull-right"><a style="color: #fff" href="ad.php">Add Item</a></span>
                <?php 
                    $userITEMS = getitems("member_ID",$user_info['userID'],1);
                ?>
            </div>
            <div class="panel-body">
                <?php
                $img_src = 'uploade/itemIMAges//';
                    if(!empty($userITEMS)){

                    foreach($userITEMS as $userITEM){
                ?>
                 
                  <div class="col-sm-6 col-md-3">

                    <div class="thumbnail item-box">
                        
                        <span class="price-tag"><?php echo $userITEM['price'].'$' ?></span>

                      <img class="img-resposive" src="<?php echo $img_src . $userITEM['img']  ?>" alt="...">
                     
                      <div class="caption">
                        <?php 
                            if ($userITEM['aprov'] == 0 ) {

                                echo "<div class='approve'>Not Approved !</div>";
                            }
                         ?>
                        <h3>
                        <a href="items.php?itemid=<?php echo $userITEM['itemID'] ?>"><?php echo $userITEM['name'] ?></a></h3>
                        <p><?php echo $userITEM['description'] ?></p>

                        <p class="date"><?php echo $userITEM['add_date'] ?></p>

                        <p class="btns ">
                            <a href="Edit.php?do=edititem&itemid=<?php echo $userITEM['itemID']?>" class="btn btn-success" role="button">
                                <i class="fa fa-edit"></i>
                            Edit</a> 
                            <a href="del_item.php?id=<?php echo $userITEM['itemID']?>" class="btn btn-danger confirm" role="button"><i class="fa fa-close"></i>
                            Delete</a>
                        </p>
                      </div>
                    </div>
                  </div>
       
                <?php }
                    }
                    else
                    {
                        echo "<div class='alert alert-info'>You Don't Have Any Items yet </div>";
                        echo "<a href='ad.php'>Add New Ad</a>";
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="my-comnt block">

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Latest Comments
            </div>
            <div class="panel-body">
<?php
$Query="SELECT comment FROM comment WHERE user_id=? ";
$stmt = $conn->prepare($Query);
$stmt->execute(array($user_info['userID']));
$rows = $stmt->fetchAll();
if(!empty($rows)){
    foreach($rows as $row)
    {
        echo "<p>" . $row['comment'] . "</p>";
    }
}
else{
    echo "No Comments";
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










