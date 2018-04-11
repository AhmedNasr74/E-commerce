<nav class="navbar navbar-inverse">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashbord.php"> <?php echo lang("BRAND"); ?> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="category.php"><?php echo lang("CATIGORY"); ?></a></li>
        <li><a href="items.php"><?php echo lang("ITEMS"); ?></a></li>
        <li><a href="comments.php"><?php echo "Comments"; ?></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="members.php?do=manage"><?php echo lang("MEMBERS"); ?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user_loged']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang("EDIT"); ?></a></li>
             <li><a href="../login.php"><?php echo "Visit Shop"; ?></a></li>
            <li><a href="#"><?php echo lang("SETTING"); ?></a></li>
            <li><a href="logout.php"><?php echo lang("LOGOUT"); ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
