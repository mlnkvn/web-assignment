<?php
if (isset($_POST['submit'])) {
    $searchQuery = $_POST['search'];

    require_once 'db.php';

    $sql = "SELECT * FROM `items` WHERE lower(itemName) LIKE ? OR lower(itemDescription) LIKE ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle any errors here
        die('SQL Error: ' . mysqli_error($con));
    }

    $searchQuery = '%' . strtolower($searchQuery) . '%';
    mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    mysqli_close($con);

    session_start();
    if (!$_SESSION['loggedIn']) {
        header("Location: ../search.php?q=" . urlencode($searchQuery));
    } else if ($_SESSION['level'] === 0) {
        header("Location: ../user/search.php?q=" . urlencode($searchQuery));
    } else {
        header("Location: ../admin/search.php?q=" . urlencode($searchQuery));
    }
    exit();
} else {
    session_start();
    if (!$_SESSION['loggedIn']) {
        header("Location: ../index.php");
    } else if ($_SESSION['level'] === 0) {
        header("Location: ../user/index.php");
    } else {
        header("Location: ../admin/index.php");
    }
//    header("Location: index.php");
    exit();
}
?>