<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_user.php'
?>

<div>
    <h2>Here sddress management is</h2>
</div>

</body>
</html>