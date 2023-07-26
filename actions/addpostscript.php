<?php

function addPost($con, $title, $picLink, $text, $date, $category)
{
    $sql = "INSERT INTO `posts`(`postCategory`, `postTitle`, `postPicLink`, `postText`, `postDate`) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/add_post.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $category, $title, $picLink, $text, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../admin/add_post.php?error=none");
    exit();
}

if (isset($_POST["add-post-submit"])) {
    $title = $_POST["postTitle"];
    $picLink = $_POST["postPicLink"];
    $text = $_POST["postText"];
    $date = $_POST["postDate"];
    $category = $_POST["postCategory"];

    require_once 'db.php';
    require_once 'functionality.php';

    addPost($con, $title, $picLink, $text, $date, $category);
} else {
    header("location: ../admin/add_post.php");
    exit();
}
?>