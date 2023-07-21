<?php

if (isset($_POST["submit"])) {
    if (isset($_GET['cat'])) {
        $cats = explode("_", $_GET['cat']);
        $category = $cats[0];
        $subcategory = $cats[1];
        $id = explode("_", $cats[2])[0];
    }
    require_once 'db.php';
    require_once 'functionality.php';

    $item = getItemWithId($con, $id);
    addToCart($con, $item, 0);

    header("location: ../user/categoryuser.php?cat=" . $_GET['cat']);
    exit();
} else {
    header("location: ../user/categoryuser.php?cat=" . $_GET['cat']);
    exit();
}