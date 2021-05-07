<?php
include "authentication.php";

try {
    $shop_name = $_POST['shop_name'];
    $shop_city = $_POST['shop_city'];
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];
    $amount = $_POST['amount'];
    $isShopStaff = isset($_POST['isShopStaff']) ? $_POST['isShopStaff'] : 0;
    
    echo 'Shop Name: ' . $_POST['shop_name'] . '<br>';
    echo 'Shop City: ' . $_POST['shop_city'] . '<br>';
    echo 'Min price: ' . $_POST['min_price'] . '<br>';
    echo 'Max price: ' . $_POST['max_price'] . '<br>';
    echo 'Amount: ' . $_POST['amount'] . '<br>';
    echo 'isShopStaff: ' . $isShopStaff . '<br>';
    
    if (empty($shop_name) && empty($shop_city) && empty($min_price) && empty($max_price) && $amount == -1 && $isShopStaff == -1) {
        $stmt = $connection->prepare('select * from shops');
        $stmt->execute();
    }
    else {
        $conditions = array();
        $conditions['shop_name'] = '%' . strtolower($shop_name). '%';
        $conditions['shop_city'] = '%' . strtolower($shop_city). '%';
        if (!empty($min_price)) $conditions['min_price'] = $min_price;
        if (!empty($max_price)) $conditions['max_price'] = $max_price;
        
        $sql_stmt = 'select * from shops
                     where (lower(shop_name) like :shop_name) and (city like :shop_city)';
        
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
        
        
        $stmt = $connection->prepare($sql_stmt);
        $stmt->execute($conditions);
    }

    $i = 0;
    while ($row = $stmt->fetch()) {
        echo '[' . $i . ']' . ' ' .
             'Shop Name: ' . $row['shop_name'] . '; ' .
             'Shop City: ' . $row['city'] . '; ' .
             'Per Mask Price: ' . $row['per_mask_price'] . '; ' .
             'Stock Quantity: ' . $row['stock_quantity']. '; ' .
             'Phone Number: ' . $row['phone_number'] . '; ' .
             '<br>';
        $i++;
    }

    echo '<button type="button" onClick="location.href=' . '\'userPage.php\'"' . '>Back</button>';
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