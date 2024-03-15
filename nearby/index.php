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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="home.css">
        
    
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
				  window.location.href='index.php'
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
    <body>

      
      
  
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

        
          <?php
         include_once 'index.php';

         ?>
          <section id="product1" class="section-p1">
           <h2>Trending Products</h2>
          <h3> <p>Look What's in the Trend</p></h3>    
      <main>
      <?php
       while($row = mysqli_fetch_assoc($all_product)){
       

       ?>
       
        <div class="card">
           <div class="image">
               <img src="<?php echo $row["product_image"]; ?>" alt="">
           </div>
           <div class="caption">
               <p class="rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
               </p>
               <p class="product_name"><?php echo $row["product_name"];  ?></p>
               <p class="price"><b>$<?php echo $row["price"]; ?></b></p>
               
           </div>
           <button class="add" data-id="<?php echo $row["product_id"];  ?>">Add to cart</button>
       </div>
               
       
         

          
          <?php
       }
          ?>
          </main>
          <section id="product1" class="section-p1">
           <h2>Trending Products</h2>
          <h3> <p>Look What's in the Trend</p></h3>   
          <script src="script.js"></script>   
    </body>
</html>