<?php 
    include "authentication.php";
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
            .form-floating {
                position: relative;
            }
            .place-right {
                position: absolute;
                left: 325px;
                bottom: 15px;
                color: red;
                display: none;
                width: calc(50vw - 163px);
            }
            .show {
                display: block;
            }
            .select-label {
                position: absolute;
                top: 10px;
                left: 12px;
                font-size: 12px;
                color: #212529;
                opacity: 0.65;
            }
        </style>
    </head>
    <body class="text-center">
        <script src="utils.js"></script>
            <script>
                // utils.
                function disableSubmitButton(idName) {
                    document.getElementById(idName).disabled = true;
                }
                function enableSubmitButton(idName) {
                    document.getElementById(idName).disabled = false;
                }
                function handleButtons(element, index) {
                    var buttonId = 'single-cancel-' + index;
                }
                
            </script>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="back-tab" data-bs-toggle="tab" type="button" 
                            onClick="window.location.replace('userPage.php');">Home
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shop-tab" data-bs-toggle="tab" type="button" 
                            onClick="window.location.replace('shop.php');">Shop
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">My Order</button>
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
                    <h1 class="h3 mb-3 fw-normal">My Order</h1>
                    <form action="myOrder.php" method="post">
                        <div class="form-floating">
                            <div class="select-label">Status</div>
                            <select class="form-select" name="status">
                                <option value="3">All</option>
                                <option value="0">Not finished</option>
                                <option value="1">Finished</option>
                                <option value="2">Cancelled</option>
                            </select>
                        </div>
                        <button class="login-button w-100 btn btn-lg btn-primary" type="submit">Search</button>
                    </form>
                </main>
                
                <form action="manageOrders.php" method="post">
                    <input type="hidden" name="actionPage" value="0">
                    <button style="width:300px; margin-bottom: 20px;" class="btn btn-lg btn-secondary" id="multiple-cancel" name="cancelOrder" value="1">Cancel selected orders</button>
                    <div class="card profile">
                        <table style="width: 100%" class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Create Time</th>
                                    <th scope="col">Finish Time</th>
                                    <th scope="col">Shop</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        $sql_stmt = 'select 
                                                    A.order_id, A.order_status, A.create_time, B.account, A.finish_time, A.administer_id,
                                                    C.shop_name, A.purchase_amount, A.purchase_price
                                                    from orders A 
                                                    join users B on A.customer_id = B.user_id
                                                    join shops C on A.shop_id = C.shop_id
                                                    where A.customer_id = ' . $_SESSION['user_id'];
                                        
                                        if (isset($_POST['status']) && $_POST['status'] != 3)
                                            $sql_stmt .= (' and order_status = ' . $_POST['status']);
                                        $query = $connection->prepare($sql_stmt);
                                        $query->execute();
                                        
                                        $i = 0;
                                        while ($row = $query->fetch()) {
                                            $order_id = $row[0];
                                            $order_status;
                                            if ($row[1] == 0) $order_status = 'Not finished';
                                            else if ($row[1] == 1) $order_status = 'Finished';
                                            else $order_status = 'Cancelled';
                                            
                                            $create_time = $row[2];
                                            $buyer_account = $row[3];
                                            $finish_time = (empty($row[4]) ? '-' : $row[4]);

                                            $admin_account;
                                            if (!empty($row[5])) {
                                                $query2 = $connection->prepare('select account from users where user_id = ' . $row[5]);
                                                $query2->execute();
                                                $admin_account = $query2->fetch()[0];
                                            }
                                            else
                                                $admin_account = '-';

                                            $shop_name = $row[6];
                                            $amount = $row[7]; 
                                            $singlePrice = $row[8];
                                            $total_price = $amount * $singlePrice;
                                            
                                            $className = ($i % 2 ? 'table-primary' : 'table-info');
                                            echo<<<EOT
                                                <tr class="$className">
                                                    <th scope="row">
                                            EOT;
                                            if ($row[1] == 0) {
                                                echo<<<EOT
                                                    <input class="form-check-input" id="checkbox-$i" oninput="handleButtons(this, $i)" type="checkbox" name="orderIds[]" value="$order_id">
                                                EOT;
                                            }
                                            echo<<<EOT
                                                    </th>
                                                    <td>$order_id</td>
                                                    <td>$order_status</td>
                                                    <td>$create_time<br>$buyer_account</td>
                                                    <td>$finish_time<br>$admin_account</td>
                                                    <td>$shop_name</td>
                                                    <td>\$$total_price<br>($amount * \$$singlePrice)</td>
                                                    <td>
                                            EOT;
                                            if ($row[1] == 0) {
                                                echo<<<EOT
                                                    <form action="manageOrders.php" method="post">
                                                        <input type="hidden" name="order_id" value="$order_id">
                                                        <input type="hidden" name="actionPage" value="0">
                                                        <button class="btn btn-danger" id="single-cancel-$i" class="" type="submit" name="cancelOrder" value="1">Cancel</button>
                                                    </form>
                                                EOT;
                                            }
                                                        
                                            echo<<<EOT
                                                </td>
                                                </tr>
                                            EOT;
                                            $i++;
                                        }
                                    } 
                                    catch(exception $e) {
                                        $msg=$e->getMessage();
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
                            </tbody>
                        </table>
                    </div>
                </form>
                <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW3 demo</p>
            </div>
        </div>
    </body>
</html>
