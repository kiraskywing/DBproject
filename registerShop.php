<?php 
include "authentication.php"; 

try {
    if (isset($_REQUEST['checkShop'])) {
        $shopName = $_REQUEST['checkShop'];
        $query = $connection->prepare("select shop_name from shops where shop_name = :shopName");
        $query->execute(array('shopName' => $shopName));
        
        if ($query->rowCount() == 0)
            echo 'YES';
        else 
            echo 'NO'; 
        
        exit();
    }
}
catch (Exception $e) {
    echo 'Failed';
    exit();
}

try {
    if (!isset($_POST['shop_name']) || !isset($_POST['shop_city']) || !isset($_POST['pre_mask_price']) 
        || !isset($_POST['stock_quantity']) || !isset($_POST['shop_phone'])) 
    {
        header("Location: userPage.php");
        exit();
    }
    if (empty($_POST['shop_name']) || empty($_POST['shop_city']) || empty($_POST['pre_mask_price']) 
        || empty($_POST['stock_quantity']) || empty($_POST['shop_phone'])) 
    {
        throw new Exception('Please input all information.');
    }

    $shop_name = $_POST['shop_name'];
    $shop_city = $_POST['shop_city'];
    $pre_mask_price = $_POST['pre_mask_price'];
    $stock_quantity = $_POST['stock_quantity'];
    $shop_phone = $_POST['shop_phone'];
    
    // if (!is_numeric($pre_mask_price) || (int)$pre_mask_price != $pre_mask_price || $pre_mask_price < 0)
    //     throw new Exception('Mask price should be non-negative integer!');
    // if (!is_numeric($stock_quantity) || (int)$stock_quantity != $stock_quantity || $stock_quantity < 0)
    //     throw new Exception('Stock quantity should be non-negative integer!');

    $query = $connection->prepare('select * from shops where shop_name = :shop_name');
    $query->execute(array('shop_name' => $shop_name));

    if ($query->rowCount() == 0) {
        $query = $connection->prepare("insert into shops (shop_name, city, per_mask_price, stock_quantity, phone_number) 
                                                  values (:shop_name, :shop_city, :pre_mask_price, :stock_quantity, :shop_phone)");
        $query->execute(array('shop_name' => $shop_name, 'shop_city' => $shop_city , 'pre_mask_price' => $pre_mask_price,
                              'stock_quantity' => $stock_quantity, 'shop_phone' => $shop_phone));
        
        $query = $connection->prepare('select shop_id from shops where shop_name = :shop_name');
        $query->execute(array('shop_name' => $shop_name));
        
        $row = $query->fetch();     
        $staff_id = $_SESSION['user_id'];
        $shop_id = $row[0];
        $query = $connection->prepare('insert into shop_staffs (staff_id, shop_id, isMaster) values (' . $staff_id . ', ' . $shop_id . ', true)');
        $query->execute();
                                    
        echo <<<EOT
            <!DOCTYPE html>
            <html>
                <body>
                    <script>
                        alert("Register Shop Success!");
                        window.location.replace("userPage.php");
                    </script>
                </body>
            </html>
        EOT;
        exit();
    }
    else 
        throw new Exception("Shop name has been registered!");
}
catch (Exception $e) {
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