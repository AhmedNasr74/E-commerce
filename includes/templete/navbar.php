<div class="upper-bar">
    <div class="container text-right">
<?php 
        if (isset($_SESSION['user'])) {
            
          $img_src = 'uploade//'. $_SESSION['userIMG'];
            
          ?>
            <img class="prof-img img-circle" src="<?php echo $img_src ?>">
            <div class="btn-group pull-right">
              <span class="btn dropdown-toggle" data-toggle="dropdown">
                <?php echo $user_session ?>
                 <span class="caret"></span>
              </span>

              <ul class="dropdown-menu">
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="ad.php">Add Item</a></li>
                <li><a href="setting.php">Settings</a></li>
                <li><a href="logout.php">Log Out</a></li>
              </ul>
            </div>
          <?php
        }
        else{
          echo "<a class='login-lnk' href='login.php'><i class='fa fa-lock'></i> Login | Sign Up</a>";
        }
         ?>
        
    </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"> <?php echo "Home Page"; ?> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php
          foreach(getcats() as $cata)
          {
            echo '<li><a href="categories.php?catid='.$cata['ID'].'">
                '.$cata['name'].'</a></li>' ; 
          }
        ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
