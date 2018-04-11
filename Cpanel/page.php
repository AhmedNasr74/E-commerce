<?php
      //Category pages => [add | delete | update |....]
##if condition ==> condition ? True ->do true stat : False->do false stat
$do = isset($_GET['do']) ?$_GET['do'] : 'Manage';

  if ($do == 'Manage') {
    echo "Welcome you are in Manage page" . '<br>';
    echo '<a href="?do=Add">Add New Category</a>';
  } elseif ($do == 'Add') {
    echo "Welcome you are in Add page". '<br>';
  } elseif ($do == 'Edit') {
    echo "Welcome you are in Edit page". '<br>';
  } else {
    echo "Error404";
  }




 ?>
