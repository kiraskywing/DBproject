<?php
include "authentication.php";

try {
    $listsPerPage = 5;
    
    if (!isset($_SESSION['shopNames']) && !isset($_SESSION['shopCities']) && !isset($_SESSION['shopMaskPrices']) 
     && !isset($_SESSION['shopStockQuantities']) && !isset($_SESSION['shopPhones'])) {
        $shop_name = $_POST['shop_name'];
        $shop_city = $_POST['shop_city'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $amount = $_POST['amount'];
        $isShopStaff = isset($_POST['isShopStaff']) ? $_POST['isShopStaff'] : 0;
        
        $conditions = array();
        if (empty($shop_name) && empty($shop_city) && empty($min_price) && empty($max_price) && $amount == -1 && $isShopStaff == 0) {
            $sql_stmt = 'select * from shops';
        }
        else {
            $conditions['shop_name'] = '%' . strtolower($shop_name). '%';
            $conditions['shop_city'] = '%' . strtolower($shop_city). '%';
            if (!empty($min_price)) $conditions['min_price'] = $min_price;
            if (!empty($max_price)) $conditions['max_price'] = $max_price;
            
            $sql_stmt = 'select * from shops where (lower(shop_name) like :shop_name) and (city like :shop_city)';
            
            if (!empty($min_price) && !empty($max_price))
                $sql_stmt .= 'and (per_mask_price between :min_price and :max_price)';
            else if (!empty($min_price))
                $sql_stmt .= 'and per_mask_price >= :min_price';
            else if (!empty($max_price))
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
        $_SESSION['shopNames'] = array();
        $_SESSION['shopCities'] = array();
        $_SESSION['shopMaskPrices'] = array();
        $_SESSION['shopStockQuantities'] = array();
        $_SESSION['shopPhones'] = array();
        $query = $connection->prepare($sql_stmt);
        $query->execute($conditions);
        
        while ($row = $query->fetch()) {
            $_SESSION['shopNames'][$i] = $row['shop_name'];
            $_SESSION['shopCities'][$i] = $row['city'];
            $_SESSION['shopMaskPrices'][$i] = $row['per_mask_price'];
            $_SESSION['shopStockQuantities'][$i] = $row['stock_quantity'];
            $_SESSION['shopPhones'][$i] = $row['phone_number'];
            $i++;
        }

        $_SESSION['totalLists'] = $i;
        $_SESSION['totalPages'] = ceil($i / $listsPerPage);
    }
    
    if (isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = 1;

    echo <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    
                    <!-- CSS only -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

                    <!-- JavaScript Bundle with Popper -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
 
                </head>
                <body>
    EOT;
    // pagination
    echo '<nav style="margin-top: 50px"aria-label="123"><ul class="pagination">';

    // prev
    if ($page <= 1)
        echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
    else
        echo '<li class="page-item"> <a class="page-link" href=\'searchShop.php?page=' . $page - 1 . '\'" tabindex="-1" aria-disabled="true">Previous</a></li>';

    // item
    for ($i = 1; $i <= $_SESSION['totalPages']; $i++)
    {
        if ($i == $page) {
            echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
        } else {
            echo "<li class='page-item'><a class='page-link' href='searchShop.php?page=$i'>$i</a></li> ";
        }   
    }

    // next
    if ($page < $_SESSION['totalPages'])
        echo '<li class="page-item"><a class="page-link" href=\'searchShop.php?page=' . $page + 1 . '\'">Next</a></li>';
    else
        echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';

    echo '</ul></nav>';
    $showLists = min($_SESSION['totalLists'] - $listsPerPage * ($page - 1), $listsPerPage);

    // sort
    if (!isset($_SESSION['order']))
        $_SESSION['order'] = array_keys($_SESSION['shopNames']);

    echo<<<EOT
        <div class="card profile">
            <table style="width: 100%" class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <form action="sortResult.php" method="post">
                                <button type="submit" name="shopName" value="1">Shop Name</button>
                            </form>
                        </th>
                        <th scope="col">Shop Location</th>
                        <th scope="col">Per Mask Price</th>
                        <th scope="col">Stock Quantity</th>
                        <th scope="col">Phone Number</th>
                    </tr>
                </thead>
        EOT;
    $i = 0 + $listsPerPage * ($page - 1);
    for ($j = 0; $j < $showLists; $i++, $j++) {
        $className = ($j % 2) == 1 ? 'table-primary' : 'table-info';
        echo<<<EOT
            <tbody>
                <tr class="$className">
        EOT;

        echo '<th scope="row">' . $_SESSION['shopNames'][$_SESSION['order'][$i]] . '</th>' .
             '<td>' . $_SESSION['shopCities'][$_SESSION['order'][$i]]  . '</td>' .
             '<td>' . $_SESSION['shopMaskPrices'][$_SESSION['order'][$i]] . '</td>' .
             '<td>' . $_SESSION['shopStockQuantities'][$_SESSION['order'][$i]] . '</td>' .
             '<td>' . $_SESSION['shopPhones'][$_SESSION['order'][$i]] . '</td>' ;

        echo<<<EOT
                </tr>
            </tbody>
        EOT;
    }
    echo<<<EOT
                    </table>
                </div>
                <button style="margin-top: 20px" class="btn btn-primary" type="button" onClick="location.href='userPage.php'">Back</button>
            </body>
        </html>
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
