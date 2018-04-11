<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
if (isset($_SESSION['user_loged'])) {
  $pageTitle = 'Dashbord';
    include 'int.php';

    $num_latest = 5;
    $users =Get_LEAST("*" , "users" , "userID" ,$num_latest);
    $items =Get_LEAST("*" , "item" , "itemID" ,$num_latest);
?>

<div class="text-center">
  <h1>Dashboard</h1>
</div>

    <div class="container home">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat st-member">
                    <i class="fa fa-users"></i>
                    <div class="info">
                         Total Mebers
                    <span><?php echo
                    '<a href="members.php">'.countitems('userID','users').'</a>';?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pendeing">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        Pending Mebers
                    <span><a href="members.php?do=Manage&page=pending">
                        <?php echo checkFound("RegState",'users',0); ?>
                        </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-item">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        Total Items
                    <span><?php echo
                    '<a href="items.php">'.countitems('itemID','item').'</a>';?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-coment">
                    <i class="fa fa-comments"></i>
                    <div class="info">
                        Total Coments
                    <span><?php echo
                    '<a href="comments.php">'.countitems('coment_id','comment').'</a>';?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container seconde">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> Latest <?php echo $num_latest; ?> Users
                </div>
                <div class="panel-body">
                  <ul class="users list-unstyled">
                    <?php
                      foreach ($users as $user) {
                          $color = $user['GroupID'] == 1 ? "green" : "black";
                        echo  "<li style='color:$color'><strong>".$user['fullname'] ."</strong></li>";
                      }
                     ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-tag"></i> Latest 5 Items
                </div>
                <div class="panel-body">
                    <ul class="users list-unstyled">
                    <?php
                      foreach ($items as $item) {
                        echo  "<li><strong>".$item['name'] ."</strong></li>";
                      }
                     ?>
                    </ul>     
                </div>
            </div>
        </div>
    </div>
</div>


<?php
  include $tpl . 'footer.php';
}
else {
  header ('location: index.php');
}

ob_end_flush();
 ?>
