<?php
include 'connect.php';
//Routing pathes and include some pages


$tpl              = "includes/templete/";        #templete dirctroy
$language         = "includes/languages/";       #languages Directory
$fn               = "includes/functions/";       #functions Dirctroy
$css              = "layout/css/";               #css dirctroy
$js               = "layout/js/";                #js dirctroy
$img              = "layout/images/";
include $language . 'english.php';
include $fn . 'functions.php';
include $tpl . "header.php";
  if (!isset($noNav)) {include $tpl . 'navbar.php';}
