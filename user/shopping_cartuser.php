<?php
include_once 'header_user.php'
?>
<?php
require_once '../actions/db.php';
require_once '../actions/functionality.php';
?>
    <div>
        <table id="shopping-cart-table" class="genericShoppingTable">
            <!-- Table content will be generated dynamically here -->
        </table>
    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {
            fetchAndBuildCartTable("shopping-cart-table", "shoppingbag_view.php");
        });

        function fetchAndBuildCartTable(tableId, phpFileName) {
            // Use AJAX to fetch table element HTML from PHP file
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const tableElementHTML = this.responseText;
                    buildCartTable(tableElementHTML, tableId);
                }
            };

            xhttp.open("GET", phpFileName, true);
            xhttp.send();
        }

        <?php
        session_start();

        $curOrder = getActiveOrder($con, $_SESSION['userId']);
        $orderItems = array();
        if ($curOrder !== false) {
            $orderItems = getItemsFromOrder($con, $curOrder['orderId']);
        }
        ?>

        function buildCartTable(tableElementHTML, tableId) {
            const table = document.getElementById(tableId);
            // [itemId, itemsAmount, itemSize, itemName, itemAmount * itemPrice, picLink]
            const items = <?php echo json_encode($orderItems); ?>;
            console.log(items);

            // Create table row and insert fetched HTML content into a single cell
            for (let j = 0; j < items.length; j++) {
                const row = document.createElement("tr");
                const cell = document.createElement("td");
                cell.innerHTML = tableElementHTML;
                const imgElement = cell.querySelector('.shopping-cart-item');
                if (imgElement) {
                    imgElement.querySelector('.item-img-cart').src = "../img/" + items[j][5];
                    imgElement.querySelector('.item-img-cart').style.height = "25%";

                    imgElement.querySelector('.item-name-cart').innerHTML = items[j][3];
                    imgElement.querySelector('.amount-item-cart').value = items[j][1];
                    imgElement.querySelector('.total-price-cart').innerHTML = items[j][4] + '€';

                    // imgElement.style.background = "black url(../img/" + items[ind][6] + ')';
                    // imgElement.querySelector('.item-name').innerHTML = items[ind][3];
                    // imgElement.querySelector('.price').innerHTML = items[ind][4] + '€';
                    // imgElement.style.backgroundSize = "contain";
                    // console.log(ind + ': ' + window.location.href + " + _ + " + items[ind][0].toString());
                    // imgElement.querySelector("#item-dest").href = window.location.href + "_" + items[ind][0].toString() + "#shadowed-back";
                }
                row.appendChild(cell);
                table.appendChild(row);
            }
        }
    </script>

<?php include_once 'footer.php' ?>