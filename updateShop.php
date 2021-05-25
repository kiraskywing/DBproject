<?php
include "authentication.php";

try {
    if (isset($_POST['per_mask_price'])) {
        $per_mask_price = $_POST['per_mask_price'];
        if (!is_numeric($per_mask_price) || $per_mask_price < 0) 
            throw new Exception("Mask price must be non-negative integer!");
        $query = $connection->prepare('update shops set per_mask_price = :per_mask_price where shop_id = ' . $_POST['shop_id']);
        $query->execute(array('per_mask_price' => $per_mask_price));
    }
    
    if (isset($_POST['stock_quantity'])) {
        $stock_quantity = $_POST['stock_quantity'];
        if (!is_numeric($stock_quantity) || $stock_quantity < 0) 
            throw new Exception("Mask amount must be non-negative integer!");
        $query = $connection->prepare('update shops set stock_quantity = :stock_quantity where shop_id = ' . $_POST['shop_id']);
        $query->execute(array('stock_quantity' => $stock_quantity));
    }
    
    if (isset($_POST['staff_userName'])) {
        if (!empty($_POST['staff_userName'])) {
            $query = $connection->prepare('select user_id from users where account = :acc');
            $query->execute(array('acc' => $_POST['staff_userName']));
            
            if ($query->rowCount() == 0)
            throw new Exception("This person doesn't exist!");
            
            $staff_id = $query->fetch()[0];
            $query = $connection->prepare('select * from shop_staffs where staff_id = ' . $staff_id . ' and shop_id = ' . $_POST['shop_id']);
            $query->execute();
            
            if ($query->rowCount() == 1)
            throw new Exception("This person is already working at this shop!");
            
            $query = $connection->prepare('insert into shop_staffs (staff_id, shop_id, isMaster) values (' . $staff_id . ', ' . $_POST['shop_id'] . ', false)');
            $query->execute();
        }
        else
            throw new Exception('No added account!');
    }
    
    if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
        $query = $connection->prepare('delete from shop_staffs where shop_id = ' . $_POST['shop_id'] . ' and staff_id = ' . $_POST['staff_id']);
        $query->execute();
    }
    
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <body>
                <script>
                    alert("Update Success!");
                    window.location.replace("shop.php");
                </script>
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
                    window.location.replace("shop.php");
                </script>
            </body>
        </html>
    EOT;
}
?>