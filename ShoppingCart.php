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
		   <a class="nav-link" href="http://localhost:8080/EShop/ShoppingCart.php">Basket<span class="sr-only">(current)</span></a>
		</li>
		  <li class="nav-item">
		  
        <a class="nav-link" href="http://localhost:8080/EShop/Checkout.php">Home </a>
      </li>
    
		 
    
      </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
        
</nav>
    
    
    
    
    
    
    
    
    
    
    <!---------------------------->
 
    
      
    
    
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



<?php
endwhile;
endif;
endif;
?>

<div style="clear:both;"></div>
<br/>
<div class="table-responsive">
	<table class="table">
		<tr> 
			<th width="40%">Product Name</th>
			<th width="10%">Quantity</th>
			<th width="20%">Price</th>
			<th width="15%">Total</th>
			<th width="5%">Action</th>
		</tr>
<?php
if(!empty($_SESSION['shopping_cart'])):

	$total = 0.0;

	foreach ($_SESSION['shopping_cart'] as $key => $product): 
		?>
		<tr>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['quantity'];?></td>
			<td>$ <?php echo $product['price'];?></td>
			<td>$ <?php echo number_format($product['quantity'] * doubleval($product['price']), 2); ?></td>
			<td> 
				<a href="ShoppingCart.php?action=delete&id=<?php echo $product['id']; ?> ">
					<div class= "btn-danger">Remove</div>
				</a>

			</td>


		</tr>
                                           
		<?php 
		$total = $total + $product['quantity'] * doubleval($product['price']);
	endforeach;
?>

<tr>
	<td colspan="3" align="right">Total</td>
	<td align="right">$ <?php echo number_format($total, 2); ?> </td>
	<td></td>
</tr>
<tr>
	<!--- show checkout button only if the shopping cart is not empty---->
	<td colspan="5"> 
  <?php
  if (isset($_SESSION['shopping_cart'])): 
  	if (count($_SESSION['shopping_cart']) > 0) :
  		?>
  		<a href="#" class="button">Checkout</a>
  	<?php endif; endif; ?>

  		
  	
  

	</td>
</tr>
<?php
endif
?>

	</table>
	




	
</div>



</div>
</body>
</html>


