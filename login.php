<?php
session_start();

$_SESSION['Authenticated']=false;
include "db_connection.php";

try
{
    if (!isset($_POST['account']) || !isset($_POST['pwd']))
    {
        header("Location: index.php");
        exit();
    }
    if (empty($_POST['account']) || empty($_POST['pwd']))
        throw new Exception('Please input user name and password.');

    $acc=$_POST['account'];
    $pwd=$_POST['pwd'];
    $stmt=$connection->prepare("select user_id, account, password, salt, phone_number, full_name, city from users where account=:acc");
    $stmt->execute(array('acc' => $acc));

    if ($stmt->rowCount()==1)
    {
        $row = $stmt->fetch();
        if ($row['password'] == hash('sha256', $row['salt'].$_POST['pwd']))
        {
            $_SESSION['Authenticated']=true;
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
                            alert("Login success. Redirect the page");
                            window.location.replace("userPage.php");
                        </script>
                    </body>
                </html>
            EOT;
            exit();
        }
        else
            throw new Exception('Login failed.');
    }
    else
        throw new Exception('Login failed.');
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
