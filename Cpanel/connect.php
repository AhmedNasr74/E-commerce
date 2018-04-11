<?php
//Connecting using PDO Method
/*
** PDO is a built in class in php to connect Database instade of msqli
*/
$dsn ="mysql:host=localhost;dbname=shop";
$user="root";
$pass="";

$set_ar = array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',);//set arabic in DB
try {
$conn =  new PDO($dsn,$user,$pass,$set_ar);
$conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Faild to connect " . $e->getMessage();//getting error of connection

}




 ?>
