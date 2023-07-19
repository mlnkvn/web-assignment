<?php
include_once 'header_user.php'
    ?>

<!-- <div class="item-container"> -->
<table id="item-table-user" class="genericTable">
        <!-- Table content will be generated dynamically here -->
    </table>
<!-- </div> -->

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
            for (let i = 0; i < 4; i++) {
                const cell = document.createElement("td");
                cell.innerHTML = tableElementHTML;
                const imgElement = cell.querySelector("img");
                if (imgElement) {
                    imgElement.style.maxWidth = "100%"; // Adjust this value as needed
                    imgElement.style.maxHeight = "200px"; // Adjust this value as needed
                }
                row.appendChild(cell);
            }
            table.appendChild(row);
        }
    }


</script>


<?php include_once '../footer.php' ?>