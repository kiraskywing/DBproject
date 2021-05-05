<?php
session_start();

$_SESSION['Authenticated']=false;

$dbservername='localhost';
$dbname='NCTU_maskOrderDB';
$dbusername='root';
$dbpassword='';

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
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    # set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
    $stmt=$conn->prepare("select account, password, salt from users where account=:acc");
    $stmt->execute(array('acc' => $acc));

    if ($stmt->rowCount()==1)
    {
        $row = $stmt->fetch();
        if ($row['password'] == hash('sha256', $row['salt'].$_POST['pwd']))
        {
            $_SESSION['Authenticated']=true;
            $_SESSION['account']=$row[0];
            // header("Location: list.php?page=1");
            header("Location: userPage.php");
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
