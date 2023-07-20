<?php
include_once 'header_user.php'
?>
<?php
function getItemsWith($cat, $subcat)
{
    require_once '../actions/db.php';
    if ($cat === "all") {
        $sql = "SELECT * FROM `items` WHERE 1;";
    } else if ($subcat === "all") {
        $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
    } else {
        $sql = "SELECT * FROM `items` WHERE itemCategory=? AND itemSubCategory=?;";
    }
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    if ($cat === "all") {
        //
    } else if ($subcat === "all") {
        mysqli_stmt_bind_param($stmt, "s", $cat);
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $cat, $subcat);
    }
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
        $itemsPHP = getItemsWith($category, $subcategory);
        ?>

        function buildTable(tableElementHTML, tableId) {
            const table = document.getElementById(tableId);
            var items = <?php echo json_encode($itemsPHP); ?>;
            // Create table row and insert fetched HTML content into a single cell
            for (let j = 0; j < 4; j++) {
                const row = document.createElement("tr");
                for (let i = 0; i < 3; i++) {
                    var ind = 3 * j + i;
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
                        imgElement.querySelector("#item-dest").href = "#shadowed-back";
                        imgElement.querySelector("#item-dest").onclick = displayItem(items[ind]);
                    }
                    row.appendChild(cell);
                }
                table.appendChild(row);
            }
        }

    </script>

    <script>
        function addToCart() {
        }

        function displayItem(itemRow) {
            document.getElementById("item-img-img").src = "../img/" + itemRow[6];
            return "#shadowed-back";
        }
    </script>

    <div id="shadowed-back">
        <script>
            var displayed_items = document.getElementsByClassName("item-container-class");
            console.log(displayed_items);
            for (let i = 0; i < displayed_items.length; i++) {
                displayed_items[i].disable();
            }
        </script>
        <div class="pop-up-container">
            <a href="" class="close-button" onclick="closeElemPopUP()">x</a>
            <div class="item-image">
                <img src="../img/socks-kitty.png" id="item-img-img" style="width: 80%; height: auto;"
                     alt="There is no picture for this product"/>
            </div>
            <div class="slideshow-buttons">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
                <div class="four"></div>
            </div>
            <p class="pick">choose size</p>
            <div class="sizes">
                <div class="size" onclick="pickSize(0)">32-35</div>
                <div class="size" onclick="pickSize(1)">36-49</div>
                <div class="size" onclick="pickSize(2)">40-45</div>
                <div class="size" onclick="pickSize(3)">46+</div>
                <script>
                    function pickSize(ind) {
                        var sizeButtons = document.getElementsByClassName("size");
                        for (let i = 0; i < sizeButtons.length; i++) {
                            if (i === ind) {
                                sizeButtons[i].classList.add('focus');
                                continue;
                            }
                            sizeButtons[i].classList.remove('focus');
                        }
                    }
                </script>
            </div>


            <div class="product">
                <p>Women's Running Shoe</p>
                <h1>Nike Epic React Flyknit</h1>
                <h2>$150</h2>
                <p class="desc">The Nike Epic React Flyknit foam cushioning is responsive yet light-weight, durable
                    yet soft. This creates a sensation that not only enhances the feeling of moving forward, but
                    makes running feel fun, too.</p>
                <div class="buttons">
                    <button class="add" href="" onclick="addToCart()">Add to Cart</button>
                </div>
            </div>
        </div>

        <!--        </div>-->
    </div>

<?php include_once '../footer.php' ?>