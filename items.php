<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
include 'Cpanel/connect.php';
$pageTitle = "Items";

$itemID  = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? 
							intval($_GET['itemid']) :0;
$stmt = $conn->prepare("SELECT 
							item.* ,category.name AS cat_name,
							users.usernname
							FROM item 
			              INNER JOIN category ON category.ID = item.category_ID
			              INNER JOIN users ON users.userID = item.member_ID	
			              WHERE itemID = ?
			              AND 
			              aprov = 1
			              ");
$stmt->execute(array($itemID));
if ($stmt->rowCount() == 0) {

	$pageTitle = "Item-Not Found";
	include 'int.php';
	echo "<div class='container'><center>";
	echo '<img  style="width: 25%" src="layout/images/sad.png">';
		echo "</center><div class='alert alert-danger'>Wrong Item !! OR It's Wating to Approve</div>";
	echo "</div>";
}
elseif ($stmt->rowCount() > 0) {
$item_info = $stmt->fetch();
$pageTitle = $item_info['name'];
include 'int.php';
$img_src = 'uploade/itemIMAges//';
?>

<div class="container item-infos">
	<h2 class="text-center"><?php echo $item_info['name']; ?></h2>
	<div class="row">
		<div class="col-md-3">
		<img class="img-resposive img-thumbnail center-block" src="<?php echo $img_src . $item_info['img']?>">
		<center>

		<a href="buy.php?itemid=<?php echo $item_info['itemID']; ?>" class="btn btn-success" role="button">
			<i class="fa fa-cart-plus" aria-hidden="true"></i>
		Buy</a>
		</center>
		</div>

		<div class="col-md-9">
			<h2><?php echo $item_info['name']; ?></h2>
			<p><?php echo $item_info['description']; ?></p>
			<ul class="list-unstyled">
			<li><i class="fa fa-calendar fa-fw"></i>
				<span>Date</span>: <?php echo $item_info['add_date']; ?>
			</li>
			<li><i class="fa fa-globe fa-fw"></i>
				<span>Made In</span>: <?php echo $item_info['maker']; ?>
			</li>
			<li><i class="fa fa-money fa-fw"></i>
			<span>Price</span>: <?php echo $item_info['price'] .'$'; ?>
			</li>
			<li><i class="fa fa-tags fa-fw"></i>
				<span>Category</span>: 
				<a href="categories.php?catid=<?php echo $item_info['category_ID']?>"><?php echo $item_info['cat_name']; ?></a>
			</li>
			<li><i class="fa fa-user fa-fw"></i>
				<span>Added By</span>: 
				<a href="viewprofile.php?id=<?php echo $item_info['member_ID']; ?>"><?php echo $item_info['usernname']; ?></a>
			</li>
			</ul>
		</div>

	</div>
	<hr class="custom-hr">
	<?php 
		if(isset($_SESSION['user'])){
	?>
<div class="row">
	<div class="col-md-offset-3">
		<div class="add-user-comnt">
			<h3>Add Comment</h3>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item_info['itemID']?>">
				<textarea id="com" name="coment" placeholder="Type Your comment" required title="ياما تكتب كومنت ياما تبطل رخامه يلعن ابو شكلك"></textarea>
				<button id="commm" class="btn btn-primary pull-right"><i class="fa fa-paper-plane"></i></button>
			</form>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$Comment = filter_var($_POST['coment'],FILTER_SANITIZE_STRING);
			$ITEMID = $item_info['itemID'];
			$USERID = $_SESSION['Normi_User'];
			$chek = "";
			if (!empty($Comment)) {
				$insert="INSERT INTO `comment`
				(`comment`, `coment date`, `item_id`, `user_id`) 
				VALUES 
				(:zocm ,now() , :zitem , :zuser)";
				$stmt = $conn->prepare($insert);
				$stmt->execute(array(
					":zocm"		=>$Comment,
					":zitem"	=>$ITEMID,
					":zuser"	=>$USERID
				));
				if ($stmt) {
					echo '<div class="confirm-message"><div class="alert alert-success">
					Comment Added Please Wait to Comfirm it from Control 
					</div></div>';
				}
			}

		}
			?>
			
		</div>
	</div>
</div>

<?php 
	} else {
		echo "<a href='login.php'>
		Login</a> or <a href='login.php'>Register</a> To Add Comment";
	}
?>
<hr class="custom-hr">
<?php 
	$stmt = $conn->prepare("SELECT 
                  comment.*, users.user_img , users.fullname As member 
                  From comment 
                  INNER JOIN users ON users.userID = comment.user_id
                  WHERE 
                  item_id = ?
                  AND
                  stat = 1
                  ORDER BY coment_id DESC
                  ");
$stmt->execute(array($item_info['itemID']));
$COMMENTS = $stmt->fetchAll();
if (!empty($COMMENTS)) {
	foreach ($COMMENTS as $COMMENT) {
		$img = 'uploade/'.$COMMENT['user_img'];
		?>
		<div class="comment-box">
			<div class="row">
				<div class="col-sm-2 text-center"><a href="viewprofile.php?id=<?php echo $COMMENT['user_id']; ?>">
					<img class="img-resposive img-circle img-thumbnail center-block" src="<?php echo $img?>">
					 <strong><?php echo $COMMENT['member']; ?></strong></a>
				</div>

				<div class="col-sm-10">
					<p class="comnt-data">
					 <?php echo $COMMENT['comment'] ; ?>
					 </p>
				</div>
			</div>
		</div>
		<hr class="custom-hr">
		<?php
	}}
 ?>
</div>







<?php
}

include $tpl . 'footer.php';
ob_end_flush();
?>
