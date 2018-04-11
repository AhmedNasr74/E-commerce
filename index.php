<?php
ob_start("ob_gzhandler");  //compressing data on servrer
session_start();
$pageTitle = isset($_SESSION['user']) ? $_SESSION['user'] :"Home";
include 'int.php';
$wher = "WHERE aprov = 1";
$all_items = getAll("item","itemID",$wher);
$img_src = 'uploade/itemIMAges//';?>
<div style="margin-top: 30px;"></div>
<div class="container cat">
<?php
    foreach($all_items as $item)
{?>
        <div class="row">
          <div class="col-sm-6 col-md-3 cont">
            <div class="thumbnail item-box">
                <span class="price-tag"><?php echo $item['price'].'$' ?></span>
              <img class="img-resposive" src="<?php echo $img_src . $item['img'] ?>" alt="...">
              <div class="caption">
                <h3><a href="items.php?itemid=<?php echo $item['itemID']?>"><?php echo $item['name'] ?></a></h3>
                <p><?php echo $item['description'] ?></p>
                <p>Made In : <?php echo $item['maker'] ?></p>
                <p class="date"><?php echo $item['add_date'] ?></p>
                <p><a href="buy.php?itemid=<?php echo $item['itemID']?>" class="btn btn-success btn-block buy" role="button"><i class="fa fa-cart-plus" aria-hidden="true"></i> Buy</a></p>
              </div>
            </div>
          </div>
        </div>
    <?php 
}
    ?>
    
</div>


<?php
include $tpl . 'footer.php';
ob_end_flush();
?>
