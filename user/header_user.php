<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebAssignment</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../behavior.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
</head>

<body>

<div class="top-bar">
    <div class="container">
        <div class="col-12 text-right">
            <!-- TODO  -->
        </div>
    </div>
</div>

<nav class="navbar bg-light navbar-light navbar-expand-lg">
    <div class="container">
        <a href="indexuser.php" class="navbar-brand"><img src="../img/logo.png" alt="Oops!"></a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button> -->
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="indexuser.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="categoryuser.php" class="nav-link">Categories</a></li>
            <li class="nav-item"><a href="shopping_cartuser.php" class="nav-link">Shopping Cart</a></li>
            <!--            TODO                 -->
            <li class="nav-item" >
            <div class="dropdown">
                <button class="dropbtn">My Account</button>
                    <div class="dropdown-content">
                        <a href="edituser.php">Edit profile</a>
                        <a href="addressuser.php">Address Management</a>
                        <a href="ordersuser.php">My orders</a>
                        <a href="logoutuser.php">Log out</a>
                    </div>
            </div>
</li>
        </ul>
    </div>
</nav>