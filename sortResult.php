<?php
include "authentication.php";

if ($_POST['shopName']) {
    if (!isset($_SESSION['sortShopName'])) 
        $_SESSION['sortShopName'] = 1;
    else 
        $_SESSION['sortShopName'] ^= 1;

    if ($_SESSION['sortShopName']) {
        asort($_SESSION['shopNames']);
    }
    else {
        arsort($_SESSION['shopNames']);
    }
    $_SESSION['order'] = array_keys($_SESSION['shopNames']);
}

header("Location: searchShop.php");
exit();
?>