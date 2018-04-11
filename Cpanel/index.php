<?php
session_start();
$noNav = '';
$pageTitle = 'login';
if (isset($_SESSION['user_loged'])) {
  header ('location: dashbord.php');
}
include 'int.php';
//check if user coming form http request method post
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['pass'];
    $hashedpass = sha1($pass);//encript password

  //check if Admin is exist in database
$stmt = $conn->prepare("SELECT
                              userID, usernname, password
                              FROM
                              users WHERE usernname = ? AND password = ? AND GroupID = 1 LIMIT 1");
$stmt->execute(array($user, $hashedpass));
$row = $stmt->fetch();
$count = $stmt->rowCount();
  if ($count > 0 && $row['usernname'] == $user) {
    $_SESSION['user_loged'] = $user;
    $_SESSION['ID'] = $row['userID'];
    header ('location: dashbord.php');
    exit();
  }

  }

 ?>

<form class="col-md-3 col-sm-6 login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <h2 class="text-center">Admin Log in</h2>
  <div class="line"></div>
  <input class="form-control input-lg" type="text" name="username" placeholder="Type User Name" autocomplete="off">
  <input class="form-control input-lg" type="password" name="pass" placeholder="Type Password" autocomplete="new-password">
  <button class="btn btn-primary btn-block" name="login">Login</button>
</form>


 <?php
include $tpl . 'footer.php';
  ?>
