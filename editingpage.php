<div class="user-settings" align="center" style="padding-top: 8%;">
    <h2 class="h3 mb-4 page-title">Settings</h2>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 mx-auto">
            <div class="my-4">
                <form method="post" onsubmit="checkForm()" action="../actions/editscript.php">
                    <hr class="my-4" />
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="userFullName">Full Name<img src="../img/error-img.png" alt="Oops!" id="error-userFullName" style="width: 6%; visibility: hidden;"></label>
                            <input type="text" id="userFullName" name="userFullName" class="form-control" value="<?php echo $_SESSION['userFullName'] ?>" />
                        </div>
                        <div class="form-group col-md-6">
                        <label for="userLogin">Username<img src="../img/error-img.png" alt="Oops!" id="error-userLogin" style="width: 6%; visibility: hidden;"></label>
                        <input type="text" class="form-control" id="userLogin" name="userLogin" value="<?php echo $_SESSION['username'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="userEmail">Email<img src="../img/error-img.png" alt="Oops!" id="error-userEmail" style="width: 6%; visibility: hidden;"></label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $_SESSION['useremail'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address<img src="../img/error-img.png" alt="Oops!" id="error-inputAddress" style="width: 6%; visibility: hidden;"></label>
                        <input type="text" class="form-control" id="inputAddress" name="inputAddress"
                            value="<?php 
                            if ($_SESSION['userAddress'] !== NULL) {
                                echo $_SESSION['userAddress']; 
                            } else {
                                echo 'There is no delivery address associated with you';
                            }
                            ?>" />
                    </div>
                    <hr class="my-4" />
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="oldPwd">Old Password<img src="../img/error-img.png" alt="Oops!" id="error-oldPwd" style="width: 8%; visibility: hidden;"></label>
                                <input type="password" class="form-control" name="oldPwd" id="oldPwd" />
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
                    <input type="submit" name="edit-submit" value="Save Changes" />
                </form>
            </div>
        </div>
    </div>
</div>
