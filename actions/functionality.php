<?php

function hasEmptyInputs($username, $email, $user_id, $password)
{
    $res;
    if (empty($username) or empty($email) or empty($user_id) or empty($password)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function hasEmptyInputsLogin($username, $password)
{
    $res;
    if (empty($username) or empty($password)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function invalidUsername($user_id)
{
    $res;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user_id)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function invalidEmail($email)
{
    $res;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}

function existingUsername($con, $user_id, $email)
{
    $sql = "SELECT * FROM `users` WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user_id, $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($con, $username, $email, $user_id, $password)
{
    $sql = "INSERT INTO `users`(usersName, usersEmail, usersUid, usersPwd, usersLevel) VALUES (?, ?, ?, ?, 0);";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $user_id, $hashed_pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?error=none");
    exit();
}

function existingUsernameLogin($con, $user_id)
{
    $sql = "SELECT * FROM `users` WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        $result = false;
        return $result;
    }
}

function loginUser($con, $username, $password)
{
    $getUser = existingUsernameLogin($con, $username);
    if ($getUser === false) {
        header("location: ../login.php?error=unknownusername");
        exit();
    }
    $rightPassword = $getUser["usersPwd"];
    $validatePwd = password_verify($password, $rightPassword);

    if ($validatePwd === false) {
        header("location: ../login.php?error=wrongpassword");
        exit();
    } else if ($validatePwd === true) {
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["userFullName"] = $getUser["usersName"];
        $_SESSION["userId"] = $getUser["usersId"];
        $_SESSION["username"] = $getUser["usersUid"];
        $_SESSION["useremail"] = $getUser["usersEmail"];
        $_SESSION["userAddress"] = $getUser["deliveryAddress"];
        $_SESSION["level"] = $getUser["usersLevel"];
        $_SESSION["orderingStatus"] = false;
        if ($_SESSION["level"] == 0) {
            header("location: ../user/indexuser.php");
        } else {
            header("location: ../admin/indexadmin.php");
        }
        exit();
    }
}

function updateUserWithPwd($con, $userId, $userFullName, $username, $userEmail, $address, $newPwd, $userLevel)
{
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, usersPwd=?, deliveryAddress=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    session_start();
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if ($userLevel == 0) {
            header("location: ../user/edituser.php?error=stmtfailed");
        } else {
            header("location: ../admin/settingsadmin.php?error=stmtfailed");
        }
        exit();
    }
    $hashed_pwd = password_hash($newPwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss", $userFullName, $userEmail, $username, $hashed_pwd, $address, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userFullName"] = $userFullName;
    $_SESSION["username"] = $username;
    $_SESSION["useremail"] = $userEmail;
    $_SESSION["userAddress"] = $address;
    if ($userLevel == 0) {
        header("location: ../user/edituser.php?error=none");
    } else {
        header("location: ../admin/settingsadmin.php?error=none");
    }
    exit();
}

function updateUserWithoutPwd($con, $userId, $userFullName, $username, $userEmail, $address, $userLevel)
{
    $sql = "UPDATE users SET usersName=?,usersEmail=?,usersUid=?, deliveryAddress=? WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if ($userLevel == 0) {
            header("location: ../user/edituser.php?error=stmtfailed");
        } else {
            header("location: ../admin/settingsadmin.php?error=stmtfailed");
        }
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $userFullName, $userEmail, $username, $address, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    $_SESSION['userFullName'] = $userFullName;
    $_SESSION['username'] = $username;
    $_SESSION['useremail'] = $userEmail;
    $_SESSION['userAddress'] = $address;
    if ($userLevel == 0) {
        header("location: ../user/edituser.php?error=none");
    } else {
        header("location: ../admin/settingsadmin.php?error=none");
    }
    exit();
}

function getItemsWith($con, $cat, $subcat)
{
    if ($cat === "all") {
        $sql = "SELECT * FROM `items` WHERE 1;";
    } else if ($subcat === "all") {
        $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
    } else {
        $sql = "SELECT * FROM `items` WHERE itemCategory=? AND itemSubCategory=?;";
    }
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    if ($cat === "all") {
        //
    } else if ($subcat === "all") {
        mysqli_stmt_bind_param($stmt, "s", $cat);
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $cat, $subcat);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $arr[] = $it;
    }
    return $arr;
}

function getItemWithId($con, $id)
{
    $sql = "SELECT * FROM `items` WHERE itemId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    $arr = array();
    foreach ($row as $key => $val) {
        $arr[] = $val;
    }
    return $arr;
}

// create empty order for user with usId
function createOrder($con, $usId)
{
    $sql = "INSERT INTO `orders` (userId, orderAmount, orderTotal, orderStatus) VALUES (?, 0, 0, 0);";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $usId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["orderingStatus"] = true;
    return true;
}

//get active order for user with usId
function getActiveOrder($con, $usId)
{
    $sql = "SELECT * FROM `orders` WHERE userId = ? AND orderStatus = 0;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $usId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

// row with ordered item if is added in this order with ordId, false if isn't order
function getExistingItem($con, $ordId, $idIt, $pickedSize)
{
    $sql = "SELECT * FROM `orderedItems` WHERE itemId = ? AND orderId = ? AND itemSize = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $idIt, $ordId, $pickedSize);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function increaseOrderAmount($con, $curOrder, $price)
{
    $id = $curOrder['orderId'];
    $amount = $curOrder['orderAmount'] + 1;
    $total = $curOrder['orderTotal'] + $price;
    $sql = "UPDATE orders SET orderAmount = ?, orderTotal = ? WHERE orderId = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $amount, $total, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

// adds item with itId to order with ordId
function addToOrder($con, $item, $pickedSize, $curOrder)
{
    $itId = $item[0];
    $_SESSION["orderId"] = $curOrder['orderId'];
    $existItem = getExistingItem($con, $curOrder['orderId'], $itId, $pickedSize);
    if ($existItem === false) {
        $sql = "INSERT INTO orderedItems (itemId, itemsAmount, orderId, itemSize) VALUES (?, 1, ?, ?);";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sss", $itId, $_SESSION["orderId"], $pickedSize);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $id = $existItem['lineId'];
        $amount = $existItem['itemsAmount'] + 1;
        $sql = "UPDATE orderedItems SET itemsAmount = ? WHERE lineId = ?;";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $amount, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    increaseOrderAmount($con, $curOrder, $item[4]);
    return true;

}

function addToCart($con, $it, $pickedSz)
{
    session_start();
    $curOrd = getActiveOrder($con, $_SESSION["userId"]);
    if ($curOrd === false) {
        createOrder($con, $_SESSION["userId"]);
    } else {
        $_SESSION["orderingStatus"] = true;
    }
    addToOrder($con, $it, $pickedSz, $curOrd);
    return true;
}

// gets item info for shopping cart
function getItemInfo($con, $itemId)
{
    $sql = "SELECT * FROM `items` WHERE itemId = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $itemId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getItemsFromOrder($con, $orderId)
{
    $sql = "SELECT * FROM `orderedItems` WHERE orderId = ?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $orderId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $itId = $it[1];
        $itInfo = getItemInfo($con, $itId);
        // [itemId, itemsAmount, itemSize, itemName, itemAmount * itemPrice, picLink]
        $itemInfoFull = array($itId, $it[2], $it[4], $itInfo['itemName'], $it[2] * $itInfo['itemPrice'], $itInfo['picLink']);
        $arr[] = $itemInfoFull;
    }
    return $arr;
}

function cmpPosts($a, $b)
{
    if ($a[5] == $b[5]) {
        return 0;
    }
    return ($a[5] > $b[5]) ? -1 : 1;
}

function getRecentPosts($con) {
    $sql = "SELECT * FROM `posts` WHERE postCategory is NULL;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $arr[] = $it;
    }
    usort($arr, "cmpPosts");
    return $arr;
}


function getCategoryPosts($con) {
    $sql = "SELECT * FROM `posts` WHERE postCategory is not NULL;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $it = array();
        foreach ($row as $key => $val) {
            $it[] = $val;
        }
        $arr[] = $it;
    }
//    usort($arr, "cmpPosts");
    return $arr;
}

function deleteUser($userId, $prevLocation) {
    require_once 'db.php';
    $sql = "DELETE FROM `users` WHERE usersId=?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ".$prevLocation."?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>