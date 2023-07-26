<?php
include_once 'header_admin.php'
    ?>

<?php
function getItemsWith($cat, $subcat)
{
    require '../actions/db.php';
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

function delete_item($id)
{
    // echo "function called";
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
    // $result = mysqli_stmt_get_result($stmt);
    // echo $result;
    return "success"; //"Item with ID " . $id . " deleted successfully!";
}

?>


<div style="width: 100%; margin-top: 7%">
    <div class="side-nav-categories" style="width: 20%; float: left;">
        <div class="title"><strong>Category</strong></div>
        <ul id="category-tabs">
            <li><a href="categoryadmin.php?cat=all_all">All products</a></li>
        </ul>
        <ul id="category-tabs">
            <li><a href="categoryadmin.php?cat=socks_all" class="main-category">Socks</a>
                <ul class="sub-category-tabs">
                    <li><a href="categoryadmin.php?cat=socks_all" onclick="updCatsAll()">All socks</a></li>
                    <li><a href="categoryadmin.php?cat=socks_basic" onclick="updCatsBasic()">Basic</a></li>
                    <li><a href="categoryadmin.php?cat=socks_pattern">With patterns</a></li>
                    <li><a href="categoryadmin.php?cat=socks_memes">With memes</a></li>
                </ul>
            </li>
        </ul>
        <ul id="category-tabs">
            <li><a href="categoryadmin.php?cat=headwear_all" class="main-category">Head wear</a>
            </li>
        </ul>
        <ul id="category-tabs">
            <li><a href="categoryadmin.php?cat=card_all">Gift cards</a></li>
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
        $subcategory = explode("_", $cats[1])[0];
    } else {
        $category = "all";
        $subcategory = "all";
    }
    $itemsPHP = getItemsWith($category, $subcategory);

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
        console.log("BUILD CALLED");
        const table = document.getElementById(tableId);
        table.innerHTML = '';
        var items = <?php echo json_encode($itemsPHP); ?>;

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

    // function executePHPFunction(functionName, arguments) {
    //     var xhr = new XMLHttpRequest();
    //     var url = '?action=execute&function=' + functionName + '&arguments=' + JSON.stringify(arguments);
    //     xhr.open('GET', url, true);
    //     console.log(arguments)
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //             var result = xhr.responseText;
    //             // console.log(result); // Display the result in the console or update the page as needed
    //         }
    //     };
    //     xhr.send();
    // }



</script>

</body>

</html>