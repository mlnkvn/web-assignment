<?php
    include_once 'header.php'
?>

<div style="padding-top: 8%; padding-bottom: 3%" align="center" id="login-block">
    <h3>LOGIN</h3>
        <form id="login-form" method="post" action="actions/loginscript.php" >
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
                    <td><input type="submit" name="submit" value="Log in" />
                </tr>
            </table>
        </form>
    </div>

<p style="text-align: center"><a href="register.php">Don't have an account? Create one!</a></p>

<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>All fields should be complete.</p>";
        }
        else if ($_GET["error"] == "unknownusername") {
            echo "<p>There is no user with given username.</p>";
        } 
        else if ($_GET["error"] == "wrongpassword") {
            echo "<p>Password missmatch. Check your username and password and try again.</p>";
        }
        else if ($_GET["error"] == "stmtfailed") {
            echo "<p>Something went wrong. Try again later.</p>";
        } 
    }
?>

</body>
</html>