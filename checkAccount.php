<?php 
include "db_connection.php";

try {
    // if (!isset($_REQUEST['checkAccount']) || empty($_REQUEST['checkAccount'])) {
    //     echo 'FAILED';
    //     exit(); 
    // }
    if (isset($_REQUEST['checkAccount'])) {

        $acc = $_REQUEST['checkAccount'];
        $query = $connection->prepare("select account from users where account = :acc");
        $query->execute(array('acc' => $acc));
        if ($query->rowCount() == 0) {
            echo 'YES'; 
        }
        else {
            echo 'NO'; 
        }
    }
}

catch (Exception $e) {
    echo 'Failed';
}

?>