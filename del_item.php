<?php
/////////////////////////Edit User item
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
$pageTitle = $_SESSION['user'];
include 'int.php';
if (isset($_SESSION['user'])) {

$userID = $_SESSION['Normi_User'];
$_itemid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;
$stmt_check=$conn->prepare("SELECT * FROM item WHERE itemID=? AND member_ID=?");
$stmt_check->execute(array($_itemid,$userID));
$count = $stmt_check->rowCount();
if ($count > 0) {
	$stmt = $conn->prepare("DELETE FROM item WHERE itemID=?");
    $stmt->execute(array($_itemid));
    if ($stmt) {
    	header("Location:profile.php");
    }
} else {
	?> 

	<div class="container">
		<center>
			<img  style="width: 25%" src="<?php echo $img ?>sad.png">
		</center><br>
		<div class="alert alert-danger">
			<h1>Item Not Found!!!!!!!!!!</h1>
		</div>
	</div>

	<?php
}

} else {
   header('location:login.php');
}
include $tpl . 'footer.php';
ob_end_flush();
  ?>