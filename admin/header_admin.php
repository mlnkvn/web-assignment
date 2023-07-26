<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebAssignment</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="../actions/error-handling.js"></script>
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
        <a href="indexadmin.php" class="navbar-brand"><img src="../img/logo.png" alt="Oops!"></a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button> -->
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="indexadmin.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="categoryadmin.php" class="nav-link">Category Page</a></li>

            <li class="nav-item">
                <div class="dropdown">
                    <button class="dropbtn">Settings</button>
                    <div class="dropdown-content">
                        <a href="settingsadmin.php">Edit account</a>
                        <a href="usersadmin.php">User management</a>
                        <a href="ordersadmin.php">Orders management</a>
                        <a href="logoutadmin.php">Log out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

</nav>