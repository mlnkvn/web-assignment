<?php

if (isset($_POST["submit"])) {
    if (isset($_GET['cat'])) {
        $cats = explode("_", $_GET['cat']);
        $category = $cats[0];
        $subcategory = $cats[1];
        $id = $cats[2];
    }
    require_once 'db.php';
    require_once 'functionality.php';

    $item = getItemWithId($con, $id);

    addToCart($con, $item, 0);
    $parts = explode('_', $_GET['cat']);
    if (isset($_GET['q'])) {
        header("location: ../user/search.php?q=" . $_GET['q']);
    } else {
        header("location: ../user/categoryuser.php?cat=" . $parts[0] . '_' . $parts[1]);
    }
    exit();
} else {
    if (isset($_GET['q'])) {
        header("location: ../user/search.php?q=" . $_GET['q']);
    } else {
        header("location: ../user/categoryuser.php?cat=" . $_GET['cat']);
    }
    exit();
}