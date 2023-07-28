<?php
include_once 'header_user.php'
?>
<?php
require_once '../actions/db.php';
require_once '../actions/functionality.php';
?>
    <div>
        <H1 style="text-align:center; padding-top: 100px;">Shopping cart</H1>
        <table id="shopping-cart-table" class="genericShoppingTable">
            <!-- Table content will be generated dynamically here -->
            <thead style="padding-top: 50px; height: 70px">
            <tr>
                <th>Delete</th>
                <th>Order</th>
                <th style="width:30%">Description</th>
                <th>Amount</th>
                <th>Price</th>
            </tr>
            </thead>
        </table>
    </div>

    <div style="text-align:center; margin-right: auto; margin-left: auto; margin-bottom: 50px; width: 300px">
        <button id="pay">Pay</button>
    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {
            buildCartTable("shopping-cart-table");
        });


        <?php
        session_start();
        $curOrder = getActiveOrder($con, $_SESSION['userId']);
        $orderItems = array();
        if ($curOrder !== false) {
            $orderItems = getItemsFromOrder($con, $curOrder['orderId']);
        }

        if (isset($_GET['funcAction']) && isset($_GET['function'])) {

            $action = $_GET['funcAction'];
            $functionName = $_GET['function'];
            if ($action === 'executeFunc') {
                $arguments = isset($_GET['arguments']) ? json_decode($_GET['arguments'], true) : array();
                $res = call_user_func($functionName, $arguments);
                echo $res;
                exit();
            }
        }

        function getItemPrice($con, $id)
        {
            $sql = "SELECT * FROM `items` WHERE itemId = ?;";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $fetched = mysqli_fetch_assoc($result);
            return $fetched['itemPrice'];
        }
        function getAmountInOrder($con, $itemId, $orderId)
        {
            $sql = "SELECT * FROM `orderedItems` WHERE itemId = ? AND orderId = ?;";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss", $itemId, $orderId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $fetched = mysqli_fetch_assoc($result);
            return $fetched['itemsAmount'];
        }

        function removeFromCurrentOrder($con, $orderId, $totalPrice, $amountInOrder)
        {
            $sql = "UPDATE orders SET orderAmount = ?, orderTotal = ? WHERE orderId = ?";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "error";
                exit();
            }
            mysqli_stmt_bind_param($stmt, "sss", $amountInOrder, $totalPrice, $orderId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return true;
        }

        function delete_item($id)
        {
            require '../actions/db.php';
            if ($_GET['mode'] !== 'delete') {
                exit();
            }
            session_start();
            $usId = $_SESSION['userId'];
            $curOrd = getActiveOrder($con, $usId);
            $priceForOne = getItemPrice($con, $id);
            $amountInOrder = getAmountInOrder($con, $id, $curOrd['orderId']);
            $sql = "DELETE FROM `orderedItems` WHERE itemId=? AND orderId=?;";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "error";
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss", $id, $curOrd['orderId']);
            mysqli_stmt_execute($stmt);
            removeFromCurrentOrder($con, $curOrd['orderId'], $curOrd['orderTotal'] - $priceForOne * $amountInOrder, $curOrd['orderAmount'] - $amountInOrder);
            return "success";
        }

        ?>

        function buildCartTable(tableId) {
            const table_ = document.getElementById(tableId);
            const table = document.createElement("tbody");
            const items = <?php echo json_encode($orderItems); ?>;
            const amounts = [];
            const prices = [];

            function deleteItem(itemId) {
                var xhr = new XMLHttpRequest();
                var url = '?mode=delete&funcAction=executeFunc&function=delete_item&arguments=' + JSON.stringify(itemId);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var result = xhr.responseText.split("\n");
                        if (result[result.length - 1].trim() === "success") {
                            location.reload();
                        }
                    }
                };
                xhr.open('GET', url, true);
                xhr.send();
            }


            for (let j = 0; j < items.length; j++) {
                const row = document.createElement("tr");
                const cell2 = document.createElement("td");
                cell2.innerHTML = `<div class="buttons-cart">
                <img class="delete-btn"/>
                    </div>`
                cell2.querySelector('.delete-btn').src = "../admin/img/cancel_icon.png";
                (function (itemId) {
                    cell2.querySelector('.buttons-cart').addEventListener('click', function () {
                        deleteItem(itemId);
                    });
                })(items[j][0]);

                row.appendChild(cell2);


                const cell1 = document.createElement("td");
                cell1.innerHTML = `<div class="image-cart">
                <img class="item-img-cart" src="item-1.png" alt="There is no image yet for this item"/>
             </div>`
                cell1.querySelector('.item-img-cart').src = "../img/" + items[j][5];
                cell1.querySelector('.item-img-cart').style.height = "150px";
                row.appendChild(cell1);


                const cell3 = document.createElement("td");
                cell3.innerHTML = `<div class="description-cart">
                <span class="item-name-cart"></span>
                </div>`
                cell3.querySelector('.item-name-cart').innerHTML = items[j][3];
                row.appendChild(cell3);

                const cell4 = document.createElement("td");
                cell4.innerHTML = `<div class="quantity-cart">
            <button class="edit-btn minus-btn" type="button" name="button">
                <p>-</p>
            </button>
            <input type="text" id="quantity-label" name="name" class="amount-item-cart" value="1">
        
            <button class="edit-btn plus-btn" type="button" name="button">
                <p>+</p>
            </button>
        </div>`

                cell4.querySelector('.minus-btn').addEventListener('click', function () {
                    if (parseInt(cell4.querySelector(".amount-item-cart").value) == 1) return;
                    const amount = parseInt(cell4.querySelector(".amount-item-cart").value);
                    const price_ = row.querySelector('.total-price-cart').innerHTML;
                    const price = parseInt(price_.substring(0, price_.length - 1)) / amount;
                    row.querySelector('.total-price-cart').innerHTML = price * (amount - 1) + '€';
                    cell4.querySelector(".amount-item-cart").value = amount - 1;
                    amounts[j] = amount - 1;
                    prices[j] = price * (amount - 1);
                    document.location.href = "../actions/reload_order_info.php?load=true&id=" + items[j][0].toString() + "&amount=" + (amount - 1).toString();

                });
                cell4.querySelector('.plus-btn').addEventListener('click', function () {
                    if (parseInt(cell4.querySelector(".amount-item-cart").value) == 100) return;
                    const amount = parseInt(cell4.querySelector(".amount-item-cart").value);
                    const price_ = row.querySelector('.total-price-cart').innerHTML;
                    const price = parseInt(price_.substring(0, price_.length - 1)) / amount;
                    row.querySelector('.total-price-cart').innerHTML = price * (amount + 1) + '€';
                    cell4.querySelector(".amount-item-cart").value = amount + 1;
                    amounts[j] = amount + 1;
                    prices[j] = price * (amount + 1);
                    document.location.href = "../actions/reload_order_info.php?load=true&id=" + items[j][0].toString() + "&amount=" + (amount + 1).toString();

                });

                cell4.querySelector('.amount-item-cart').value = items[j][1];
                row.appendChild(cell4);
                amounts[j] = items[j][1];


                const cell5 = document.createElement("td");
                cell5.innerHTML = `<div class="total-price">
                 <span class="total-price-cart"></span>
                </div>`
                cell5.querySelector('.total-price-cart').innerHTML = items[j][4] + '€';
                prices[j] = items[j][4];
                row.appendChild(cell5);
                table.appendChild(row);
            }
            table_.appendChild(table);

            document.getElementById("pay").addEventListener('click', function () {
                // const amounts = document.getElementsByClassName("amount-item-cart");
                // const prices = document.getElementsByClassName("total-price-cart");
                console.log(amounts);
                console.log(prices);

                var sum = 0;
                var total = 0;
                for (let i = 0; i < items.length; i++) {
                    sum += amounts[i];
                    total += prices[i];
                    document.location.href = "../actions/reload_order_info.php?load=true&id=" + items[i][0].toString() + "&amount=" + amounts[i];
                    // console.log("../actions/reload_order_info.php?load=true&id=" + items[i][0].toString() + "&amount=" + amounts[i] + "&total=" + prices[i] + "&last=true");
                    // document.location.href = "../actions/reload_order_info.php?load=true&id=" + items[i][0].toString() + "&amount=" + amounts[i] + "&total=" + prices[i] + "&last=false";

                }
                document.location.href = "../actions/set_order_info.php?load=true&amount=" + sum + "&total=" + total;
            });

        }
    </script>

<?php include_once '../footer.php' ?>