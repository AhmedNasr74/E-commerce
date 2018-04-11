<?php
ini_set("display_errors" , 'On');
error_reporting(E_ALL);
include 'Cpanel/connect.php';


$user_session = isset($_SESSION['user']) ? $_SESSION['user'] : '';

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
include $tpl . 'navbar.php';