<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_user.php'
    ?>

<div align="center" id="login-block">
    <h2>Are you sure you want to log out?</h2>
    <form id="logout-confirm" method="post" action="../actions/logoutscript.php">
        <table>
            <tr>
                <td><input type="submit" name="back" value="Cancel" />
                <td><input type="submit" name="logout" value="Log out" />
            </tr>
        </table>
    </form>
</div>

</body>

</html>