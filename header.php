<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebAssignment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet" /> 
</head>

<body>
    <div class="top-bar">
		<div class="container">
			<div class="col-12 text-right">
			</div>
		</div> 
	</div>

    <nav class="navbar bg-light navbar-light navbar-expand-lg"> 
		<!-- <div class="container"> -->
			<a href="index.php" class="navbar-brand"><img src="img/logo.png" alt="Oops!"></a> 
			<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="navbar-toggler-icon"></span> 
			</button> -->
		<!-- </div> -->
		<div class="collapse navbar-collapse" id="navbarResponsive"> 
			<ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="actions/searchscript.php" method="POST">
                        <label for="search"></label>
                        <input id="search" type="text" name="search" placeholder="Type here">
                        <input id="submit" type="submit" name="submit" value="Search">
                    </form>
                </li>
				<li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li> 
				<li class="nav-item"><a href="category.php" class="nav-link">Categories</a></li>
                <li class="nav-item"><a href="shopping_cart.php" class="nav-link">Shopping Cart</a></li>
				<li class="nav-item"><a href="login.php" class="nav-link">Login/Register</a></li>
			</ul>
		</div>
	</nav> 