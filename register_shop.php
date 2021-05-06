<?php 

include "authentication.php"; 

try {
    $shop_name = $_SESSION['shop_name'];
    $shop_city = $_SESSION['shop_city'];
    $pre_mask_price = $_SESSION['pre_mask_price'];
    $stock_quantity = $_SESSION['stock_quantity'];
    $shop_phone = $_SESSION['shop_phone'];

    $stmt=$connection->prepare("insert into shops (shop_name, city, per_mask_price, stock_quantity, phone_number) 
                                values (:shop_name, :shop_city, :pre_mask_price, :stock_quantity, :shop_phone)");
    $stmt->execute(array('shop_name' => $shop_name, 'shop_city'=>$shop_city , 'pre_mask_price' => $pre_mask_price,
                         'stock_quantity' => $stock_quantity, 'shop_phone' => $shop_phone));
}
catch (Exception $e) {
    $msg=$e->getMessage();
    session_unset(); 
    session_destroy(); 

    echo <<<EOT
      <!DOCTYPE html>
      <html>
          <body>
              <script>
                  alert("$msg");
                  window.location.replace("index.php");
              </script>
          </body>
      </html>
    EOT;
}

?>