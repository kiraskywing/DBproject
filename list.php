<?php
session_start();

$dbservername='localhost';
$dbname='NCTU_examdb';
$dbusername='root';
$dbpassword='';

try
{
    if (!isset($_SESSION['Authenticated']) || $_SESSION['Authenticated'] != true)
    {
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['page']))
        $page=$_GET['page'];
    else
        $page=1;
    
    $postperpage=2;
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt=$conn->prepare("select count(*) from posts");
    $stmt->execute();
    $row=$stmt->fetch();
    $totalpage=ceil($row[0]/$postperpage);
    
    echo <<<EOT
        <!DOCTYPE html>
        <html>
        <body>
            <button type="button" onClick="window.location.replace('index.php');">Logout</button><br>
        EOT;
      
    if ($totalpage > 0)
    {
        for($i = 1; $i <= $totalpage; $i++)
        {
            if ($i == $page)
                echo "$i ";
            else
                echo "<a href='list.php?page=$i'>$i</a> ";
        }
        echo '<br>';
        
        $startrow=($page-1)*$postperpage;
        $stmt=$conn->prepare("select title, content from posts limit $startrow,2");
        $stmt->execute();
        echo '<ul>';
        
        while($row=$stmt->fetch())
            echo '<li> ' . $row['title'] . '<br>' . $row['content'] . '<br><br> </li>';
    }
    echo '</ul></body></html>';
}

catch (PDOException $e)
{
    session_unset(); 
    session_destroy(); 

    echo <<<EOT
        <!DOCTYPE html>
            <html>
                <body>
                <script>
                    alert("Internal Error. $msg");
                    window.location.replace("index.php");
                </script>
                </body>
            </html> 
    EOT;
}
?>
