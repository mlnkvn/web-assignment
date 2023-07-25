<?php
include_once 'header_admin.php'
?>

<?php
session_start();
$myId = $_SESSION['userId'];
?>

<div>
    <table id="users-table" class="genericTable" style="border: rgba(192,94,0,0.94); margin-top: 7%;">
        <!-- Table content will be generated dynamically here -->
    </table>
</div>

<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {

        fetchAndBuildTable("users-table", "button_edit.php");
    });

    <?php
    require_once '../actions/db.php';
    $sql = "SELECT `usersId`, `usersName`, `usersEmail`, `usersUid`, `usersLevel`, `deliveryAddress` FROM `users` WHERE 1;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usersPHP = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $usersPHP[] = $it;
    }
    ?>

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
        table.style.margin = "auto";
        table.style.marginTop = "7%";
        table.style.tableLayout = "auto";
        var users = <?php echo json_encode($usersPHP); ?>;

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
        const headerTitles = ["ID", "Full Name", "Email", "Username", "Level", "Delivery Address", "Edit", "Delete"]
        const header = document.createElement("tr");
        for (let i = 0; i < headerTitles.length; ++i) {
            const cell = document.createElement("th");
            cell.innerHTML = headerTitles[i];
            header.appendChild(cell);
        }
        table.appendChild(header);
        for (let j = 0; j < users.length; j++) {
            const row = document.createElement("tr");
            for (let i = 0; i < users[j].length; i++) {
                const cell = document.createElement("td");
                cell.innerHTML = users[j][i];
                if (users[j][i] == null) {
                    cell.innerHTML = "No address was submitted"
                }
                row.appendChild(cell);
            }
            const cell1 = document.createElement("td");
            cell1.innerHTML = tableElementHTML;
            cell1.style.width = "fit-content";
            cell1.addEventListener('click', function () {
                window.location.href = "edit_user_page.php?id=" + users[j][0] + "&fullname=" + users[j][1] + "&userlevel=" + users[j][4] + "&username=" + users[j][3] + "&useremail=" + users[j][2] + "&useraddress=" + users[j][5];
            });
            row.appendChild(cell1);
            const cell2 = document.createElement("td");
            cell2.innerHTML = tableElementHTML;
            cell2.querySelector(".button-img").src = "img/cancel_icon.png";
            cell2.addEventListener('click', function () {
                alert("Are you sure you want to delete " + users[j][1] + "?");
                window.location.href = "../actions/delete_user_script.php?userId=" + users[j][0] + "&admId=" + "<?php echo $myId; ?>";
            });
            row.appendChild(cell2);
            table.appendChild(row);
        }
    }


</script>

</body>
</html>