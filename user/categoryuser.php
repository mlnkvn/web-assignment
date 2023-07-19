<?php
include_once 'header_user.php'
?>
<?php
require_once '../actions/db.php';
function getItemsWith($cat, $pageBack)
{
    $sql = "SELECT * FROM `items` WHERE 1;";
    if ($cat !== "all") {
        $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
    }
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($pageBack);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $cat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysql_fetch_assoc($result)) {
        foreach($row as $key => $val){
            echo $key . ": " . $val . "<BR />";
        }
    }
//    die("bruh");
//    header($pageBack);
//    exit();
//    $rows = mysql_fetch_assoc($result);
//    return $rows;
}
?>

    <!--Side navigation bar-->
    <div style="width: 100%; margin-top: 7%">
        <div class="side-nav-categories" style="width: 20%; float: left;">
            <div class="title"><strong>Category</strong></div>
            <ul id="category-tabs">
                <li><a href="javascript:void" class="main-category">Socks</a>
                    <ul class="sub-category-tabs">
                        <li><a href="javascript:void">All socks</a></li>
                        <li><a href="javascript:void">Basic</a></li>
                        <li><a href="javascript:void">Multicolored</a></li>
                        <li><a href="javascript:void">With memes</a></li>
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

        <script>
            $('#category-tabs li a').click(function () {
                $(this).next('ul').slideToggle('500');
                $(this).find('i').toggleClass('fa-minus fa-plus')
            });
        </script>

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
            
            // Create table row and insert fetched HTML content into a single cell
            for (let j = 0; j < 4; j++) {
                const row = document.createElement("tr");
                for (let i = 0; i < 3; i++) {
                    const cell = document.createElement("td");
                    cell.innerHTML = tableElementHTML;
                    const imgElement = cell.querySelector('.item-container-class');
                    if (imgElement) {
                        imgElement.style.background = "black url('../img/socks-kitty.png')";
                        imgElement.style.backgroundSize = "contain";
                        // imgElement.style.width = "100%"; // Adjust this value as needed
                        // imgElement.style.maxHeight = "200px"; // Adjust this value as needed
                    }
                    row.appendChild(cell);
                }
                table.appendChild(row);
            }
        }


    </script>


<?php include_once '../footer.php' ?>