<?php
ob_start("ob_gzhandler");
session_start();
if (isset($_SESSION['user_loged'])) {
$pageTitle = '';
include 'int.php';

$do = isset($_GET['do']) ?strtolower($_GET['do']) : 'manage';

  if ($do == 'manage'){
      echo "string";
  }//end manage
  elseif ($do == 'edit'){

  }//end edit
  elseif ($do == 'update'){

  }//end update
  elseif ($do == 'delete'){

  }//end delete
  elseif ($do == 'aprrove'){

  }//end aprrove
  elseif ($do == 'add'){

  }//end add
  elseif ($do == 'insert'){

  }//end insert



include $tpl . 'footer.php';
} else {
  redirct($msg,"",0);
  exit();
}
  ob_end_flush();
  ?>
