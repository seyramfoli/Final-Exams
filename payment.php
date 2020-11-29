<?php
	require_once 'database.php';
	require_once 'register.php';
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adleks Studio</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="payment.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between ">
    <a class="navbar-brand" href="index.php">Adleks Studio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
            <a class="nav-link" href="index.php">Home <i class="fa fa-home" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="orders.php">Orders <i class="fa fa-clock-o" aria-hidden="true"></i></a>
        </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
        <ul class="navbar-nav mr-auto" >
        <li class="nav-item signin">
            <!-- <a class="nav-link" href="signIn.php"> -->
            <?php
					if(isset($_SESSION['sessionFname'])&&isset($_SESSION['sessionLname'])){
						printf('Akwaaba, %s %s', $_SESSION['sessionFname'], $_SESSION['sessionLname']);
						echo <<<_SIGNOUTITEM
							<a id="sign-in" class="nav-link" href="logout.php">
								Sign Out 
							<i class="fa fa-sign-out" aria-hidden="true"></i></a>
						
						_SIGNOUTITEM;

					}else{
						echo <<<_SIGNINITEM
						<a id="sign-in" class="nav-link" href="signIn.php">
							Sign In 
						<i class="fa fa-user" aria-hidden="true"></i></a>
						
						_SIGNINITEM;

						
					}
				?> 
            <!-- <i class="fa fa-user" aria-hidden="true"></i></a> -->
        </li>
        <li class="nav-item">
            <a class="nav-link" href="checkout.php"><i class="fa fa-shopping-cart" aria-hidden="true"> <span class="cart-figure">0</span></i></a>
        </li>
        </ul>
    </div>
    </nav>

    
    <div class="row">
    <div class="col-sm-12 cart-products">
    <?php
        if(isset($_SESSION['sessionFname'])){
            echo '<h1 class="text-center font-weight-bold">';
            printf("%s's Payment", $_SESSION['sessionFname']);
            echo '</h1>';

			}else{
				echo <<<_NOCART
					<h1 class="text-centerfont-weight-bold ">Your Payment</h1>
						
				_NOCART;

						
        }

        $custId=$_SESSION['sessionId'];
        // echo $custId;
        $products=[];
        $total=0.00;
        $sql="select productID from products_customer where customerID=".$custId;
        $stmt= mysqli_stmt_init($conn);
        // echo 'connection worked';
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo 'sql error1';
          // header("Location: cust_welcome.php?error=sqlerror0");
          exit();
        }else{
          // mysqli_stmt_bind_param($stmt, "s");
            mysqli_stmt_execute($stmt);
            $result= mysqli_stmt_get_result($stmt);
            while($row=mysqli_fetch_array($result)){
              array_push($products,$row['productID']);
            }
          }
          
          foreach($products as $prodId){
            $sql="select * from products where productID=".$prodId;
            $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
             echo 'sql error2';
               //  header("Location: cust_welcome.php?error=sqlerror2");
                exit();
              }else{
                // mysqli_stmt_bind_param($stmt, "s");
                mysqli_stmt_execute($stmt);
                $result= mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)>0){

                  while($row=mysqli_fetch_array($result)){
                    if(!empty($row))
                    $pId=$row['productID'];
                    $pName=$row['pName'];
                    $pPrice=$row['price'];
                    $pRating=$row['rating'];
                    $pImage=$row['image'];
                    
                    echo '<div class="container">';
                    
                    echo  '<div class="img-blks5 col-sm-12 text-center product row">';
                    echo '<div class = "col-lg-6">';
                    echo '<img src="./assets/productImages/'.$pImage .'" />';
                    
                    echo '</div>';
                    echo '<div class = "col-lg-6">';
                    echo '<form action= "cart_remove.php" method= "post">';
                    echo '<input type="hidden" name="buyId" value="'.$pId.'"></input>';
                    echo '<strong class="pMainText pName">'.$pName.'</strong>';
                    echo '<h3 class="pMainText pPrice">$'.$pPrice.'</h3>';
                    $total=$total+(float)$pPrice;
                    echo '<h3 class="pRating"';
                    for ($i=0; $i <= $pRating; $i++) { 
                      # code...
                     echo "<i class='fa fa-star' aria-hidden='true'></i>";
     
                    }
                    if ($pRating< 5) {
                      # code...
                     for($i=0; $i < 5-$pRating; $i++){
                       echo "<i class='fa fa-star-o' aria-hidden='true'></i>";
     
                     }
                    }
                    echo '</h3>';
                    // echo '<button type="submit" class="btn btn-danger cart-button" name="remove" onclick="removeCart(this)">Remove from Cart </button>';
    
                    echo '</form>';
  
                    // echo '<br><br><span class="quantity">Qty:</span>';
                    // echo '<button type="button" class="btn bg-light border rounded-circle" onclick="removeQty()"><i class="fa fa-minus"></i></button>';
                    // echo '<input type="text" value="1" class="form-control w-25 d-inline pQty">';
                    // echo '<button type="button" class="btn bg-light border rounded-circle" onclick="addQty()"><i class="fa fa-plus"></i></button>';
                    echo '</div>';
    
                    echo '</div>';
                    
                    echo '</div>';
                  }
                }else{
                  // fix: not displaying
                  echo '<div class="container">';
                  echo 'The cart is empty';
                  echo '</div>';
                }
              }

          }
          
	?> 
    </div>
    
    </div>

    <div class="container">
        <div class="row">
        <div class="col-sm-12 cart-payment">
        <?php
            if(isset($_SESSION['cart'])){
            $item_num=count($_SESSION['cart']);
            echo '<h6>Wishlist ('.$item_num .' items)</h6>';
            }
            else{
            echo '<h6>Price(0 items)</h6>';
            }
        ?>
        <h6>Delivery Charges: FREE</h6>
        <hr>
            Subtotal: $ <?php echo $total; ?>
            <br><br>
            <!-- <i class="fa fa-credit-card-alt" aria-hidden="true"></i> -->
            <!-- <input type="text" value="xxx-xxxx-xxxx" class="form-control w-25 d-inline pQty">
            <input type="text" value="xx/xx" class="form-control w-25 d-inline pQty">
            <div class="btn btn-success" onclick="window.location.href='orders.php';">Buy <i class="fa fa-money" aria-hidden="true"></i></div> -->

            <form action="/charge" method="post" id="payment-form">
              <div class="form-row">
                <label for="card-element">
                  Credit or debit card
                </label>
                <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
              </div>

              <button>Submit Payment</button>
            </form>
        </div>
        
        </div>
    
    </div>

     <!-- footer -->
 <footer class="pt-5 pb-3 ">
        <div class="container">
            
            <div class="row">
                <div class="navbar navbar-expand-lg navbar-light rounded-bottom rounded-lg ">
                    <ul class="navbar-nav ml-auto">
                        <div class="col-sm-12 col-lg-6">
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Services</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link " href="#">Products <span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Bookings</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        </div>
                          <div class="col-sm-12 col-lg-6">
                              <li class="nav-item">
                                <a class="nav-link  mx-1" href="#"><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link mx-1" href="#"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a>
                              </li>

                           </div>
                           
                    </ul>
                    
                </div>
                
            <!-- <script>
            let clickedButtons = document.querySelectorAll(".cart-button");
            let cartCount = document.querySelector('.cart-figure');
            let cartCounter = 0;
            for (let i = 0; i < clickedButtons.length; i++) {
                clickedButtons[i].addEventListener('click',()=>{
                    cartCounter++;
                    cartCount.innerHTML= cartCounter;
                })
                
            }
            </script> -->
             
            </div>
            <div class="credits text-center mt-2">
                <p>Made by Richard Kafui Anatsui &copy; 2020. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="payment.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>
</body>
</html>