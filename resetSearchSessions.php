<?php 
    if (isset($_SESSION['shopIds'])) unset($_SESSION['shopIds']);
    if (isset($_SESSION['shopNames'])) unset($_SESSION['shopNames']);
    if (isset($_SESSION['shopCities'])) unset($_SESSION['shopCities']);
    if (isset($_SESSION['shopMaskPrices'])) unset($_SESSION['shopMaskPrices']);
    if (isset($_SESSION['shopStockQuantities'])) unset($_SESSION['shopStockQuantities']);
    if (isset($_SESSION['shopPhones'])) unset($_SESSION['shopPhones']); 
    if (isset($_SESSION['order'])) unset($_SESSION['order']);
    if (isset($_SESSION['sortShopName'])) unset($_SESSION['sortShopName']);
    if (isset($_SESSION['sortShopCity'])) unset($_SESSION['sortShopCity']);
    if (isset($_SESSION['sortMaskPrice'])) unset($_SESSION['sortMaskPrice']);
    if (isset($_SESSION['sortMaskAmount'])) unset($_SESSION['sortMaskAmount']);
    if (isset($_SESSION['sortShopPhone'])) unset($_SESSION['sortShopPhone']);
?>