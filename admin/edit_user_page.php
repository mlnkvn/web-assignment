<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_admin.php';
?>

    <div class="user-settings" align="center" style="padding-top: 8%;">
        <h2 class="h3 mb-4 page-title">Settings</h2>
        <p style="display: inline;" id="error-msg"><?php
            if (isset($_GET["error"])) {
                echo '<script> showError(); </script>';
                if ($_GET["error"] == "invalidusername") {
                    echo "Provided username is incorrect. Correct username should contain latin letters and digits.";
                }
                else if ($_GET["error"] == "invalidemail") {
                    echo "Provided email is incorret.";
                }
                else if ($_GET["error"] == "wrongpassword") {
                    echo "Provided password doesn't match with actual one..";
                }
                else if ($_GET["error"] == "passwordmismatch") {
                    echo "New password and repeated new password missmatch. Check your new password and try again.";
                }
                else if ($_GET["error"] == "stmtfailed") {
                    echo "Something went wrong. Try again later.";
                }
                else if ($_GET["error"] == "none") {
                    echo "Your profile was sockcessfully edited!";
                }
            } else {
                echo '<script> hideError(); </script>';
            }
            ?></p>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="my-4">
                    <form method="post" onsubmit="checkForm()" action="../actions/edituserscript.php">
                        <input type="text" name="userId" value="<?php echo $_GET['id']; ?>" hidden="hidden" />
                        <hr class="my-4" />
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="userFullName">Full Name<img src="../img/error-img.png" alt="Oops!" id="error-userFullName" style="width: 6%; visibility: hidden;"></label>
                                <input type="text" id="userFullName" name="userFullName" class="form-control" value="<?php echo $_GET['fullname'] ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="userLogin">Username<img src="../img/error-img.png" alt="Oops!" id="error-userLogin" style="width: 6%; visibility: hidden;"></label>
                                <input type="text" class="form-control" id="userLogin" name="userLogin" value="<?php echo $_GET['username'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email<img src="../img/error-img.png" alt="Oops!" id="error-userEmail" style="width: 6%; visibility: hidden;"></label>
                            <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $_GET['useremail'] ?>" />
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address<img src="../img/error-img.png" alt="Oops!" id="error-inputAddress" style="width: 6%; visibility: hidden;"></label>
                            <input type="text" class="form-control" id="inputAddress" name="inputAddress"
                                   value="<?php
                                   if ($_GET['useraddress'] !== "null") {
                                       echo $_GET['useraddress'];
                                   } else {
                                       echo 'There is no delivery address associated with this user';
                                   }
                                   ?>" />
                        </div>
                        <hr class="my-4" />
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="level-user">
                                    <label for="level-user">Level</label>
                                    <select class="form-control" name="level-user" id="newPwd">
                                        <option value="0" id="opt_user">User</option>
                                        <option value="1" id="opt_adm">Admin</option>
                                    </select>
                                    <script>
                                        const res = "<?php echo $_GET['userlevel']; ?>";
                                        if (res === "1") {
                                            document.getElementById("opt_adm").setAttribute("selected", "selected");
                                        }
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label for="newPwd">New Password<img src="../img/error-img.png" alt="Oops!" id="error-newPwd" style="width: 8%; visibility: hidden;"></label>
                                    <input type="password" class="form-control" name="newPwd" id="newPwd" />
                                </div>
                                <div class="form-group">
                                    <label for="newPwdRepeat">Confirm Password<img src="../img/error-img.png" alt="Oops!" id="error-newPwdRepeat" style="width: 8%; visibility: hidden;"></label>
                                    <input type="password" class="form-control" name="newPwdRepeat" id="newPwdRepeat" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">Important note:</p>
                                <p class="small text-muted mb-2">Your new password has to differ from your previous password. Here are recommendations to create strong passwords:</p>
                                <ul class="small text-muted pl-4 mb-0">
                                    <li>Minimum 6 character</li>
                                    <li>At least one special character</li>
                                    <li>At least one number</li>
                                </ul>
                            </div>
                        </div>
                        <input type="submit" name="edit-user-submit" value="Save Changes" />
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
include_once '../footer.php'
?>