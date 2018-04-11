<?php

function lang($myword)
{
  static $lang = array(
    'MESSEGE'       =>     'Welcome',
    'ADMIN'         =>    'Adminstrator',
    ##Nav Words
    'BRAND'         =>     'Home',
    'CATIGORY'      =>    'Catigories',
    'ITEMS'         =>    'Items',
    'SETTING'       =>    'Setting',
    'LOGOUT'        =>    'Log Out',
    'MEMBERS'       =>    'Members',
    'STATISTICS'    =>    'Statistics',
    'EDIT'          =>    'Edit',
    #pages title words
    'E-Commerce'    =>    'Main',
    'login'         =>    'LOG IN',
    'dashbord'      =>    'Dashbord',

  );
  return $lang[$myword];
}


 ?>
