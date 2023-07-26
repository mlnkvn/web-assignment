<?php
function updateOrder($con, $orderId, $status, $address)
{
    $sql = "UPDATE orders SET orderStatus=?, orderDestination=? WHERE orderId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/edit_order_page.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $status, $address, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    header("location: ../admin/ordersadmin.php?error=none");
    exit();
}

if (isset($_POST["edit-order-submit"])) {
    session_start();
    $orderId = $_POST['orderId'];
    $status = $_POST["status-order"];
    $address = $_POST['inputAddress'];
    require_once 'db.php';
    require_once 'functionality.php';

    if ($address === "There is no delivery address associated with you") {
        $address = null;
    }
    updateOrder($con, $orderId, $status, $address);
} else {
    header("location: ../admin/edit_order_page.php");
    exit();
}
?>