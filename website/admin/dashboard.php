<?php
session_start();
     if($_SERVER["REQUEST_METHOD"]== "POST"){
        if(isset($_POST['cpassword'])){
            header("Location: cngpassword.php");

        }else if(isset($_POST['avisitor'])){
            header("Location: addvisitor.php");
        }else{
            
            header("Location: logout.php");
            
        }
     }
?>

<!DOCTYPE html>
<html>

<head></head>

<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <h2>Admin Dashboard</h2>
        <div>click here to change password:<br>
        <input type="submit" name="cpassword" value="Change"><br></div>
        <div>click here to add a visitor:<br>
        <input type="submit" name="avisitor" value="visitor"><br></div>
        <div>click here to logout:<br>
        <input type="submit" name="logout" value="logout"><br></div>
    </form>

</body>

</html>

