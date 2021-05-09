<?php 
    include "authentication.php";
    include "parameters.php";
    if (isset($_SESSION['shopNames'])) unset($_SESSION['shopNames']);
    if (isset($_SESSION['shopCities'])) unset($_SESSION['shopCities']);
    if (isset($_SESSION['shopMaskPrices'])) unset($_SESSION['shopMaskPrices']);
    if (isset($_SESSION['shopStockQuantities'])) unset($_SESSION['shopStockQuantities']);
    if (isset($_SESSION['shopPhones'])) unset($_SESSION['shopPhones']); 
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
                max-width: 330px;
                padding: 15px;
                margin: auto;
                margin-top: 15vh;
            }
            .login-button {
                margin-top: 15px;
            }
        </style>
    </head>
    <body class="text-center">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Shop</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" 
                            onClick="alert('Logout Success!'); window.location.replace('index.php');">Logout
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <main class="form-signin">
                    <h2>Profile</h2>
                    <?php
                        echo "Account: " . $_SESSION['account'] . "<br>" .
                             "Full Name: " . $_SESSION['full_name'] . "<br>" .
                             "Phone Number: " . $_SESSION['phone_number'] . "<br>" .
                             "City of Residence: " . $_SESSION['city'] . "<br>";
                    ?>

                    <h2>Shop List</h2>
                    <form action="searchShop.php" method="post">
                        Shop: <input type="text" name="shop_name"><br>
                        City: <select name="shop_city">
                                <option value="">All</option>
                                <?php
                                    foreach ($cities as $city)
                                        echo '<option value="' . $city . '">' . $city . '</option>';
                                ?>
                              </select><br>
                        Price: min<input type="text" name="min_price"><br> 
                               max<input type="text" name="max_price"><br>
                        Amount: <select name="amount">
                                    <option value="-1">All</option>
                                    <?php
                                        for ($i = 0; $i < count($amount); $i++)
                                            echo '<option value="' . $i . '">' . $amount[$i] . '</option>';
                                    ?>
                                </select><br>
                        Only show the shop I work at <input type="checkbox" value="1" name="isShopStaff">
                        <button class="login-button w-100 btn btn-lg btn-success" type="submit">Search</button>
                    </form>
                    <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW2 demo</p>
                </main>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <main class="form-signin">
                    <?php 
                        try {
                            $query = $connection->prepare('select * from shop_staffs where isMaster = true and staff_id = ' . $_SESSION['user_id']);
                            $query->execute();
                            
                            if ($query->rowCount() == 0) {
                                echo<<<EOT
                                <form action="registerShop.php" method="post">
                                    <img src="./login.png" alt="" height="120" width="108">
                                    <h1 class="h3 mb-3 fw-normal">Register Shop</h1>
            
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder=" ">
                                        <label for="shop_name">Shop Name</label>
                                    </div>
                                EOT;
                                
                                echo<<<EOT
                                    <div class="form-floating">
                                        City of Shop Location
                                        <select name="shop_city">
                                    EOT;
                                
                                foreach ($cities as $city)
                                    echo "<option value=\"" . $city . "\">" . $city . "</option>";
                                
                                echo<<<EOT
                                        </select>
                                    </div>
                                EOT;
                                
                                echo<<<EOT
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="pre_mask_price" id="pre_mask_price" placeholder=" ">
                                        <label for="pre_mask_price">Mask Price</label>
                                    </div>
                                
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="stock_quantity" id="stock_quantity" placeholder=" ">
                                        <label for="stock_quantity">Mask Amount</label>
                                    </div>
                                    
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="shop_phone" id="shop_phone" placeholder=" ">
                                        <label for="shop_phone">Shop's Phone Number</label>
                                    </div>
            
                                    <button class="login-button w-100 btn btn-lg btn-success" type="submit">Register</button>
                                </form>
                                EOT;
                            }
                            else {
                                $shop_id = $query->fetch()['shop_id'];
                                $query = $connection->prepare('select * from shops where shop_id = ' . $shop_id);
                                $query->execute();
                                
                                $row = $query->fetch();
                                $shop_name = $row['shop_name']; $shop_city = $row['city']; $shop_phone = $row['phone_number'];
                                $per_mask_price = $row['per_mask_price']; $stock_quantity = $row['stock_quantity'];
                                
                                echo<<<EOT
                                    <h1>My Shop</h1>
                                    <li> Shop Name: $shop_name</li>
                                    <li> City of Shop Location: $shop_city</li> 
                                    <li> Shop's Phone: $shop_phone</li> 
                                    <form action="updateShop.php" method="post">
                                        Per Mask Price: <input type="text" name="per_mask_price" placeholder="$per_mask_price"> 
                                                        <input type="hidden" name="shop_id" value="$shop_id">
                                                        <button type="submit">Edit</button><br>
                                    </form>
                                    <form action="updateShop.php" method="post">
                                        Mask Amount: <input type="text" name="stock_quantity" placeholder="$stock_quantity"> 
                                                     <input type="hidden" name="shop_id" value="$shop_id">
                                                     <button type="submit">Edit</button><br>
                                    </form>
                                    EOT;
                                
                                $query = $connection->prepare("select A.staff_id, B.account, B.phone_number, B.full_name, B.city
                                                               from shop_staffs A join users B on A.staff_id = B.user_id 
                                                               where A.shop_id = " . $shop_id . " and isMaster = false");
                                $query->execute();
                                
                                echo<<<EOT
                                    <h1>Employee</h1>
                                    <form action="updateShop.php" method="post"> 
                                        Type account: <input type="text" name="staff_userName" placeholer="Type account">
                                        <input type="hidden" name="shop_id" value="$shop_id">
                                        <button type="submit">Add</button><br>
                                    </form>
                                    EOT;
                                
                                    $i = 0;
                                while ($row = $query->fetch()) {
                                    $j = $i + 1;
                                    $staff_id = $row[0];
                                    $staff_userName = $row[1]; $staff_phone = $row[2]; 
                                    $staff_fullName = $row[3]; $staff_city = $row[4];
                                    echo<<<EOT
                                        <form action="updateShop.php" method="post">
                                            <li>
                                                [$j] Account: $staff_userName<br>
                                                Full Name: $staff_fullName<br>
                                                Phone: $staff_phone<br>
                                                <button type="submit" name="staff_id" value="$staff_id">Delete</button><br>
                                            </li>
                                        </form>
                                        EOT;
                                    $i++;
                                }
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
                        
                    <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW2 demo</p>
                </main>
            </div>
        </div>
    </body>
</html>