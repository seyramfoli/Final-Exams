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
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <i class="fa fa-home" aria-hidden="true"></i><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Orders <i class="fa fa-clock-o" aria-hidden="true"></i></a>
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
    <div class="col-sm-6 cart-products">
    <?php
        if(isset($_SESSION['sessionFname'])){
            echo '<h1 class="text-center font-weight-bold">';
            printf("%s's Cart", $_SESSION['sessionFname']);
            echo '</h1>';

			}else{
				echo <<<_NOCART
					<h1 class="text-centerfont-weight-bold ">Your Cart</h1>
						
				_NOCART;

						
        }
	?> 
    
    </div>
    <div class="col-sm-6 subtotal">
        Subtotal: $
        <br><br>
        <div class="btn btn-secondary">Proceed to Payment</div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>
</body>
</html>