<?php
include_once 'header_user.php';
session_start();
?>

    <div class="row-checkout" style="width: 80%; margin-left: auto; margin-right: auto; margin-top: 7%;">
        <div class="col-75">
            <div class="container-checkout">
                <form action="">
                    <div class="row-checkout">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" id="fname" name="firstname"
                                   value="<?php echo $_SESSION['userFullName'] ?>">
                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="text" id="email" name="email" value="<?php echo $_SESSION['useremail'] ?>">
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="adr" name="address" value="<?php
                            if ($_SESSION['userAddress'] !== null) {
                                echo $_SESSION['userAddress'];
                            }
                            ?>" placeholder="Delivery address">
                            <label for="city"><i class="fa fa-institution"></i> City</label>
                            <input type="text" id="city" name="city" placeholder="City for delivery">

                            <div class="row-checkout">
                                <div class="col-50">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" placeholder="State">
                                </div>
                                <div class="col-50">
                                    <label for="zip">Zip</label>
                                    <input type="text" id="zip" name="zip" placeholder="10001">
                                </div>
                            </div>
                        </div>

                        <div class="col-50">
                            <h3>Payment</h3>
                            <label for="fname">Accepted Cards</label>
                            <div class="icon-container">
                                <i class="fa fa-cc-visa" style="color:navy;"></i>
                                <i class="fa fa-cc-amex" style="color:blue;"></i>
                                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                <i class="fa fa-cc-paypal" style="color:navy;"></i>
                            </div>
                            <label for="cname">Name on Card</label>
                            <input type="text" id="cname" name="cardname"
                                   placeholder="<?php echo $_SESSION['userFullName']; ?>">
                            <label for="ccnum">Credit card number</label>
                            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                            <label for="expmonth">Exp Month</label>
                            <input type="text" id="expmonth" name="expmonth" placeholder="September">

                            <div class="row-checkout">
                                <div class="col-50">
                                    <label for="expyear">Exp Year</label>
                                    <input type="text" id="expyear" name="expyear" placeholder="2024">
                                </div>
                                <div class="col-50">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="352">
                                </div>
                            </div>
                        </div>

                    </div>
                    <label>
                        <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                    </label>
                    <input type="submit" value="Continue to checkout" class="btn">
                </form>
            </div>
        </div>

        <div class="col-25">
            <div class="container-checkout">
                <h4>Cart
                    <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
          <b>4</b>
        </span>
                </h4>
                <div>
                    <table id="shopping-bag-table" class="genericTable">
                        <!-- Table content will be generated dynamically here -->
                    </table>
                </div>

                <script type="text/javascript">

                    document.addEventListener("DOMContentLoaded", function () {
                        buildCartTable("shopping-bag-table");
                    });

                    <?php
                    require_once '../actions/db.php';
                    require_once '../actions/functionality.php';
                    $curOrder = getActiveOrder($con, $_SESSION['userId']);
                    $orderItems = array();
                    if ($curOrder !== false) {
                        $orderItems = getItemsFromOrder($con, $curOrder['orderId']);
                    }
                    ?>

                    function buildCartTable(tableId) {
                        const table = document.getElementById(tableId);
                        // [itemId, itemsAmount, itemSize, itemName, itemAmount * itemPrice, picLink]
                        const items = <?php echo json_encode($orderItems); ?>;
                        console.log(items);
                        table.style.marginLeft = "1%";
                        table.style.marginRight = "1%";

                        // Create table row and insert fetched HTML content into a single cell
                        for (let j = 0; j < items.length; j++) {
                            const row = document.createElement("tr");
                            const cell = document.createElement("td");
                            cell.innerHTML = items[j][3];
                            cell.style.fontSize = "14px";
                            cell.style.width = "90%"
                            row.appendChild(cell);
                            const cell2 = document.createElement("td");
                            cell2.innerHTML = items[j][4] + '€';
                            row.appendChild(cell2);
                            cell2.style.width = "10%";
                            cell2.style.color = "grey";
                            row.style.marginLeft = "auto";
                            row.style.marginRight = "auto";
                            table.appendChild(row);
                        }
                        table.appendChild(document.createElement("hr"));
                        const row = document.createElement("tr");
                        const cell = document.createElement("td");
                        cell.innerHTML = "Total";
                        cell.style.fontSize = "14px";
                        cell.style.width = "90%"
                        row.appendChild(cell);
                        const cell2 = document.createElement("td");
                        cell2.innerHTML = "<b><?php echo $curOrder['orderTotal'].'€'; ?></b>";
                        cell2.style.width = "10%";
                        cell2.style.color = "black";
                        row.style.marginLeft = "auto";
                        row.style.marginRight = "auto";
                        row.appendChild(cell2);
                        table.appendChild(row);
                    }
                </script>
            </div>
        </div>
    </div>


<?php
include_once '../footer.php'
?>