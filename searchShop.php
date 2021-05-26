<!DOCTYPE html>
    <html>
        <head>
            
            <!-- CSS only -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

            <!-- JavaScript Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

            <style>
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
                function handleSubmit(element, type) {
                    document.getElementById(type).click(); 
                }
                function enableCreateOrderButton(idName) {
                    document.getElementById(idName).disabled = false;
                }
                function disableCreateOrderButton(idName) {
                    document.getElementById(idName).disabled = true;
                }
                function showNotice(idName) {
                    document.getElementById(idName).classList.add('show');
                }
                function hideNotice(idName) {
                    document.getElementById(idName).classList.remove('show');
                }
                function handleOrderMaskAmount(element, index, amountLimit) {
                    var idButton = 'create-order-' + index;
                    var idNotice = 'create-order-notice-' + index;
                    if (element.value.length == 0) {
                        document.getElementById(idNotice).innerHTML = 'Input Required!';
                        showNotice(idNotice);
                        disableCreateOrderButton(idButton);
                        return;
                    }
                    if (isPositive(element.value)) {
                        if (element.value <= amountLimit) {
                            hideNotice(idNotice);
                            enableCreateOrderButton(idButton);
                        }
                        else {
                            document.getElementById(idNotice).innerHTML = "Order quantity shouldn't be greater than stock quantity!";
                            showNotice(idNotice);
                            disableCreateOrderButton(idButton);
                        }
                    } else {
                        document.getElementById(idNotice).innerHTML = 'Must be positive integer!';
                        showNotice(idNotice);
                        disableCreateOrderButton(idButton);
                    }
                }
            </script>
        </head>
        <body>
    <?php
    include "authentication.php";

    try {
        if (!isset($_SESSION['shop_name']) && !isset($_SESSION['shop_city']) && !isset($_SESSION['min_price']) && 
            !isset($_SESSION['max_price']) && !isset($_SESSION['amount']) && !isset($_SESSION['isShopStaff'])) {
            
            if (!isset($_POST['shop_name']) || !isset($_POST['shop_city']) || !isset($_POST['min_price']) 
             || !isset($_POST['max_price']) || !isset($_POST['amount'])) {
                header("Location: userPage.php");
                exit();
            }
            
            $_SESSION['shop_name'] = $_POST['shop_name'];
            $_SESSION['shop_city'] = $_POST['shop_city'];
            $_SESSION['min_price'] = $_POST['min_price'];
            $_SESSION['max_price'] = $_POST['max_price'];
            $_SESSION['amount'] = $_POST['amount'];
            $_SESSION['isShopStaff'] = isset($_POST['isShopStaff']) ? $_POST['isShopStaff'] : 0;
        }

        $shop_name = $_SESSION['shop_name'];
        $shop_city = $_SESSION['shop_city'];
        $min_price = $_SESSION['min_price'];
        $max_price = $_SESSION['max_price'];
        $amount = $_SESSION['amount'];
        $isShopStaff = $_SESSION['isShopStaff'];

        $conditions = array();
        if (empty($shop_name) && empty($shop_city) && !is_numeric($min_price) && !is_numeric($max_price) && $amount == -1 && $isShopStaff == 0) {
            $sql_stmt = 'select * from shops';
        }
        else {
            $conditions['shop_name'] = '%' . strtolower($shop_name). '%';
            $conditions['shop_city'] = '%' . strtolower($shop_city). '%';
            if (is_numeric($min_price)) {
                if ($min_price < 0)
                    throw new Exception("Price must be non-negative integer");
                $conditions['min_price'] = $min_price;
            }
            if (is_numeric($max_price)) {
                if ($max_price < 0)
                    throw new Exception("Price must be non-negative integer");
                $conditions['max_price'] = $max_price;
            }

            $sql_stmt = 'select * from shops where (lower(shop_name) like :shop_name) and (city like :shop_city)';

            if (is_numeric($min_price) && is_numeric($max_price))
                $sql_stmt .= 'and (per_mask_price between :min_price and :max_price)';
            else if (is_numeric($min_price))
                $sql_stmt .= 'and per_mask_price >= :min_price';
            else if (is_numeric($max_price))
                $sql_stmt .= 'and per_mask_price <= :max_price';

            if ($amount == 0)
                $sql_stmt .= 'and stock_quantity = 0';
            else if ($amount == 1)
                $sql_stmt .= 'and (stock_quantity between 1 and 499)';
            else if ($amount == 2)
                $sql_stmt .= 'and stock_quantity >= 500';

            if ($isShopStaff == 1)
                $sql_stmt .= 'and (shop_id in (select shop_id from shop_staffs where staff_id = ' . $_SESSION['user_id'] . '))';
        }

        $i = 0;
        $shopIds = array();
        $shopNames = array();
        $shopCities = array();
        $shopMaskPrices = array();
        $shopStockQuantities = array();
        $shopPhones = array();
        $query = $connection->prepare($sql_stmt);
        $query->execute($conditions);

        while ($row = $query->fetch()) {
            $shopIds[$i] = $row['shop_id'];
            $shopNames[$i] = $row['shop_name'];
            $shopCities[$i] = $row['city'];
            $shopMaskPrices[$i] = $row['per_mask_price'];
            $shopStockQuantities[$i] = $row['stock_quantity'];
            $shopPhones[$i] = $row['phone_number'];
            $i++;
        }
        
        $listsPerPage = 5;
        $totalLists = $i;
        $totalPages = ceil($totalLists / $listsPerPage);
        
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);

        // pagination
        echo '<nav style="margin-top: 50px"aria-label="123"><ul class="pagination">';

        // prev
        if ($page <= 1)
            echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
        else
            echo '<li class="page-item"> <a class="page-link" href=\'searchShop.php?page=' . $page - 1 . '\'" tabindex="-1" aria-disabled="true">Previous</a></li>';

        // item
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='searchShop.php?page=$i'>$i</a></li> ";
            }   
        }

        // next
        if ($page < $totalPages)
            echo '<li class="page-item"><a class="page-link" href=\'searchShop.php?page=' . $page + 1 . '\'">Next</a></li>';
        else
            echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';

        echo '</ul></nav>';
        $showLists = min($totalLists - $listsPerPage * ($page - 1), $listsPerPage);

        // sort
        if (isset($_POST['sortName'])) {
            if (!isset($_SESSION['sortShopName'])) 
                $_SESSION['sortShopName'] = 1;
            else 
                $_SESSION['sortShopName'] ^= 1;
            $_SESSION['sortBy'] = 0;
        } 
        else if (isset($_POST['sortCity'])) {
            if (!isset($_SESSION['sortShopCity'])) 
                $_SESSION['sortShopCity'] = 1;
            else 
                $_SESSION['sortShopCity'] ^= 1;
            $_SESSION['sortBy'] = 1;
        }
        else if (isset($_POST['sortPrice'])) {
            if (!isset($_SESSION['sortMaskPrice'])) 
                $_SESSION['sortMaskPrice'] = 1;
            else 
                $_SESSION['sortMaskPrice'] ^= 1;
            $_SESSION['sortBy'] = 2;
        }
        else if (isset($_POST['sortAmount'])) {
            if (!isset($_SESSION['sortMaskAmount'])) 
                $_SESSION['sortMaskAmount'] = 1;
            else 
                $_SESSION['sortMaskAmount'] ^= 1;
            $_SESSION['sortBy'] = 3;
        }
        else if (isset($_POST['sortPhone'])) {
            if (!isset($_SESSION['sortShopPhone'])) 
                $_SESSION['sortShopPhone'] = 1;
            else 
                $_SESSION['sortShopPhone'] ^= 1;
            $_SESSION['sortBy'] = 4;
        }

        $order;
        if (!isset($_SESSION['sortBy']))
            $order = array_keys($shopNames);
        else {
            if ($_SESSION['sortBy'] == 0) {
                $_SESSION['sortShopName'] ? asort($shopNames) : arsort($shopNames);
                $order = array_keys($shopNames);
            }
            else if ($_SESSION['sortBy'] == 1) {
                $_SESSION['sortShopCity'] ? asort($shopCities) : arsort($shopCities);
                $order = array_keys($shopCities);
            }
            else if ($_SESSION['sortBy'] == 2) {
                $_SESSION['sortMaskPrice'] ? asort($shopMaskPrices) : arsort($shopMaskPrices);
                $order = array_keys($shopMaskPrices);
            }
            else if ($_SESSION['sortBy'] == 3) {
                $_SESSION['sortMaskAmount'] ? asort($shopStockQuantities) : arsort($shopStockQuantities);
                $order = array_keys($shopStockQuantities);
            }
            else if ($_SESSION['sortBy'] == 4) {
                $_SESSION['sortShopPhone'] ? asort($shopPhones) : arsort($shopPhones);
                $order = array_keys($shopPhones);
            }
        }

        echo<<<EOT
            <div class="card profile">
                <table style="width: 100%" class="table">
                    <thead>
                        <tr>
                            <th scope="col" onclick="handleSubmit(this, 'shop-name-trigger')">
                                Shop Name
                                <form action="searchShop.php?page=$page" method="post">
                                    <input type="hidden" name="page" value="$page">
                                    <button id="shop-name-trigger" style="display: none;" type="submit" name="sortName" value="1">Shop Name</button>
                                </form>
                            </th>
                            <th scope="col" onclick="handleSubmit(this, 'shop-city-trigger')">
                                Shop Location
                                <form action="searchShop.php?page=$page" method="post">
                                    <input type="hidden" name="page" value="$page">
                                    <button id="shop-city-trigger" style="display: none;" type="submit" name="sortCity" value="1">Shop Location</button>
                                </form>
                            </th>
                            <th scope="col" onclick="handleSubmit(this, 'mask-price-trigger')">
                                Per Mask Price
                                <form action="searchShop.php?page=$page" method="post">
                                    <input type="hidden" name="page" value="$page">    
                                    <button id="mask-price-trigger" style="display: none;" type="submit" name="sortPrice" value="1">Per Mask Price</button>
                                </form>
                            </th>
                            <th scope="col" onclick="handleSubmit(this, 'mask-amount-trigger')">
                                Stock Quantity
                                <form action="searchShop.php?page=$page" method="post">
                                    <input type="hidden" name="page" value="$page">    
                                    <button id="mask-amount-trigger" style="display: none;" type="submit" name="sortAmount" value="1">Stock Quantity</button>
                                </form>
                            </th>
                            <th scope="col" onclick="handleSubmit(this, 'shop-phone-trigger')">
                                Phone Number
                                <form action="searchShop.php?page=$page" method="post">
                                    <input type="hidden" name="page" value="$page">    
                                    <button id="shop-phone-trigger" style="display: none;" type="submit" name="sortPhone" value="1">Phone Number</button>
                                </form>
                            </th>
                            <th scope="col">
                                Order Quantity
                            </th>
                        </tr>
                    </thead>
            EOT;
        $i = 0 + $listsPerPage * ($page - 1);
        for ($j = 0; $j < $showLists; $i++, $j++) {
            $className = ($j % 2) == 1 ? 'table-primary' : 'table-info';

            $shop_id = $shopIds[$order[$i]];
            $shop_name = $shopNames[$order[$i]];
            $shop_city = $shopCities[$order[$i]];
            $single_price = $shopMaskPrices[$order[$i]];
            $stock_quantity = $shopStockQuantities[$order[$i]];
            $shop_phone = $shopPhones[$order[$i]];

            echo<<<EOT
            <tbody>
                <tr class="$className">
                    <th scope="row">$shop_name</th>
                    <td>$shop_city</td>
                    <td>$single_price</td>
                    <td>$stock_quantity</td>
                    <td>$shop_phone</td>
                    <td>
                        <form action="manageOrders.php" method="post">
                            <input type="hidden" name="shop_id" value="$shop_id">
                            <input type="hidden" name="maskPrice" value="$single_price">
                            <input required min="1" oninput="handleOrderMaskAmount(this, $j, $stock_quantity)" type="number" name="maskAmount" placeholder=0>
                            <button id="create-order-$j" class="" type="submit" name="createOrder" value="1">Buy!</button>
                            <div id="create-order-notice-$j" ></div>
                        </form>
                    </td>
                </tr>
            </tbody>
            EOT;
        }
        echo<<<EOT
                </table>
            </div>
            <button style="margin-top: 20px" class="btn btn-primary" type="button" onClick="location.href='userPage.php'">Back to Home</button>
        EOT;
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
    </body>
</html>
