<?php 

include "authentication.php"; 

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

    $stmt = $connection->prepare('select * from shops where shop_name = :shop_name');
    $stmt->execute(array('shop_name' => $shop_name));

    if ($stmt->rowCount() == 0) {
        $stmt=$connection->prepare("insert into shops (shop_name, city, per_mask_price, stock_quantity, phone_number) 
                                    values (:shop_name, :shop_city, :pre_mask_price, :stock_quantity, :shop_phone)");
        $stmt->execute(array('shop_name' => $shop_name, 'shop_city' => $shop_city , 'pre_mask_price' => $pre_mask_price,
                             'stock_quantity' => $stock_quantity, 'shop_phone' => $shop_phone));
        
        $stmt=$connection->prepare('select shop_id from shops where shop_name = :shop_name');
        $stmt->execute(array('shop_name' => $shop_name));
        
        $row = $stmt->fetch();     
        $staff_id = $_SESSION['user_id'];
        $shop_id = $row[0];
        $stmt=$connection->prepare('insert into shop_staffs (staff_id, shop_id, isMaster) values (' . $staff_id . ', ' . $shop_id . ', true)');
        $stmt->execute();
                                    
        echo <<<EOT
            <!DOCTYPE html>
            <html>
                <body>
                    <script>
                        alert("Create Shop Success!");
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