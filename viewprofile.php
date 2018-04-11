<?php
ob_start("ob_gzhandler");
session_start();
include 'Cpanel/connect.php';
$userID  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ;
$stmt = $conn->prepare("SELECT * FROM `users` WHERE userID = ? ");
$stmt->execute(array($userID));
$userinfo=$stmt->fetch();
if ($stmt->rowCount() == 0) {
$pageTitle = "User-Not Found";
include 'int.php';

echo "<div class='container'><center>";
echo '<img  style="width: 25%" src="layout/images/sad.png">';
	echo "</center><div class='alert alert-danger'><h1>Not Found User !! </h1></div>";
echo "</div>";
} else { 
	
	$pageTitle = $userinfo['fullname'];
	include 'int.php';
	$itemstmt = $conn->prepare("SELECT * FROM item WHERE member_ID=?");
	$itemstmt->execute(array($userinfo['userID']));
	$items=$itemstmt->fetchAll();
	$itemSRC = "uploade/itemIMAges/";
?><!--

-->
<body class="viewbody">
<section class="viewuser">

<div class="container">
	
	<h2 class="name text-center"><?php echo $userinfo['fullname']; ?></h2>



<div class="col-md-3">
	<img src="<?php echo 'uploade/' . $userinfo['user_img']?>" class="img-responsive u_viewimg">
</div>

<div class="col-md-9">
	<div>
		<i class="fa fa-user fa-fw" aria-hidden="true"></i>
		<span class="titles">User Name </span> <strong>: </strong>
		<span class="results"><?php echo $userinfo['usernname']?></span>
	</div>

	<div class="userparts">
		<i class="fa fa-phone fa-fw" aria-hidden="true"></i>
		<span class="titles">Phone</span> <strong>: </strong>
		<span class="results"><?php echo $userinfo['phone']?></span>
	</div>

  <div class="userparts">
	<i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
	<span class="titles">Addres</span> <strong>: </strong>
	<?php $address= empty($userinfo['address']) ? "Addres Not Found" : $userinfo['address']?>
	<span class="results"><?php echo $address?></span>
  </div>

	<div class="userparts">
		<i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
		<span class="titles">Email</span> <strong>: </strong>
		<span class="results"><?php echo $userinfo['email']?></span>
	</div>
</div><!--end col-9-->


</div><!--end container-->
<div class="container">
	<div class="itemsContainer">
		<h2 class="text-center">Belongs</h2>
	</div>


	<div class="col-md-offset-1 col-md-10">
	<?php 
	if (!empty($items)) {
		foreach ($items as $item) {	
	?>
<div class="col-md-3">
	<div class="parent">
		<img src="<?php echo $itemSRC . $item['img'] ?>">

		<div class="caption">
			<h3 class="text-center"><a href="items.php?itemid=<?php echo $item['itemID']?>">
			<?php echo $item['name'] ?></a></h3>
			<div class="dataitem text-center">
				<p>Price : <?php echo $item['price'] ?>$</p>
				<p>Made in : <?php echo $item['maker'] ?></p>
				<p>Date : <?php echo $item['add_date'] ?></p>
			</div>
		</div>
	
	</div>
</div>
    <?php
     }}
     	else
     	{
     		echo '<center><i class="fa fa-frown-o fa-5x" aria-hidden="true"></i></center>';
     		echo "<h2 class='text-center'>No items here !!!</h2>";
     	}
    ?>


</div>

</section>

</body>

<?php
}
include $tpl . 'footer.php';
ob_end_flush();
  ?>
