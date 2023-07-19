<?php
//function getItemsWith($con, $cat, $pageBack) {
    $con = 'con';
    $cat = 'cat';
    $pageBack = 'pageBack';
    $sql = "SELECT * FROM `items` WHERE 1;";
    if ($cat !== "all") {
        $sql = "SELECT * FROM `items` WHERE itemCategory=?;";
    }
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($pageBack);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $cat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysql_fetch_assoc($result)){
//        foreach($row as $key => $val){
//            echo $key . ": " . $val . "<BR />";
//        }
    }
    header($pageBack);
    exit();
//}
?>