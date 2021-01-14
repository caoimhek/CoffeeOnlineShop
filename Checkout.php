<?php
session_start();
$product_ids = array();
//session_destroy();

//check if add to cart button has been submitted. //check if the cvarible set.
if (filter_input(INPUT_POST, 'add_to_cart')){
  if(isset($_SESSION['shopping_cart'])){

  	//keep track of number of products in the cart.
  	$count = count($_SESSION['shopping_cart']);

    //create sequential array for matching array keys to product id's.
  	$product_ids = array_column($_SESSION['shopping_cart'], 'id');

    if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
	$_SESSION['shopping_cart'][$count] = array 
	(

        'id'=> filter_input(INPUT_GET, 'id'),
		'name' => filter_input(INPUT_POST, 'name'),
		'price' => filter_input(INPUT_POST, 'price'),
		'quantity' => filter_input(INPUT_POST, 'quantity')

	       );



       }
       else{ //product already exists, increase quantity.
       	//match array key to id of the product being added to the cart
       	for ($i = 0; $i < count($product_ids); $i++){
          if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
          	//add item quantity to the existing product in the array 
          	$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');

          }

       	}
       }



  }
else{ 
	$_SESSION['shopping_cart'][0] = array 
	(
		'id'=> filter_input(INPUT_GET, 'id'),
		'name' => filter_input(INPUT_POST, 'name'),
		'price' => filter_input(INPUT_POST, 'price'),
		'quantity' => filter_input(INPUT_POST, 'quantity')
	);

}
}

if (filter_input(INPUT_GET, 'action') == 'delete'){
    
	foreach ($_SESSION['shopping_cart'] as $key => $product) {
        
		if ($product['id'] == filter_input(INPUT_GET, 'id')){
				
			unset($_SESSION['shopping_cart'] [$key]);
		}
	}
	$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}
//pre_r($_SESSION);

function pre_r($array){
         	echo '<pre>';
	print_r($array);
	echo '</pre>';

}
 

?>


<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart (working)</title>
    <!---jquery necessary for bootstrap's javascriptplugin --->
    
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<link rel= "stylesheet" href="CheckoutStyles.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
      
</head>
<body>
 


    
    <!--------------->
    
<div class = "container">
    
  
    
    
    <!---------nav bar------->
    

		
     
       
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="#">Coffee Online 
        <img src="https://gallery.yopriceville.com/var/resizes/Free-Clipart-Pictures/Coffee-PNG/Transparent_Coffee_Cup_PNG_Picture.png?m=1507172107" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
    
        
        </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

          
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost:8080/EShop/ShoppingCart.php">Basket</a>
      </li>
      </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
		</div>
        
</nav>
    
    
    
    
    
    
    
    
    
    
    <!---------------------------->
    
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" ></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>

	 	
		
		
		
		
		
		
		
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://res.cloudinary.com/grohealth/image/upload/f_auto,fl_lossy,q_auto/v1581688713/DCUK/Content/iStock-938993594-1000x600.jpg" class="d-block  w-100" alt="first slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Enjoy our fresh, ethically produced coffee</h5>
        <p>We take pride in our ethically sourced coffee, paying our producers a living wage.</p>
      </div>
    </div>
			
			
		
			
	
			
    <div class="carousel-item">
      <img src="https://img.resized.co/lovindublin_com/eyJkYXRhIjoie1widXJsXCI6XCJodHRwczpcXFwvXFxcL2ltYWdlcy5sb3ZpbmR1Ymxpbi5jb21cXFwvdXBsb2Fkc1xcXC8yMDIwXFxcLzAzXFxcLzAyMTcyOTA2XFxcL1NjcmVlbi1TaG90LTIwMjAtMDMtMDItYXQtMTcuMjguMzIucG5nXCIsXCJ3aWR0aFwiOjEyMDAsXCJoZWlnaHRcIjo2NzIsXCJkZWZhdWx0XCI6XCJodHRwczpcXFwvXFxcL2QyNmhlMDM4YTcwZGdzLmNsb3VkZnJvbnQubmV0XFxcL3dwLWNvbnRlbnRcXFwvdGhlbWVzXFxcL2xvdmluXFxcL2Fzc2V0c1xcXC9pbWdcXFwvY2FyZC1kZWZhdWx0LWxvdmluLWR1Ymxpbi5wbmdcIn0iLCJoYXNoIjoiNGNkNzc2NjZkNmRlODIyYmNjNTY0MThkNDM5ZjMyNjY5YmZkZTM4NCJ9/screen-shot-2020-03-02-at-17-28-32.png" class="d-block w-100 " alt=" second slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Why not subscribe?</h5>
        <p>Signing up to our subscription service ensures that you have access to the finest greek coffee every month.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://specials-images.forbesimg.com/imageserve/1152308114/960x0.jpg?fit=scale" class="d-block w-100" alt="third slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Know that you're doing well.</h5>
        <p>We donate 20% of each purchase to conserving natural ecosystems in the countries and communities we source from..</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
		
</div>
    
    
    <br>
    <br>
   
      
    
    
    <!---------------->
    
   
     
    
    
    
    <!---------------->

    
<?php	

$connect = mysqli_connect('localhost', 'root', '', 'CoffeeOnlineShop');
$query = 'SELECT * FROM product order by id ASC';
$result = mysqli_query($connect, $query);

if($result):
	if(mysqli_num_rows($result) > 0 ):
	while($product = mysqli_fetch_assoc($result)):
	//print_r($product);
?>
<div class ="col-sm-4 col-md-3"> 
    <form method ="post" action = "Checkout.php?action=add&id=<?php  echo $product ['id']; ?>">                                                                          
    	<div class = "products">
    		
            <img src=" <?php echo $product['image']; ?>" class= "img-responsive">

    		<h4 class ="text-info"><?php echo $product['name']; ?></h4>
            <h4> <?php echo $product['price']; ?></h4>
    		<input type="text" name="quantity" class="form-control" value="1" />
    		<input type ="hidden" name="name" value ="<?php echo $product ['name']; ?> " />
    		<input type ="hidden" name="price" value ="<?php echo $product ['price']; ?> " />
    		<input type ="submit" name="add_to_cart"  style = "margin-top: 5px;"   class = "btn btn-info"
    		       value="Add to Basket" />

    	</div>
    </form>
</div>


<?php
endwhile;
endif;
endif;
?>





	

</body>
</html>


