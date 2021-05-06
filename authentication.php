<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['Authenticated']) || $_SESSION['Authenticated'] != true) {
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <body>
                <script>
                    alert('Please login');
                    window.location.replace('index.php');
                </script>
            </body>
        </html>
    EOT;
    exit();
}
?>