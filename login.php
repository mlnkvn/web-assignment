<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
            <a href="index.php" class="navbar-brand"><img src="img/logo.png" alt="Oops!"></a> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span> 
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarResponsive"> 
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li> 
                <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Log in</a></li>
                <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li> 
                <li class="nav-item"><a href="faq.php" class="nav-link">FAQ</a></li>
            </ul>
        </div>
    </nav> 
    <div align="center" id="login-block">
    <h3>LOGIN</h3>
        <form id="login-form" method="post" action="loginscript.php" >
            <table border="0.5">
                <tr>
                    <td><label for="user_id">User name</label></td>
                    <td><input type="text" name="user_id" id="user_id"></td>
                </tr>
                <tr>
                    <td><label for="user_pass">Password</label></td>
                    <td><input type="password" name="user_pass" id="user_pass"></input></td>
                </tr>
                <tr >
                    <td><input type="reset" value="Reset"/>
                    <td><input type="submit" value="Login" />
                </tr>
            </table>
        </form>
    </div>
</body>
</html>