<?php 
    if (isset($_SESSION['shop_name'])) unset($_SESSION['shop_name']);
    if (isset($_SESSION['shop_city'])) unset($_SESSION['shop_city']);
    if (isset($_SESSION['min_price'])) unset($_SESSION['min_price']);
    if (isset($_SESSION['max_price'])) unset($_SESSION['max_price']);
    if (isset($_SESSION['amount'])) unset($_SESSION['amount']);
    if (isset($_SESSION['isShopStaff'])) unset($_SESSION['isShopStaff']);
    if (isset($_SESSION['sortBy'])) unset($_SESSION['sortBy']);
    
    if (isset($_SESSION['sortShopName'])) unset($_SESSION['sortShopName']);
    if (isset($_SESSION['sortShopCity'])) unset($_SESSION['sortShopCity']);
    if (isset($_SESSION['sortMaskPrice'])) unset($_SESSION['sortMaskPrice']);
    if (isset($_SESSION['sortMaskAmount'])) unset($_SESSION['sortMaskAmount']);
    if (isset($_SESSION['sortShopPhone'])) unset($_SESSION['sortShopPhone']);
?>