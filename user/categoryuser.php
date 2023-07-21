<?php
include_once 'header_user.php'
?>
<?php
require_once '../actions/db.php';
require_once '../actions/functionality.php';
?>
    <!--Side navigation bar-->
    <div style="width: 100%; margin-top: 7%">
        <div class="side-nav-categories" style="width: 20%; float: left;">
            <div class="title"><strong>Category</strong></div>
            <ul id="category-tabs">
                <li><a href="categoryuser.php?cat=all_all">All products</a></li>
            </ul>
            <ul id="category-tabs">
                <li><a href="categoryuser.php?cat=socks_all" class="main-category">Socks</a>
                    <ul class="sub-category-tabs">
                        <li><a href="categoryuser.php?cat=socks_all">All socks</a></li>
                        <li><a href="categoryuser.php?cat=socks_basic">Basic</a></li>
                        <li><a href="categoryuser.php?cat=socks_pattern">With patterns</a></li>
                        <li><a href="categoryuser.php?cat=socks_memes">With memes</a></li>
                    </ul>
                </li>
            </ul>
            <ul id="category-tabs">
                <li><a href="categoryuser.php?cat=headwear_all" class="main-category">Head wear</a>
                </li>
            </ul>
            <ul id="category-tabs">
                <li><a href="categoryuser.php?cat=card_all">Gift cards</a></li>
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

        <?php
        if (isset($_GET['cat'])) {
            $cats = explode("_", $_GET['cat']);
            $category = $cats[0];
            $subcategory = $cats[1];
        } else {
            $category = "all";
            $subcategory = "all";
        }
        $itemsPHP = getItemsWith($con, $category, $subcategory);
        ?>

        function buildTable(tableElementHTML, tableId) {
            const table = document.getElementById(tableId);
            var items = <?php echo json_encode($itemsPHP); ?>;
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
                        imgElement.querySelector("#item-dest").href = location.href + "_" + items[ind][0].toString() + "#shadowed-back";
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