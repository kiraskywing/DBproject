<?php
include "authentication.php";

if (isset($_POST['page']))
    $page = $_POST['page'];
else
    $page = 1;

if (isset($_POST['shopName'])) {
    if (!isset($_SESSION['sortShopName'])) 
        $_SESSION['sortShopName'] = 1;
    else 
        $_SESSION['sortShopName'] ^= 1;
    $_SESSION['sortShopName'] ? asort($_SESSION['shopNames']) : arsort($_SESSION['shopNames']);
    $_SESSION['order'] = array_keys($_SESSION['shopNames']);
}

if (isset($_POST['shopCity'])) {
    if (!isset($_SESSION['sortShopCity'])) 
        $_SESSION['sortShopCity'] = 1;
    else 
        $_SESSION['sortShopCity'] ^= 1;
    $_SESSION['sortShopCity'] ? asort($_SESSION['shopCities']) : arsort($_SESSION['shopCities']);
    $_SESSION['order'] = array_keys($_SESSION['shopCities']);
}

if (isset($_POST['maskPrice'])) {
    if (!isset($_SESSION['sortMaskPrice'])) 
        $_SESSION['sortMaskPrice'] = 1;
    else 
        $_SESSION['sortMaskPrice'] ^= 1;
    $_SESSION['sortMaskPrice'] ? asort($_SESSION['shopMaskPrices']) : arsort($_SESSION['shopMaskPrices']);
    $_SESSION['order'] = array_keys($_SESSION['shopMaskPrices']);
}

if (isset($_POST['maskAmount'])) {
    if (!isset($_SESSION['sortMaskAmount'])) 
        $_SESSION['sortMaskAmount'] = 1;
    else 
        $_SESSION['sortMaskAmount'] ^= 1;
    $_SESSION['sortMaskAmount'] ? asort($_SESSION['shopStockQuantities']) : arsort($_SESSION['shopStockQuantities']);
    $_SESSION['order'] = array_keys($_SESSION['shopStockQuantities']);
}

if (isset($_POST['shopPhone'])) {
    if (!isset($_SESSION['sortShopPhone'])) 
        $_SESSION['sortShopPhone'] = 1;
    else 
        $_SESSION['sortShopPhone'] ^= 1;
    $_SESSION['sortShopPhone'] ? asort($_SESSION['shopPhones']) : arsort($_SESSION['shopPhones']);
    $_SESSION['order'] = array_keys($_SESSION['shopPhones']);
}

header("Location: searchShop.php?page=" . $page);
exit();
?>