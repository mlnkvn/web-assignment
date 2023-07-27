<?php
include_once 'header_admin.php'
?>

<?php
session_start();
$myId = $_SESSION['userId'];
?>

<div>
    <h2 style="text-align: center; margin-top: 7%;">All orders</h2>
    <table id="orders-admin-table" class="genericTable" style="border: rgba(192,94,0,0.94); margin-left:auto; margin-right:auto;
        margin-top: 3%;">
        <!-- Table content will be generated dynamically here -->
    </table>
</div>

<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {

        fetchAndBuildTable("orders-admin-table", "button_edit.php");
    });

    function fetchAndBuildTable(tableId, phpFileName) {
        // Use AJAX to fetch table element HTML from PHP file
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                const tableElementHTML = this.responseText;
                buildTable(tableElementHTML, tableId);
            }
        };

        xhttp.open("GET", phpFileName, true);
        xhttp.send();
    }

    <?php
    require_once '../actions/db.php';
    $sql = "SELECT `orderId`, `orderDate`, `userId`, `orderAmount`, `orderTotal`, `orderStatus`, `orderDestination`  FROM `orders` WHERE 1;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ordersPHP = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $ordersPHP[] = $it;
    }
    ?>

    function buildTable(tableElementHTML, tableId) {
        const table = document.getElementById(tableId);
        table.style.margin = "auto";
        table.style.marginTop = "3%";
        table.style.tableLayout = "auto";
        var orders = <?php echo json_encode($ordersPHP); ?>;
        // Create table row and insert fetched HTML content into a single cell
        const headerTitles = ["ID", "Date", "Buyer Id", "Items amount", "Total", "Status", "Delivery address", "Edit", "Delete"]
        const header = document.createElement("tr");
        for (let i = 0; i < headerTitles.length; ++i) {
            const cell = document.createElement("th");
            cell.innerHTML = headerTitles[i];
            header.appendChild(cell);
        }
        table.appendChild(header);
        for (let j = 0; j < orders.length; j++) {
            const row = document.createElement("tr");
            for (let i = 0; i < orders[j].length; i++) {
                const cell = document.createElement("td");
                cell.innerHTML = orders[j][i];
                if (headerTitles[i] === 'Total') {
                    cell.innerHTML += '€';
                }
                if (headerTitles[i] === 'Date' && orders[j][i] == null) {
                    cell.innerHTML = "Not processed yet";
                }
                if (headerTitles[i] === 'Status') {
                    const stats = ['Not payed', 'Processed'];
                    cell.innerHTML = stats[orders[j][i]];
                }
                if (headerTitles[i] === 'Delivery address' && orders[j][i] == null) {
                    cell.innerHTML = "No address was provided yet";
                }
                row.appendChild(cell);
            }
            const cell1 = document.createElement("td");
            cell1.innerHTML = tableElementHTML;
            cell1.style.width = "fit-content";
            cell1.addEventListener('click', function () {
                // const headerTitles = ["ID", "Date", "Buyer Id", "Items amount", "Total", "Status", "Delivery address", "Edit", "Delete"]
                window.location.href = "edit_order_page.php?id=" + orders[j][0] + "&userId=" + orders[j][2] + "&status=" + orders[j][5] + "&address=" + orders[j][6];
            });
            row.appendChild(cell1);
            const cell2 = document.createElement("td");
            cell2.innerHTML = tableElementHTML;
            cell2.querySelector(".button-img").src = "img/cancel_icon.png";
            cell2.addEventListener('click', function () {
                alert("Are you sure you want to delete order №" + orders[j][0] + "?");
                window.location.href = "../actions/delete_order_script.php?orderId=" + orders[j][0] + "&admId=" + "<?php echo $myId; ?>";
            });
            row.appendChild(cell2);
            table.appendChild(row);
        }
    }


</script>
<?php
include '../footer.php';
?>