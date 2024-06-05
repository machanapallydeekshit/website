<?php
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        if(isset($_POST['admin'])){
            header('Location: ../website/admin/admin.php');
        }else{
            header('Location: ../website/gatepass/gatepass.php');
        }
    }
?>

<html>
    <head></head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER[ 'PHP_SELF' ]) ?>" method="post">
            <h2></h2>
            
            <input type="submit" name="admin" value="click here  for admin login">
            
            <input type="submit" name="gatepass" value="Click here for gatepass login">
           
        </form>
    </body>
</html>