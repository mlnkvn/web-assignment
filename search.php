<?php
include_once 'header.php';
session_reset();
?>

<?php
require_once 'actions/db.php';
require_once 'actions/functionality.php';
?>

<?php
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';
$tmp = htmlspecialchars($searchQuery);
echo '<h1 align="center" style="margin-top: 7%;">Search Results for: ' . substr($tmp, 1, -1) . '</h1>';
$sql = "SELECT * FROM `items` WHERE lower(itemName) LIKE ? OR lower(itemDescription) LIKE ?";
$stmt = mysqli_stmt_init($con);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die('SQL Error: ' . mysqli_error($con));
}

$searchQuery = '%' . strtolower($searchQuery) . '%';
mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

$foundPHP = array();
while ($row = mysqli_fetch_assoc($result)) {
    $arr = array();
    foreach ($row as $k => $v) {
        $arr[] = $v;
    }
    $foundPHP[] = $arr;
}
?>
    <div>
        <table id="search-table-user" class="genericTable"
               style="width: 75%; margin-left: auto; margin-right: auto; margin-top: 3%;" align="center">
            <!-- Table content will be generated dynamically here -->
        </table>
    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {

            fetchAndBuildTable("search-table-user", "../item_view.php");
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

        function buildTable(tableElementHTML, tableId) {
            const table = document.getElementById(tableId);
            const items = <?php echo json_encode($foundPHP); ?>;
            // Create table row and insert fetched HTML content into a single cell
            for (let j = 0; j < 4; j++) {
                const row = document.createElement("tr");
                for (let i = 0; i < 3; i++) {
                    const ind = 3 * j + i;
                    const cell = document.createElement("td");
                    if (ind >= items.length) {
                        row.appendChild(cell);
                        continue;
                    }
                    cell.innerHTML = tableElementHTML;
                    const imgElement = cell.querySelector('.item-container-class');
                    if (imgElement) {
                        imgElement.style.background = "black url(../img/" + items[ind][6] + ')';
                        imgElement.querySelector('.item-name').innerHTML = items[ind][3];
                        imgElement.querySelector('.price').innerHTML = items[ind][4] + '€';
                        imgElement.style.backgroundSize = "contain";
                    }
                    row.appendChild(cell);
                }
                table.appendChild(row);
            }
        }

    </script>
<?php
include_once 'popup_card.php';
include_once 'footer.php';
?>