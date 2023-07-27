<?php

function getItemsPrice($con, $id)
{
    $sql = "SELECT * FROM `items` WHERE itemId = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $fetched = mysqli_fetch_assoc($result);
    return $fetched['itemPrice'];
}

function changeCurrentOrder($con, $orderId, $totalPrice, $amountInOrder, $dif) {
    $sql = "UPDATE orders SET orderAmount = ?, orderTotal = ? WHERE orderId = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user/shopping_cartuser.php");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $amountInOrder, $totalPrice, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}


function changeItemsAmount($con, $amount, $itemId, $ordId) {
    $itemInfo = getExistingItem($con, $ordId, $itemId, 0);
    $sql = "UPDATE orderedItems SET itemsAmount = ? WHERE orderId = ? AND itemId = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user/shopping_cartuser.php");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $amount,  $ordId, $itemId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $amount - $itemInfo['itemsAmount'];
}

if ($_GET["load"] === "true") {
    $id = $_GET['id'];
    $amount = $_GET['amount'];
    require_once 'db.php';
    require_once 'functionality.php';

    session_start();
    $usId = $_SESSION['userId'];
    $curOrd = getActiveOrder($con, $usId);

    $dif = changeItemsAmount($con, $amount, $id, $curOrd['orderId']);
    $priceOfOne = getItemsPrice($con, $id);
    $total = $curOrd['orderTotal'] + $dif * $priceOfOne;
    changeCurrentOrder($con, $curOrd['orderId'], $total, $curOrd['orderAmount'] + $dif, $dif);
}
if ($_GET['last'] === "true") {
    header("location: ../user/order_submit.php");
    exit();
}
header("location: ../user/shopping_cartuser.php");
exit();