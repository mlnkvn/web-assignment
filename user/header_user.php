<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebAssignment</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="../css/cart_style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">


    <script src="../actions/error-handling.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script type="text/javascript">
        function check_input() {
            return document.getElementById("search").value != null && document.getElementById("search").value != "";
        }
    </script>
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
            <li class="nav-item">
                <form action="../actions/searchscript.php" method="post" onsubmit="return check_input()">
                    <label for="search"></label>
                    <input id="search" type="text" name="search" placeholder="Type here">
                    <input id="submit" type="submit" name="submit" value="Search">
                </form>
            </li>
            <li class="nav-item"><a href="indexuser.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="categoryuser.php?cat=all_all" class="nav-link">Categories</a></li>
            <li class="nav-item"><a href="shopping_cartuser.php" class="nav-link">Shopping Cart</a></li>
            <!--            TODO                 -->
            <li class="nav-item">
                <div class="dropdown">
                    <button class="dropbtn">My Account</button>
                    <div class="dropdown-content">
                        <a href="edituser.php">Edit profile</a>
                        <a href="ordersuser.php">My orders</a>
                        <a href="logoutuser.php">Log out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>