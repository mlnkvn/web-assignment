<?php
session_start();

if ($_SESSION["loggedIn"] !== true) {
    header("location: ../login.php");
    exit;
}

include_once 'header_user.php'
?>


    <div>
        <h2 style="text-align: center; margin-top: 7%;">Your completed orders</h2>
        <table id="orders-table" class="genericTable" style="border: rgba(192,94,0,0.94); margin-left:auto; margin-right:auto;
        margin-top: 3%;">
            <!-- Table content will be generated dynamically here -->
        </table>
    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {

            buildTable("orders-table");
        });

        <?php
        require_once '../actions/db.php';
        $sql = "SELECT `orderDate`, `orderAmount`, `orderTotal`  FROM `orders` WHERE userId = ? AND orderStatus = 1;";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $_SESSION["userId"]);
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

        function buildTable(tableId) {
            const table = document.getElementById(tableId);
            table.style.margin = "auto";
            table.style.marginTop = "3%";
            table.style.tableLayout = "auto";
            var orders = <?php echo json_encode($ordersPHP); ?>;
            // Create table row and insert fetched HTML content into a single cell
            const headerTitles = ["Date", "Items amount", "Total"]
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
                    if (i === orders[j].length - 1) {
                        cell.innerHTML += '€';
                    }
                    row.appendChild(cell);
                }
                table.appendChild(row);
            }
        }


    </script>

<?php
include_once '../footer.php';
?>