<?php 
include "authentication.php";

try {
    if (isset($_POST['createOrder']) && isset($_POST['shop_id']) && isset($_POST['maskPrice']) && isset($_POST['maskAmount'])) {
        $connection->beginTransaction();
        $query = $connection->prepare('select stock_quantity from shops where shop_id = ' . $_POST['shop_id']);
        $query->execute();
        
        $currentShopAmount = $query->fetch()[0];
        if ($_POST['maskAmount'] > $currentShopAmount)
            throw new Exception("Sorry, currently shop's mask amount is less than order's mask amount.");

        $query = $connection->prepare('insert into orders (order_status, customer_id, shop_id, purchase_price, purchase_amount) 
                                       values (0, ' . $_SESSION['user_id'] . ', ' . $_POST['shop_id'] . ', ' . $_POST['maskPrice'] . ', :amount)');
        $query->execute(array('amount' => $_POST['maskAmount']));
        $currentShopAmount -= $_POST['maskAmount'];
        $query = $connection->prepare('update shops set stock_quantity = :stock_quantity where shop_id = ' . $_POST['shop_id']);
        $query->execute(array('stock_quantity' => $currentShopAmount));

        $connection->commit();
                                    
        echo <<<EOT
            <!DOCTYPE html>
            <html>
                <body>
                    <script>
                        alert("Create Order Success!");
                        window.location.replace("userPage.php");
                    </script>
                </body>
            </html>
        EOT;
        exit();
    }
}
catch(exception $e) {
    if ($connection->inTransaction())
        $connection->rollBack();

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