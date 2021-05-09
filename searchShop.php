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
                $sql_stmt .= 'and (stock_quantity between 1 and 99)';
            else if ($amount == 2)
                $sql_stmt .= 'and stock_quantity >= 100';
            
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
            <body>
    EOT;
    
    if ($page > 1)
        echo '<button type="button" onClick="location.href=\'searchShop.php?page=' . $page - 1 . '\'">Last</button>';
    for ($i = 1; $i <= $_SESSION['totalPages']; $i++)
    {
        if ($i == $page)
            echo "$i ";
        else
            echo "<a href='searchShop.php?page=$i'>$i</a>";
    }
    if ($page < $_SESSION['totalPages'])
        echo '<button type="button" onClick="location.href=\'searchShop.php?page=' . $page + 1 . '\'">Next</button><br>';

    $showLists = min($_SESSION['totalLists'] - $listsPerPage * ($page - 1), $listsPerPage);

    echo '<ul>';
    $i = 0 + $listsPerPage * ($page - 1);
    for ($j = 0; $j < $showLists; $i++, $j++) {
        echo '<li> ' . '[' . $i + 1 . ']' . ' ' .
             'Shop Name: ' . $_SESSION['shopNames'][$i] . '; ' . '<br>' .
             'Shop City: ' . $_SESSION['shopCities'][$i] . '; ' . '<br>' .
             'Per Mask Price: ' . $_SESSION['shopMaskPrices'][$i] . '; ' . '<br>' .
             'Stock Quantity: ' . $_SESSION['shopStockQuantities'][$i] . '; ' . '<br>' .
             'Phone Number: ' . $_SESSION['shopPhones'][$i] . '; ' . '<br>' .
             '<br><br></li>';
    }
    echo '</ul>';
    echo '<button type="button" onClick="location.href=' . '\'userPage.php\'"' . '>Back</button>';
    echo '</body></html>';
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