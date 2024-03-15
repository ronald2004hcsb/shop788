<?php
session_start();
include('db.php');
$loadFun="";
if(isset($_SESSION['lat']) && isset($_SESSION['lon'])){
	$lat=$_SESSION['lat'];
	$lon=$_SESSION['lon'];
	
	$res=mysqli_query($con,"SELECT
    product.*,shop.shop_name, (
      3959 * acos (
      cos ( radians($lat) )
      * cos( radians( shop.latitude ) )
      * cos( radians( shop.longitude ) - radians($lon) )
      + sin ( radians($lat) )
      * sin( radians( shop.latitude ) )
    )
) AS distance
FROM product,shop
where shop.id=product.shop_id
HAVING distance < 20
ORDER BY distance");
}else{
	$res=mysqli_query($con,"select product.*,shop.shop_name from product,shop where shop.id=product.shop_id");
	$loadFun="onload='getLocation()'";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF=8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name=""viewport content="width=device-width, initial-scale=1.0">
        <title>ecommerce website</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet"href="style.css">
        

</head>
<body>
<div class="container-fluid">
<div class="container">
<div class="search">
<h1>All Products</h1>
<input type="text" name="" id="find" placeholder="search here...." onkeyup="search()">
</div>
<div class="product-list">


			<?php while($row=mysqli_fetch_assoc($res)){?>
            <div class="col-md-3 col-sm-6">
               <div class="product-grid">
                  <div class="product-image">
                     <a href="#">
                     <img src="images/<?php echo $row['image']?>">
                     </a>
                  </div>
                  <div class="product-content">
                     <h3 class="title"><a href="#"><?php echo $row['product_name']?>(<?php echo $row['shop_name']?>)</a></h3>
                     <div class="price">Rs <?php echo $row['price']?><button>add to cart</button></div>
                     
                  </div>
               </div>
            </div>
            
			<?php } ?>
         
         </div>
         
      </div>
      </div>
      

      
   </body>
   
   
          <script src="script.js"></script>
</html>