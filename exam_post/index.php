<!-- This is a test -->

<?php
    session_start();
    # remove all session variables
    session_unset(); 
    # destroy the session
    session_destroy();
    $_SESSION['Authenticated']=false;
?>

<!DOCTYPE html>
<html>
<body>

<h1 style="color:red">Login</h1>
<form action="login.php" method="post">
    User Name:
    <input type="text" name="uname"><br>
    Password:
    <input type="password" name="pwd"><br>
    <input type="submit" value="Login">
</form>

<h1>Create Account</h1>
<form action="register.php" method="post">
    User Name:
    <input type="text" name="uname" placeholder="user name"><br>
    Password:
    <input type="password" name="pwd"><br>
    <input type="submit" value="Create Account">
</form>

</body>
</html> 
