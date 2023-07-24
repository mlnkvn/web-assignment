<div class="banner">
    <div id="banner-text">
        S O C K C E S S
    </div>
    <div class="blurred-background">
    <a class="blurred-link" href="categoryuser.php?cat=all_all">
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
        <?php
        require_once '../actions/db.php';
        require_once '../actions/functionality.php';
        $recentPosts = getRecentPosts($con);
        $categoryPosts = getCategoryPosts($con);
        ?>
        const recent_posts = <?php echo json_encode($recentPosts) ?>;
        const category_posts = <?php echo json_encode($categoryPosts) ?>;
        fetchAndBuildTable("data-table-recent", "../post_view.php", recent_posts);
        fetchAndBuildTable("data-table-category", "../post_view.php", category_posts);
    });

    function fetchAndBuildTable(tableId, phpFileName, posts) {
        // Use AJAX to fetch table element HTML from PHP file
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                const tableElementHTML = this.responseText;
                buildTable(tableElementHTML, tableId, posts);
            }
        };

        xhttp.open("GET", phpFileName, true);
        xhttp.send();
    }

    function buildTable(tableElementHTML, tableId, posts) {
        const table = document.getElementById(tableId);

        // Create table row and insert fetched HTML content into a single cell
        const row = document.createElement("tr");
        for (let i = 0; i < posts.length; i++) {
            const cell = document.createElement("td");
            cell.innerHTML = tableElementHTML;
            const imgElement = cell.querySelector("img");
            if (imgElement) {
                imgElement.style.maxWidth = "100%"; // Adjust this value as needed
                imgElement.style.maxHeight = "200px"; // Adjust this value as needed
                imgElement.src = "../img/" + posts[i][3];
                imgElement.style.display = "contains";
            }
            const category = cell.querySelector("#cat-post");
            if (category) {
                category.innerHTML = posts[i][1];
            }
            const title = cell.querySelector("#title-post");
            if (title) {
                title.innerHTML = posts[i][2];
            }
            const text = cell.querySelector("#text-post");
            if (text) {
                text.innerHTML = posts[i][4];
            }
            cell.addEventListener('click', redirectToPage)
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    function redirectToPage() {
        window.location.href = 'categoryuser.php';
    }

</script>