<?php
ob_start("ob_gzhandler");  //compressing data on servrer

session_start();
$pageTitle = "Categories";
include 'int.php';
$catid   = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :"Error";
$items = getitems('category_ID',$catid);
$img_src = 'uploade/itemIMAges//';
?>


<div class="container cat">


<?php
if (empty($items)) {
  echo '    
    <center>
      <img  style="width: 25%" src="layout/images/sad.png">
    </center><br>';
    echo "<div class='alert alert-info'><h2>This Category is Empty</h2></div>";
}
else{
$cat = $conn->prepare("SELECT name FROM category WHERE ID = ?");
$cat->execute(array($catid));
$name=$cat->fetch();
  echo '<h2 class="text-center">' . $name['name'] . '</h2>';
    foreach($items as $item)
{?>
        <div class="row">
          <div class="col-sm-6 col-md-3 cont">
            <div class="thumbnail item-box">
                <span class="price-tag"><?php echo $item['price'].'$' ?></span>
              <img class="img-resposive" src="<?php echo $img_src . $item['img'] ?>" alt="...">
              <div class="caption">
                <h3><a href="items.php?itemid=<?php echo $item['itemID']?>"><?php echo $item['name'] ?></a></h3>
                <p><?php echo $item['description'] ?></p>
                <p><?php echo $item['maker'] ?></p>
                <p class="date"><?php echo $item['add_date'] ?></p>
                <p><a href="buy.php?itemid=<?php echo $item['itemID']?>" class="btn btn-success btn-block buy" role="button">Buy</a></p>
              </div>
            </div>
          </div>
        </div>
    <?php 
}
}
    ?>
    
</div>

<?php include $tpl . 'footer.php';
ob_end_flush();
?>
