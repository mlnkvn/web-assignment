<div class="banner">
    <div id="banner-text">
        S O C K C E S S
    </div>
    <div class="blurred-background">
    <a class="blurred-link" href="category.php">
        <span class="blurred-text">Get started</span>
    </a>
    </div>
</div>


<div class="header-text">
    Recent posts:
</div>

<div class="table-container">
    <table id="data-table-recent">
        <!-- Table content will be generated dynamically here -->
    </table>
</div>


<div class="header-text">
    Category posts:
</div>

<div class="table-container">
    <table id="data-table-category">
        <!-- Table content will be generated dynamically here -->
    </table>
</div>


<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {

        fetchAndBuildTable("data-table-recent", "post_view.php");
        fetchAndBuildTable("data-table-category", "post_view.php");
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
        const row = document.createElement("tr");
        for (let i = 0; i < 8; i++) {
            const cell = document.createElement("td");
            cell.innerHTML = tableElementHTML;
            const imgElement = cell.querySelector("img");
            if (imgElement) {
                imgElement.style.maxWidth = "100%"; // Adjust this value as needed
                imgElement.style.maxHeight = "200px"; // Adjust this value as needed
            }
            cell.addEventListener('click', redirectToPage)
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    function redirectToPage() {
        window.location.href = 'category.php';
    }

</script>