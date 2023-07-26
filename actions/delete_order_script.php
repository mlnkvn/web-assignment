<?php
session_start();
if ($_GET['admId'] == $_SESSION['userId']) {
    session_start();
    require_once 'functionality.php';
    deleteOrder($_GET['orderId'], "../admin/ordersadmin.php");
    header("location: ../admin/ordersadmin.php?error=none");
    exit();
} else {
    header("location: ../admin/ordersadmin.php");
    exit();
}
