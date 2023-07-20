<?php
include_once 'header_user.php'
?>
<?php
function getItemsWith($cat, $subcat, $pageBack)
{
    require_once '../actions/db.php';
    $sql = "SELECT * FROM `items` WHERE 1;";
    if ($cat === "socks") {
        if ($subcat === "all") {
            $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
        } else {
            $sql = "SELECT * FROM `items` WHERE itemCategory=? AND itemSubCategory=?;";
        }
    }
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($pageBack);
        exit();
    }
    if ($cat === "socks") {
        if ($subcat === "all") {
            mysqli_stmt_bind_param($stmt, "s", $cat);
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $cat, $subcat);
        }
    }
//    mysqli_stmt_bind_param($stmt, "s", $cat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $arr[] = $it;
    }
    return $arr;
}

?>
    <script>
        function updCats(cat, subcat) {
            window.location.assign("categoryuser.php#" + cat + "_" + subcat);
        }
    </script>
    <!--Side navigation bar-->
    <div style="width: 100%; margin-top: 7%">
        <div class="side-nav-categories" style="width: 20%; float: left;">
            <div class="title"><strong>Category</strong></div>
            <ul id="category-tabs">
                <li><a href="javascript:updCats('socks', 'all')" class="main-category">Socks</a>
                    <ul class="sub-category-tabs">
                        <li><a href="javascript:updCats('socks', 'all')">All socks</a></li>
                        <li><a href="javascript:updCats('socks', 'basic')">Basic</a></li>
                        <li><a href="javascript:updCats('socks', 'colored')">Multicolored</a></li>
                        <li><a href="javascript:updCats('socks', 'memes')">With memes</a></li>
                    </ul>
                </li>
            </ul>
            <ul id="category-tabs">
                <li><a href="javascript:void" class="main-category">Head wear</a>
                </li>
            </ul>
            <ul id="category-tabs">
                <li><a href="javascript:void" class="main-category">Gifts</a>
                    <ul class="sub-category-tabs">
                        <li><a href="javascript:void">Gift cards</a></li>
                        <li><a href="javascript:void">Gift sets</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div>
            <table id="item-table-user" class="genericTable">
                <!-- Table content will be generated dynamically here -->
            </table>
        </div>

    </div>


    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {

            fetchAndBuildTable("item-table-user", "../item_view.php");
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
            const name = location.href.split('#')[1];
            document.cookie = "cat = " + name.split('_')[0] + "subcat = " + name.split('_')[1];
            <?php
            $category = $_COOKIE['cat'];
            $subcategory = $_COOKIE['subcat'];
//            echo $category.' '.$subcategory;
            $itemsPHP = getItemsWith($category, $subcategory, "categoryuser.php");
            ?>
            var items = <?php echo json_encode($itemsPHP); ?>;
            // Create table row and insert fetched HTML content into a single cell
            for (let j = 0; j < 4; j++) {
                const row = document.createElement("tr");
                for (let i = 0; i < 3; i++) {
                    var ind = 3 * j + i;
                    if (ind >= items.length) {
                        break;
                    }
                    const cell = document.createElement("td");
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


<?php include_once '../footer.php' ?>