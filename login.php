<?php
session_start();
$_SESSION['Authenticated'] = false;
include "db_connection.php";

try
{
    if (!isset($_POST['account']) || !isset($_POST['pwd'])) {
        header("Location: index.php");
        exit();
    }
    if (empty($_POST['account']) || empty($_POST['pwd']))
        throw new Exception('Login Failed!');

    $acc = $_POST['account'];
    $pwd = $_POST['pwd'];
    $query = $connection->prepare("select * from users where account = :acc");
    $query->execute(array('acc' => $acc));

    if ($query->rowCount() == 1)
    {
        $row = $query->fetch();
        if ($row['password'] == hash('sha256', $row['salt'] . $_POST['pwd']))
        {
            $_SESSION['Authenticated'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['account'] = $row['account'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['city'] = $row['city'];

            echo <<<EOT
                <!DOCTYPE html>
                <html>
                    <body>
                        <script>
                            alert("Login Success!");
                            window.location.replace("userPage.php");
                        </script>
                    </body>
                </html>
            EOT;
            exit();
        }
        else
            throw new Exception('Login Failed!');
    }
    else
        throw new Exception('Login Failed!');
}

catch(Exception $e)
{
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
