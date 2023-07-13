<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_user.php'
?>

<div>
    <h2>Hi user, <br>userid <b><?php echo htmlspecialchars($_SESSION["userid"]); ?> </b> <br> username
        <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> <br>Welcome to our site.</h2>
</div>

</body>
</html>