<?php 
    include "authentication.php";
    include "parameters.php";
    include "resetSearchSessions.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="For demo">
        <meta name="author" content="Jeff">
        <meta name="generator" content="Jeff">
        <title>Online Mask Shop</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
        <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
        <meta name="theme-color" content="#7952b3">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
            .form-signin {
                width: 100%;
                padding: 15px;
                margin: auto;
                margin-top: 15vh;
            }
            .login-button {
                margin-top: 15px;
                width: 100%;
            }
            .profile {
                width: 60%;
                margin-left: 20%;
                margin-bottom: 30px;
            }
            .shop-list {
                width: 340px;
                margin-left: calc(50% - 170px);
            }
            .select-label {
                position: absolute;
                top: 10px;
                left: 12px;
                font-size: 12px;
                color: #212529;
                opacity: 0.65;
            }
            .form-floating {
                position: relative;
            }
            .place-right {
                position: absolute;
                left: 350px;
                bottom: 15px;
                color: red;
                display: none;
                width: 400px;
            }
            .show {
                display: block;
            }
        </style>
        <script src="utils.js"></script> 
        <script>
            const inputStatusForSearch = {
                MIN_MASK_PRICE: true,
                MAX_MASK_PRICE: true,
            };
            function confirmSearchEnable () {
                const { MIN_MASK_PRICE, MAX_MASK_PRICE } = inputStatusForSearch;
                return (MIN_MASK_PRICE && MAX_MASK_PRICE);
            }
            
            function disableSubmitButton() {
                document.getElementById('search-button').disabled = true;
            }
            function enableSubmitButton() {
                document.getElementById('search-button').disabled = false;
            }
            function showNotice(idName) {
                document.getElementById(idName).classList.add('show');
            }
            function hideNotice(idName) {
                document.getElementById(idName).classList.remove('show');
            }
            function confirmMinInput(element, inputStatusKey) {
                if (element.value && !isNonNegativeInteger(element.value)) {
                    inputStatusForSearch[inputStatusKey] = false;
                    document.getElementById('min-price-notice').innerHTML = 'Price must be non-negative integer!';
                    showNotice('min-price-notice');
                    disableSubmitButton();
                    return;
                } else {
                    inputStatusForSearch[inputStatusKey] = true;
                    hideNotice('min-price-notice');
                    if (confirmSearchEnable()) enableSubmitButton();
                }
                if (!Boolean(document.getElementById('max_price').value)) return;
                if (element.value && (element.value > document.getElementById('max_price').value)) {
                    inputStatusForSearch[inputStatusKey] = false;
                    document.getElementById('min-price-notice').innerHTML = 'Minimum Price must be smaller than Maximum Price!';
                    showNotice('min-price-notice');
                    disableSubmitButton();
                } else {
                    inputStatusForSearch['MAX_MASK_PRICE'] = (document.getElementById('max_price').value >= 0 ? true : false);
                    inputStatusForSearch['MIN_MASK_PRICE'] = (element.value >= 0 ? true : false);
                    if (element.value >= 0) hideNotice('min-price-notice');
                    if (document.getElementById('max_price').value >= 0 ) hideNotice('max-price-notice');
                    if (confirmSearchEnable()) enableSubmitButton();
                }
            }
            function confirmMaxInput(element, inputStatusKey) {
                if (element.value && !isNonNegativeInteger(element.value)) {
                    inputStatusForSearch[inputStatusKey] = false;
                    document.getElementById('max-price-notice').innerHTML = 'Price must be non-negative integer!';
                    showNotice('max-price-notice');
                    disableSubmitButton();
                    return;
                } else {
                    inputStatusForSearch[inputStatusKey] = true;
                    hideNotice('max-price-notice');
                    if (confirmSearchEnable()) enableSubmitButton();
                }
                if (!Boolean(document.getElementById('min_price').value)) return;
                if (element.value && (element.value < document.getElementById('min_price').value)) {
                    inputStatusForSearch[inputStatusKey] = false;
                    document.getElementById('max-price-notice').innerHTML = 'Maximum Price must be greater than Minimum Price!';
                    showNotice('max-price-notice');
                    disableSubmitButton();
                } else {
                    inputStatusForSearch['MAX_MASK_PRICE'] = (element.value >= 0 ? true : false);
                    inputStatusForSearch['MIN_MASK_PRICE'] = (document.getElementById('min_price').value >= 0 ? true : false);
                    if (document.getElementById('min_price').value >= 0 ) hideNotice('min-price-notice');
                    if (element.value >= 0) hideNotice('max-price-notice');
                    if (confirmSearchEnable()) enableSubmitButton();
                }
            }
        </script>
    </head>
    <body class="text-center">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="shop-tab" data-bs-toggle="tab" type="button" 
                        onClick="window.location.replace('shop.php');">Shop
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="my-order-tab" data-bs-toggle="tab" type="button" 
                        onClick="window.location.replace('myOrder.php');">My Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="shop-order-tab" data-bs-toggle="tab" type="button" 
                        onClick="window.location.replace('shopOrder.php');">Shop Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="logout-tab" data-bs-toggle="tab" type="button" 
                        onClick="alert('Logout Success!'); window.location.replace('index.php');">Logout
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <main class="form-signin">
                    <div class="card profile">
                        <h2 style="border-bottom: 1px solid gray">Profile</h2>
                        <table style="width: 100%" class="table">
                            <thead>
                                <tr>
                                <th scope="col">Account</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">City of Residence</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-info">
                                    <?php
                                        echo "<th scope='row'>" . $_SESSION['account'] . "</th>" .
                                            "<td>" . $_SESSION['full_name'] . "</td>" .
                                            "<td>" . $_SESSION['phone_number'] . "</td>" .
                                            "<td>" . $_SESSION['city'] . "</td>";
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="shop-list">
                        <h2>Shop List</h2>
                        <form action="searchShop.php" method="post">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="please input shop">
                                <label for="account">Keyword of Shop Name</label>
                            </div>
                            <div class="form-floating">
                                <div class="select-label">Shop Location</div>
                                <select class="form-select" name="shop_city">
                                    <option value="">All</option>
                                    <?php
                                        foreach ($cities as $city)
                                            echo '<option value="' . $city . '">' . $city . '</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="form-floating">
                                <input oninput="confirmMinInput(this, 'MIN_MASK_PRICE')" min="0" type="number" class="form-control" name="min_price" id="min_price" placeholder="please input min of price">
                                <label for="min_price">Minimum Mask Price</label>
                                <div id="min-price-notice" class="place-right"></div>
                            </div>
                            <div class="form-floating">
                                <input oninput="confirmMaxInput(this, 'MAX_MASK_PRICE')" min="0" type="number" class="form-control" name="max_price" id="max_price" placeholder="please input max of price">
                                <label for="max_price">Maximum Mask Price</label>
                                <div id="max-price-notice" class="place-right"></div>
                            </div>
                            <div class="form-floating">
                                <div class="select-label">Amount</div>
                                <select class="form-select" name="amount">
                                    <option value="-1">All</option>
                                    <?php
                                        for ($i = 0; $i < count($amount); $i++)
                                            echo '<option value="' . $i . '">' . $amount[$i] . '</option>';
                                    ?>
                                </select>
                            </div>
                            <div style="padding: 10px" class="form-switch">
                                <input class="form-check-input" type="checkbox" value="1" name="isShopStaff" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Only show the shop I work at</label>
                            </div>
                            <button id="search-button" class="login-button btn btn-lg btn-success" type="submit">Search</button>
                        </form>
                    </div>
                </main>
            </div>
        <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW3 demo</p>
        </div>
    </body>
</html>
