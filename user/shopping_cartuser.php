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

<script>
    function proceed_to_pay() {
        document.location = "shopping_cartuser.php";
    }
</script>

<div style="text-align:center; margin-right: auto; margin-left: auto; margin-bottom: 50px; width: 300px">
    <button id="pay" onclick="proceed_to_pay()">Pay</a>
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

    function delete_item($id)
    {
        // echo "function called";
        require '../actions/db.php';
        if ($_GET['mode'] !== 'delete') {
            exit();
        }
        $sql = "DELETE FROM `orderedItems` WHERE itemId= ?;";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "error";
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        // $result = mysqli_stmt_get_result($stmt);
        // echo $result;
        return "success"; //"Item with ID " . $id . " deleted successfully!";
    }

    ?>

    function buildCartTable(tableId) {
        const table_ = document.getElementById(tableId);
        const table = document.createElement("tbody");
        // [itemId, itemsAmount, itemSize, itemName, itemAmount * itemPrice, picLink]
        const items = <?php echo json_encode($orderItems); ?>;
        // console.log(items);


        function deleteItem(itemId) {
            var xhr = new XMLHttpRequest();
            var url = '?mode=delete&funcAction=executeFunc&function=delete_item&arguments=' + JSON.stringify(itemId);
            console.log(url);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var result = xhr.responseText.split("\n");
                    console.log(result[result.length - 1].trim()); // Display the result in the console or update the page as needed
                    if (result[result.length - 1].trim() === "success") {
                        location.reload();
                    }
                }
            };
            xhr.open('GET', url, true);
            xhr.send();
        }



        // Create table row and insert fetched HTML content into a single cell
        for (let j = 0; j < items.length; j++) {
            for (let i = 0; i < items[j].length; i++) {
                console.log(items[j][i]);
            }
            const row = document.createElement("tr");

            const cell2 = document.createElement("td");
            cell2.innerHTML = `<div class="buttons-cart">
                <img class="delete-btn"/>
                    </div>`
            cell2.querySelector('.delete-btn').src = "../img/cancel_icon.png";
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
            <input type="text" name="name" class="amount-item-cart" value="1">
        
            <button class="edit-btn plus-btn" type="button" name="button">
                <p>+</p>
            </button>
        </div>`

            cell4.querySelector('.minus-btn').addEventListener('click', function () {
                // Modify the content of the input field when the button is clicked
                if (parseInt(cell4.querySelector(".amount-item-cart").value) == 1) return;
                const amount = parseInt(cell4.querySelector(".amount-item-cart").value);
                const price_ = row.querySelector('.total-price-cart').innerHTML;
                const price = parseInt(price_.substring(0, price_.length - 1)) / amount;
                row.querySelector('.total-price-cart').innerHTML = price * (amount - 1) + '€';
                cell4.querySelector(".amount-item-cart").value = amount - 1;
            });
            cell4.querySelector('.plus-btn').addEventListener('click', function () {
                // Modify the content of the input field when the button is clicked
                if (parseInt(cell4.querySelector(".amount-item-cart").value) == 100) return;
                const amount = parseInt(cell4.querySelector(".amount-item-cart").value);
                const price_ = row.querySelector('.total-price-cart').innerHTML;
                const price = parseInt(price_.substring(0, price_.length - 1)) / amount;
                row.querySelector('.total-price-cart').innerHTML = price * (amount + 1) + '€';
                cell4.querySelector(".amount-item-cart").value = amount + 1;

            });

            cell4.querySelector('.amount-item-cart').value = items[j][1];
            row.appendChild(cell4);


            const cell5 = document.createElement("td");
            cell5.innerHTML = `<div class="total-price">
                 <span class="total-price-cart"></span>
                </div>`
            cell5.querySelector('.total-price-cart').innerHTML = items[j][4] + '€';
            row.appendChild(cell5);


            // cell.innerHTML = tableElementHTML.querySelector("");
            // const imgElement = cell.querySelector('.shopping-cart-item');
            // if (imgElement) {
            //     imgElement.querySelector('.item-img-cart').src = "../img/" + items[j][5];
            //     imgElement.querySelector('.item-img-cart').style.height = "25%";

            //     imgElement.querySelector('.item-name-cart').innerHTML = items[j][3];
            //     imgElement.querySelector('.amount-item-cart').value = items[j][1];
            //     imgElement.querySelector('.total-price-cart').innerHTML = items[j][4] + '€';

            // }
            table.appendChild(row);
        }
        table_.appendChild(table);

    }
</script>

<?php include_once 'footer.php' ?>