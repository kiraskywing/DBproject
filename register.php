<?php
session_start();
$_SESSION['Authenticated']=false;

$dbservername='localhost';
$dbname='NCTU_examdb';
$dbusername='root';
$dbpassword='';

try 
{
    if (!isset($_POST['uname']) || !isset($_POST['pwd'])) 
    {
        header("Location: index.php");
        exit();
    }
    if (empty($_POST['uname']) || empty($_POST['pwd']))
        throw new Exception('Please input user name and password.');

    $uname=$_POST['uname'];
    $pwd=$_POST['pwd'];
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    # set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt=$conn->prepare("select username from users where username=:username");
    $stmt->execute(array('username' => $uname));

    if ($stmt->rowCount()==0) 
    {
        $salt=strval(rand(1000,9999));
        
        $hashvalue=hash('sha256', $salt.$pwd);
        $stmt=$conn->prepare("insert into users (username, password, salt) values (:username, :password, :salt)");
        $stmt->execute(array('username' => $uname, 'password' => $hashvalue, 'salt' => $salt));
        
        echo <<<EOT
            <!DOCTYPE html>
            <html>
                <body>
                    <script>
                        alert("Create an account successfully. Please log in.");
                        window.location.replace("index.php");
                    </script>
                </body>
            </html>
        EOT;
        exit();
    }
    else
        throw new Exception("Login failed.");
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
</body>
</html>