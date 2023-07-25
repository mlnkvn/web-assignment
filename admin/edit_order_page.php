<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_admin.php';
?>
    <!--    "edit_order_page.php?id=" + orders[j][0] + "&userId=" + orders[j][2] + "&status=" + orders[j][5] + "&address=" + orders[j][6];-->

    <div class="order-settings" align="center" style="padding-top: 8%;">
        <h2 class="h3 mb-4 page-title">Settings</h2>
        <p style="display: inline;" id="error-msg"><?php
            if (isset($_GET["error"])) {
                echo '<script> showError(); </script>';
                if ($_GET["error"] == "stmtfailed") {
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
                    <form method="post" onsubmit="checkForm()" action="../actions/editorderscript.php">
                        <input type="text" name="orderId" value="<?php echo $_GET['id']; ?>" hidden="hidden"/>
                        <hr class="my-4"/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="userId">UserID<img src="../img/error-img.png" alt="Oops!"
                                                               id="error-userLogin"
                                                               style="width: 6%; visibility: hidden;"></label>
                                <input type="text" class="form-control" id="userId" name="userId"
                                       value="<?php echo $_GET['userId'] ?>" disabled/>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="status-order">
                                    <label for="status-order">Order Status</label>
                                    <select class="form-control" name="status-order" id="status-order">
                                        <option value="0" id="opt_0">Not submited</option>
                                        <option value="1" id="opt_1">Processed</option>
                                        <option value="2" id="opt_2">Done</option>
                                    </select>
                                    <script>
                                        const res = "<?php echo $_GET['status']; ?>";
                                        document.getElementById("opt_" + res).setAttribute("selected", "selected");
                                    </script>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Delivery Address<img src="../img/error-img.png" alt="Oops!"
                                                                           id="error-inputAddress"
                                                                           style="width: 6%; visibility: hidden;"></label>
                            <input type="text" class="form-control" id="inputAddress" name="inputAddress"
                                   value="<?php
                                   if ($_GET['address'] !== "null") {
                                       echo $_GET['address'];
                                   } else {
                                       echo 'There is no delivery address associated with this user';
                                   }
                                   ?>"/>
                        </div>
                        <input type="submit" name="edit-order-submit" value="Save Changes"/>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
include_once '../footer.php'
?>