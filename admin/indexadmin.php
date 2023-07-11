<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: login.php");
    exit;
}
if ($_SESSION["level"] !== 1) {
    header("location: login.php");
    exit;
}
include_once 'header_admin.php'
?>

<div>
    <h2>Welcome admin, <br>userid <b><?php echo htmlspecialchars($_SESSION["userid"]); ?> </b> <br> username
        <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> <br>Welcome to our site.</h2>
    <button type="button" name="log out" onclick="log_out()">Log out</button>
    <h2 id="loggedoutmsg" style="display: none"></h2>
</div>

</body>
</html>