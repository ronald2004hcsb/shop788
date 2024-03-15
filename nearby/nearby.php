<?php
session_start();
include('db.php');
$loadFun = "";

if(isset($_SESSION['lat']) && isset($_SESSION['lon'])){
    $lat = $_SESSION['lat'];
    $lon = $_SESSION['lon'];
    
    $res = mysqli_query($con, "SELECT
        product.*, shop.shop_name,
        (3959 * acos (
            cos ( radians($lat) )
            * cos( radians( shop.latitude ) )
            * cos( radians( shop.longitude ) - radians($lon) )
            + sin ( radians($lat) )
            * sin( radians( shop.latitude ) )
        )) AS distance
    FROM product
    INNER JOIN shop ON shop.id = product.shop_id
    HAVING distance < 20
    ORDER BY distance");

} else {
    $res = mysqli_query($con, "SELECT product.*, shop.shop_name FROM product INNER JOIN shop ON shop.id = product.shop_id");
    $loadFun = "onload='getLocation()'";
}


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>Product Shopping Grid</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	  <link href="css/style.css" rel="stylesheet">



     <section id="header">

<a href="#"><img src="Colorful_Illustrative_Online_Shop_Logo-removebg-preview.png" class="logo"></a>



  <div>
    <ul id="navbar">
        <li><a  class="active" href="index.php">Home</a></li>
        <li><a  href="shop.php">Shop</a></li>
        <li><a href="Trending.php">Trending</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <i class="fas fa-shopping-cart"></i><p id="count">0</p>
        
   

<div class="search-container">
    <li><a href="search.php"><input type="text" id="searchInput" placeholder="Search..." onkeyup="showResults()"></a></li>
    <div id="searchResults" class="search-results">

    </div>
    
         

    
</section>
<section id="hero">
<h1>Shop From The Best Store <br>Near You !</h1>
<p>Save your extra time and money !<button>Shop Now</button></p>

</section>



<section id="feature" class="section-p1">
<div class="fe-box">
    <img src="delivery-truck-icon-3d-rendering-illustration-vector.jpg" alt="">
    <h4>Faster Delivery</h4>
</div>
<div class="fe-box">
    <img src="th.jpeg" alt="">
    <h4>Free Shippings</h4>
</div>
<div class="fe-box">
    <img src="User-friendly-Animated-Video-Editor.png" alt="">
    <h4>User Friendly</h4>
</div>
<div class="fe-box">
    <img src="02-saving-money-.jpg" alt="">
    <h4>Save Money</h4>
</div>
<div class="fe-box">
    <img src="Web-design-development-user-friendly.png" alt="">
    <h4>Nearby Shops</h4>
</div>

</section>
	  <script>
	  function error(err){
		  //alert(err.message);
	  }
	  function success(pos){
		  var lat=pos.coords.latitude;
		  var lon=pos.coords.longitude;
		  jQuery.ajax({
			  url:'setLatLong.php',
			  data:'lat='+lat+'&lon='+lon,
			  type:'post',
			  success:function(result){
				  window.location.href='home.php'
			  }
			  
		  });
	  }
	  function getLocation(){
		  if(navigator.geolocation){
			  navigator.geolocation.getCurrentPosition(success,error);
		  }else{
			  
		  }
	  }
	  </script>
   </head>
   <body
   <?php echo $loadFun?>>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
      <div class="container">
         <h3 class="h3">Products Listing</h3>
         <div class="row">
			<?php while($row=mysqli_fetch_assoc($result)){?>
            <div class="col-md-3 col-sm-6">
               <div class="product-grid">
                  <div class="product-image">
                     <a href="#">
                     <img src="images/<?php echo $row['image']?>">
                     </a>
                  </div>
                  <div class="product-content">
                     <h3 class="title"><a href="#"><?php echo $row['product_name']?>(<?php echo $row['shop_name']?>)</a></h3>
                     <div class="price">Rs <?php echo $row['price']?></div>
                  </div>
               </div>
            </div>
			<?php } ?>
         </div>
      </div>
   </body>
</html>