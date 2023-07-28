<?php
include_once 'header_admin.php';
?>

<?php
require '../actions/db.php';
require_once '../actions/functionality.php';

function delete_item($id)
{
    require '../actions/db.php';
    if ($_GET['mode'] !== 'delete') {
        exit();
    }
    $sql = "DELETE FROM `items` WHERE itemId= ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    return "success"; //"Item with ID " . $id . " deleted successfully!";
}


// Get the search query from the URL parameter
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

$tmp = htmlspecialchars($searchQuery);
//    substr($tmp, 1, -1);
//    str_replace("%", "", $tmp);

// Output the search query
echo '<h1 align="center" style="margin-top: 7%;">Search Results for: ' . substr($tmp, 1, -1) . '</h1>';

// Connect to the database
require_once '../actions/db.php';

// Prepare the SQL statement
$sql = "SELECT * FROM `items` WHERE lower(itemName) LIKE ? OR lower(itemDescription) LIKE ?";
$stmt = mysqli_stmt_init($con);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    // Handle any errors here
    die('SQL Error: ' . mysqli_error($con));
}

$searchQuery = '%' . strtolower($searchQuery) . '%';
mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

mysqli_stmt_close($stmt);
$foundPHP = array();
// Display the search results
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

        <?php
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

        ?>

        function buildTable(tableElementHTML, tableId) {
            const table = document.getElementById(tableId);
            const items = <?php echo json_encode($foundPHP); ?>;

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
                        imgElement.querySelector('.item-name').setAttribute("contenteditable", "true");
                        imgElement.querySelector('#item-n-price').innerHTML = items[ind][4] + '€';
                        imgElement.querySelector('#item-n-price').setAttribute("contenteditable", "true");
                        imgElement.querySelector("#item-dest").href = "categoryadmin.php";
                        imgElement.querySelector('#add-to-cart').innerHTML = '';
                        imgElement.querySelector("#remove-from-cart").innerHTML = `<br><p style="color:red; font-size:16pt">DELETE</p>`;


                        (function (itemId) {
                            imgElement.querySelector('#remove-from-cart').addEventListener('click', function () {
                                deleteItem(itemId);
                            });
                        })(items[ind][0]);

                        // imgElement.querySelector('#remove-from-cart').addEventListener('click', function () {
                        //     var res = items[ind];
                        //     console.log(res);
                        //     executePHPFunction('deleteItem', [res]);
                        // }); // delete_item.bind(null, items[ind][0])

                        imgElement.style.backgroundSize = "contain";
                    }
                    row.appendChild(cell);
                }
                table.appendChild(row);
            }
        }

    </script>

<?php
include_once '../popup_card.php';
include_once '../footer.php';
?>