<?php
/*
**  title fn is functions that returns the page title in case that the page has
**  $pageTitle;; or return defulte
*/

/*get categories*/
function getcats()
{
  global $conn ;
  $stmt = $conn->prepare("SELECT * FROM category") ;
  $stmt->execute();
  $cats = $stmt->fetchAll();
  return $cats;
}
function getAll($from , $order , $where=NULL)
{
  global $conn ;
  $exQuery =  ($where == NULL) ? "" : $where;
  $stmt = $conn->prepare("SELECT * FROM $from $exQuery ORDER BY $order DESC");
  $stmt->execute();
  $All_Data = $stmt->fetchAll();
  return $All_Data;
}

/*get AD  items*/
function getitems($where,$value , $aprov=NULL)
{
  global $conn ;
 $Add_sql = empty($aprov) ? "AND aprov = 1" : NULL;
  $stmt = $conn->prepare("SELECT * FROM item WHERE $where=?  $Add_sql
                     ORDER BY itemID DESC");
    
  $stmt->execute(array($value));
    
  $items = $stmt->fetchAll();
    
  return $items;
}





/*Get page title*/
  function Title(){
    global $pageTitle;
    if (isset($pageTitle)) {
      echo $pageTitle;
    }else {
      echo lang("E-Commerce");
    }
  }

/*
**Function Check if item is found i data base v1.0
**function parameters is [$selec | $from | $condition |$val]
**$select=>what i want to select form table
**$from=>from any tale i want to SELECT
**$condition=>WHERE Condtion // By defulte it's eqal $select
**$val=>value of condition
*/

function checkFound($select,$from,$val)
{
  global $conn;
  $query = "SELECT $select FROM $from WHERE $select = ? ";
  $stmt1=$conn->prepare($query);
  $stmt1->execute(array($val));
  $count =$stmt1->rowCount();
  return  $count;
}

//Redircting function

function redirct($msg , $url , $timOUT=3)
{
  if ($url=='') { $url = 'index.php'; }
  elseif($url === "back")
{
  $url =isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']  :"index.php";
}
       echo $msg;

       header ("refresh:$timOUT;url=$url");
       exit();
}

/*
**count items Function
**Function that gets the number of rows of any table
*/

function countitems($col , $table){
    global $conn;
    $stmt2 = $conn->prepare("SELECT COUNT($col) FROM $table");
    $stmt2->execute();

    return $stmt2->fetchColumn();
}

/*
**  getLest fn
**  function is getting the last number of rowss
*/
function Get_LEAST($select , $table , $order ,$limt=5)
{
  global $conn ;
  $stmt3 = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limt") ;
  $stmt3->execute();
  $rows = $stmt3->fetchAll();
  return $rows;
}
  function getTable($selection , $table)
  {
    global $conn ;
    $stmt4  = $conn->prepare("SELECT $selection FROM $table");
    $stmt4->execute();
    return $stmt4->fetchAll();
  }

/*start user activation function*/
function activated_user($user)
{
    global $conn ;
    $stmt = $conn->prepare("SELECT
                             RegState , usernname 
                              FROM
                              users
                              WHERE
                              usernname = ?
                              AND 
                              RegState = 0
                            ");
$stmt->execute(array($user));  
    
$stat = $stmt->rowCount();
    
return $stat;
}
/*start user activation function*/


/*get old img*/
function getimg($where)
{
  global $conn;
  $stmt = $conn->prepare("SELECT user_img FROM users WHERE usernname = ?");
  $stmt->execute(array($where));
  return $stmt->fetch();
}





