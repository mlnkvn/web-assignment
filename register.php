<?php
    include_once 'header.php'
?>

<div style="padding-top: 8%; padding-bottom: 3%" align="center" id="register-block">

    <h3>REGISTER</h3>
    <form id="register-form" method="post" action="actions/registerscript.php" >
        <table border="0.5">
            <tr>
                <td><label for="user_name">Name</label></td>
                <td><input type="text" name="user_name" id="user_name"></td>
            </tr>
            <tr>
                <td><label for="user_email">Email</label></td>
                <td><input type="text" name="user_email" id="user_email"></td>
            </tr>
            <tr>
                <td><label for="user_id">User name</label></td>                    
                <td><input type="text" name="user_id" id="user_id"></td>
            </tr>
            <tr>
                <td><label for="user_pass">Password</label></td>
                <td><input type="password" name="user_pass" id="user_pass"></input></td>
            </tr>
            <tr>
                <div id="last-line">
                    <td><input type="reset" value="Reset"/>
                    <td><input type="submit" name="submit" value="Register"/>
                </div>
            </tr>
        </table>
    </form>
</div>

<p style="text-align: center"><a href="login.php">I already have an account</a></p>



<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>All fields should be complete.</p>";
        }
        else if ($_GET["error"] == "invaliduid") {
            echo "<p>Provided username is incorrect. Correct username should contain latin letters and digits.</p>";
        } 
        else if ($_GET["error"] == "invalidemail") {
            echo "<p>Provided email is incorret.</p>";
        }
        else if ($_GET["error"] == "existinguserid") {
            echo "<p>This username is already taken.</p>";
        }
        else if ($_GET["error"] == "stmtfailed") {
            echo "<p>Something went wrong. Try again later.</p>";
        } 
        else if ($_GET["error"] == "none") {
            echo "<p>You registered successfully! Now you can log in.</p>";
        } 
    }
?>

</body>
</html>