<?php
include_once 'header.php'
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
</head>
<body>
<div class="container">
    <?php
    // Get the search query from the URL parameter
    $searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

    $tmp = htmlspecialchars($searchQuery);
    //    substr($tmp, 1, -1);
    //    str_replace("%", "", $tmp);

    // Output the search query
    echo '<h1>Search Results for: ' . substr($tmp, 1, -1) . '</h1>';

    // Connect to the database
    require_once 'actions/db.php';

    // Prepare the SQL statement
    $sql = "SELECT * FROM `items` WHERE lower(itemName) LIKE ? OR lower(itemDescription) LIKE ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle any errors here
        die('SQL Error: ' . mysqli_error($con));
    }

    // Bind the search query to the SQL statement
    $searchQuery = '%' . strtolower($searchQuery) . '%';
    mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($con);

    // Display the search results
    while ($row = mysqli_fetch_assoc($result)) {
        // Output the item details (you can customize this according to your layout)
        echo '<div class="item">';
        echo '<h2>' . htmlspecialchars($row['itemName']) . '</h2>';
        echo '<p>' . htmlspecialchars($row['itemDescription']) . '</p>';
        // Add more item details as needed
        echo '</div>';
    }
    ?>
</div>
</body>
</html>
