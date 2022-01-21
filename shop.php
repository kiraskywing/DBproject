<?php 
    include "authentication.php";
    include "parameters.php";
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
            const inputStates = {
                SHOP_NAME: false,
                SHOP_PHONE_NUMBER: false,
                MASK_PRICE: false,
                MASK_AMOUNT: false,
            };
            function confirmAllStateEnable () {
                const { SHOP_NAME, SHOP_PHONE_NUMBER, MASK_PRICE, MASK_AMOUNT } = inputStates;
                return (SHOP_NAME && SHOP_PHONE_NUMBER && MASK_PRICE && MASK_AMOUNT);
            }
            function disableRegisterButton() {
                document.getElementById('register-button').disabled = true;
            }
            function enabledRegisterButton() {
                document.getElementById('register-button').disabled = false;
            }
            function disableEditPriceButton() {
                document.getElementById('edit-mask-price').disabled = true;
            }
            function enabledEditPriceButton() {
                document.getElementById('edit-mask-price').disabled = false;
            }
            function disableEditAmountButton() {
                document.getElementById('edit-mask-amount').disabled = true;
            }
            function enabledEditAmountButton() {
                document.getElementById('edit-mask-amount').disabled = false;
            }
            function showNotice(idName) {
                document.getElementById(idName).classList.add('show');
            }
            function hideNotice(idName) {
                document.getElementById(idName).classList.remove('show');
            }
            function handleEditMaskPrice(element) {
                if (element.value.length === 0) {
                    document.getElementById('edit-mask-price-notice').innerHTML = 'Input Required!';
                    showNotice('edit-mask-price-notice');
                    disableEditPriceButton();
                    return;
                }
                if (isNonNegativeInteger(element.value)) {
                    hideNotice('edit-mask-price-notice');
                    enabledEditPriceButton();
                } else {
                    document.getElementById('edit-mask-price-notice').innerHTML = 'Mask price must be non-negative integer';
                    showNotice('edit-mask-price-notice');
                    disableEditPriceButton();
                }
            }
            function handleEditMaskAmount(element) {
                if (element.value.length === 0) {
                    document.getElementById('edit-mask-amount-notice').innerHTML = 'Input Required!';
                    showNotice('edit-mask-amount-notice');
                    disableEditAmountButton();
                    return;
                }
                if (isNonNegativeInteger(element.value)) {
                    hideNotice('edit-mask-amount-notice');
                    enabledEditAmountButton();
                } else {
                    document.getElementById('edit-mask-amount-notice').innerHTML = 'Mask Amount must be non-negative integer';
                    showNotice('edit-mask-amount-notice');
                    disableEditAmountButton();
                }
            }
            function handleChangeMaskPrice(element) {
                if (element.value.length === 0) {
                    document.getElementById('mask-price-notice').innerHTML = 'Input Required!';
                    showNotice('mask-price-notice');
                    inputStates.MASK_PRICE = false;
                    disableRegisterButton();
                    return;
                }
                if (isNonNegativeInteger(element.value)) {
                    hideNotice('mask-price-notice');
                    inputStates.MASK_PRICE = true;
                    enabledRegisterButton();
                } else {
                    document.getElementById('mask-price-notice').innerHTML = 'Mask price must be non-negative integer';
                    showNotice('mask-price-notice');
                    inputStates.MASK_PRICE = false;
                    disableRegisterButton();
                }
            }
            function handleChangeMaskAmount(element) {
                if (element.value.length === 0) {
                    document.getElementById('mask-amount-notice').innerHTML = 'Input Required!';
                    showNotice('mask-amount-notice');
                    inputStates.MASK_AMOUNT = false;
                    disableRegisterButton();
                    return;
                }
                if (isNonNegativeInteger(element.value)) {
                    hideNotice('mask-amount-notice');
                    inputStates.MASK_AMOUNT = true;
                    enabledRegisterButton();
                } else {
                    document.getElementById('mask-amount-notice').innerHTML = 'Mask Amount must be non-negative integer';
                    showNotice('mask-amount-notice');
                    inputStates.MASK_AMOUNT = false;
                    disableRegisterButton();
                }
            }
            function handleChangeShopsPhoneNumber(element) {
                if (element.value.length === 0) {
                    document.getElementById('shops-phone-number-notice').innerHTML = 'Input Required!';
                    showNotice('shops-phone-number-notice');
                    inputStates.SHOP_PHONE_NUMBER = false;
                    disableRegisterButton();
                    return;
                }
                if (isCellPhoneNumber(element.value)) {
                    hideNotice('shops-phone-number-notice');
                    inputStates.SHOP_PHONE_NUMBER = true;
                    enabledRegisterButton();
                } else {
                    document.getElementById('shops-phone-number-notice').innerHTML = 'You must fill in exactly 10 digits!';
                    showNotice('shops-phone-number-notice');
                    inputStates.SHOP_PHONE_NUMBER = false;
                    disableRegisterButton();
                }
            }
            function checkShopIsRegistered(value) {
                if (value && !isWhiteSpaceOnly(value)) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        var message;
                        if (this.readyState == 4 && this.status == 200) {
                            switch(this.responseText) { 
                                case 'YES':
                                    message = '<div style="color:green">This shop name is available.</div>';
                                    inputStates.SHOP_NAME = true;
                                    enabledRegisterButton();
                                    break; 
                                case 'NO':
                                    message = 'This shop name has been registered!';
                                    inputStates.SHOP_NAME = false;
                                    disableRegisterButton();
                                    break;
                                default:
                                    message = 'Oops. There is something wrong.';
                                    inputStates.SHOP_NAME = false;
                                    disableRegisterButton();
                                    break; 
                            }
                            document.getElementById("shop-name-notice").innerHTML = message;
                            showNotice('shop-name-notice');
                        }
                    };
                    xhttp.open("POST", "registerShop.php", true); 
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
                    xhttp.send("checkShop="+value);
                } else {
                    inputStates.SHOP_NAME = false;
                    document.getElementById("shop-name-notice").innerHTML = 'Input required!';
                    showNotice('shop-name-notice');
                    disableRegisterButton();
                }
            }
        </script>
    </head>
    <body class="text-center">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="user-tab" data-bs-toggle="tab" type="button" 
                        onClick="window.location.replace('userPage.php');">Home
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Shop</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="order-tab" data-bs-toggle="tab" type="button" 
                        onClick="window.location.replace('myOrder.php');">My Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="order-tab" data-bs-toggle="tab" type="button" 
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
                
                <?php 
                    try {
                        global $connection;
                        $query = $connection->prepare('select * from shop_staffs where isMaster = true and staff_id = ' . $_SESSION['user_id']);
                        $query->execute();
                        
                        if ($query->rowCount() == 0) {
                ?>
                            <main class="form-signin">
                            <div class="shop-list">
                            <form action="registerShop.php" method="post">
                                <img src="./login.png" alt="" height="120" width="108">
                                <h1 class="h3 mb-3 fw-normal">Register Shop</h1>
        
                                <div class="form-floating">
                                    <input required oninput="checkShopIsRegistered(this.value)" type="text" class="form-control" name="shop_name" id="shop_name" placeholder=" ">
                                    <label for="shop_name">Shop Name</label>
                                    <div id="shop-name-notice" class="place-right"></div>
                                </div>

                                <div class="form-floating">
                                    <div class="select-label">City of Shop Location</div>
                                    <select class="form-select" name="shop_city">
                                        
                <?php
                            foreach ($cities as $city)
                                echo   "<option value=\"" . $city . "\">" . $city . "</option>";
                ?>
                           
                                    </select>
                                </div>
                           
                                <div class="form-floating">
                                    <input required min="0" oninput="handleChangeMaskPrice(this)" type="number" class="form-control" name="pre_mask_price" id="pre_mask_price" placeholder=" ">
                                    <label for="pre_mask_price">Mask Price</label>
                                    <div id="mask-price-notice" class="place-right"></div>
                                </div>
                            
                                <div class="form-floating">
                                    <input required min="0" oninput="handleChangeMaskAmount(this)" type="number" class="form-control" name="stock_quantity" id="stock_quantity" placeholder=" ">
                                    <label for="stock_quantity">Mask Amount</label>
                                    <div id="mask-amount-notice" class="place-right"></div>
                                </div>
                                
                                <div class="form-floating">
                                    <input required oninput="handleChangeShopsPhoneNumber(this)" type="text" class="form-control" name="shop_phone" id="shop_phone" placeholder=" ">
                                    <label for="shop_phone">Shop's Phone Number</label>
                                    <div id="shops-phone-number-notice" class="place-right"></div>
                                </div>
        
                                <button id="register-button" class="login-button w-100 btn btn-lg btn-success" type="submit">Register</button>
                                </form>
                                </div>   
                            </main>

                <?php 
                        }
                        else {
                            $shop_id = $query->fetch()['shop_id'];
                            $query = $connection->prepare('select * from shops where shop_id = ' . $shop_id);
                            $query->execute();
                            
                            $row = $query->fetch();
                            $shop_name = $row['shop_name']; $shop_city = $row['city']; $shop_phone = $row['phone_number'];
                            $per_mask_price = $row['per_mask_price']; $stock_quantity = $row['stock_quantity'];
                ?>          
                  
                                <main class="form-signin">
                                <div class="card profile">
                                    <h2>My Shop</h2>
                                    <table style="width: 100%" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Shop Name</th>
                                                <th scope="col">Shop Location</th>
                                                <th scope="col">Shop's Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-warning">
                                                <th scope='row'><?php echo $shop_name ?></th>
                                                <td><?php echo $shop_city ?></td>
                                                <td><?php echo $shop_phone ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <form action="updateShop.php" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Per Mask Price</span>
                                            <input required min="0" oninput="handleEditMaskPrice(this);" type="number" class="form-control" name="per_mask_price" placeholder="<?php echo $per_mask_price ?>" aria-label="per_mask_price" aria-describedby="basic-addon1">
                                            <input type="hidden" name="shop_id" value="<?php echo $shop_id ?>">
                                            <button id="edit-mask-price" class="btn btn-lg btn-success" type="submit">Edit</button>
                                            <div id="edit-mask-price-notice" class="place-right"></div>
                                        </div>
                                    </form>
                                    <form action="updateShop.php" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon2">Mask Amount</span>
                                            <input required min="0" oninput="handleEditMaskAmount(this)" type="number" class="form-control" name="stock_quantity" placeholder="<?php echo $stock_quantity ?>" aria-label="stock_quantity" aria-describedby="basic-addon1">
                                            <input type="hidden" name="shop_id" value="<?php echo $shop_id ?>">
                                            <button id="edit-mask-amount" class="btn btn-lg btn-info" type="submit">Edit</button>
                                            <div id="edit-mask-amount-notice" class="place-right">Mask Amount must be non-negative integer</div>
                                        </div>
                                    </form>
                                </div>
                                <!-- EOT; -->
                <?php            
                            $query = $connection->prepare("select A.staff_id, B.account, B.phone_number, B.full_name, B.city
                                                        from shop_staffs A join users B on A.staff_id = B.user_id 
                                                        where A.shop_id = " . $shop_id . " and isMaster = false");
                            $query->execute();
                            
                            echo<<<EOT
                                <div class="card profile">
                                    <h2>Employee</h2>
                                    <form action="updateShop.php" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">Type account</span>
                                            <input type="text" class="form-control" name="staff_userName" placeholder="Type account" aria-label="stock_quantity" aria-describedby="basic-addon1">
                                            <input type="hidden" name="shop_id" value="$shop_id">
                                            <button class="btn btn-lg btn-secondary" type="submit">Add</button>
                                        </div>
                                    </form>
                                </div>
                                EOT;
                            echo<<<EOT
                                <div class="card profile">
                                    <table style="width: 100%" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Account</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Operation</th>
                                            </tr>
                                        </thead>
                                EOT;
                                $i = 0;
                            while ($row = $query->fetch()) {
                                $j = $i + 1;
                                $staff_id = $row[0];
                                $staff_userName = $row[1]; $staff_phone = $row[2]; 
                                $staff_fullName = $row[3]; $staff_city = $row[4];
                                $className = ($j % 2) == 1 ? 'table-primary' : 'table-info';
                                echo<<<EOT
                                        <tbody>
                                            <tr class="$className">
                                                <th scope='row'>$staff_userName</th>
                                                <td>$staff_fullName</td>
                                                <td>$staff_phone</td>
                                                <td>
                                                    <form action="updateShop.php" method="post">
                                                        <input type="hidden" name="shop_id" value="$shop_id">
                                                        <button class="btn btn-sm btn-danger" type="submit" name="staff_id" value="$staff_id">Delete</button><br>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    EOT;
                                $i++;
                            }
                            echo<<<EOT
                                    </table>
                                </div>
                                </div>
                            EOT;
                        }
                    }
                    catch(Exception $e) {
                        $msg = $e->getMessage();
                        echo <<<EOT
                            <!DOCTYPE html>
                            <html>
                                <body>
                                    <script>
                                        alert("$msg");
                                        window.location.replace("userPage.php");
                                    </script>
                                </body>
                            </html>
                        EOT;
                    }
                ?>
            </div>
        <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW3 demo</p>
        </div>
    </body>
</html>
