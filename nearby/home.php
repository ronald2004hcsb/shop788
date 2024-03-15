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
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>Product Shopping Grid</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	  
      <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="location.css">
        
       

     <section id="header">

<a href="#"><img src="Colorful_Illustrative_Online_Shop_Logo-removebg-preview.png" class="logo"></a>



  <div>
    <ul id="navbar">
        <li><a  class="active" href="home.php">Home</a></li>
        <li><a  href="shop.php">Shop</a></li>
        <li><a href="Trending.php">Trending</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        
        
        
   

<div class="search-container">
    <li><a href="search.php"><input type="text" id="searchInput" placeholder="Search..." onkeyup="showResults()"></a></li>
    <div id="searchResults" class="search-results">

    </div>


    <div class="container-2">
        
            
            <div class="iconCart">
                
                <div class="totalQuantity">0</div>
            </div>
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
         <h3 class="h3">TRENDING LIST</h3>
         <div class="row">
			<?php while($row=mysqli_fetch_assoc($res)){?>
                <div class="listProduct">

<div class="item">
                <div class="col-md-3 col-sm-6">
               <div class="product-grid">
             
                  <div class="product-image">
                     <a href="#">
                     <img src="images/<?php echo $row['image']?>">
                     </a>
                  </div>
                  <div class="product-content">
                     <h3 class="title"><a href="#"><?php echo $row['product_name']?>(<?php echo $row['shop_name']?>)</a></h3>
                     <div class="price">Rs <?php echo $row['price']?><button>Add to cart</button></div>
                     
                     </div>
               </div>
            </div>
            
			<?php } ?>
         
         </div>
                </div>
         </div>
      </div>
      </div>
            <div class="cart">
        <h2>
            CART
        </h2>

        <div class="listCart">


            <div class="item">
                <img src="images/<?php echo $row['image']?>">
                <div class="content">
                    <div class="name"><a href="#"><?php echo $row['product_name']?></div>
                    <div class="price">Rs <?php echo $row['price']?></div>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span class="value">3</span>
                    <button>+</button>
                </div>
            </div>


        
         
      </div>
      </div>
     
      

      
   </body>
   <section id="sm-banner" class="section-p1">
            <div class="banner-box">
                <h1>Women's Ethnic</h1>
                <h2>Up to 30% Off</h2>
                
               <li><a  class="active" href="Shopnow.php"><button class="white">Shop now</button></a></li>
            </div>

            <div class="banner-box">
                <h1>Smart Gadget's</h1>
                <h2>Up to 40% Off</h2>
                
               <li><a  class="active" href="smartgadget.php"><button class="white">Shop now</button></a></li>
            </div>
          </section>
          <script src="script.js"></script>
          <script src="app.js"></script>
</html>