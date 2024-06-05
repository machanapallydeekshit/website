<?php
    include("../db/database.php");
    session_start();

    function verifyPassword($username, $password, $conn) {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT password FROM gatepass WHERE id = ?");
        $stmt->bind_param("i", $username);
        $stmt->execute();
        $stmt->store_result();
    
        // Check if the user exists
        if ($stmt->num_rows == 1) {
            // Bind result
            $password_hash="";
            $stmt->bind_result($password_hash);
            $stmt->fetch();
    
            // Verify password
            if (password_verify($password, $password_hash)) {
                return true;
            } else {
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }

    if($_SERVER["REQUEST_METHOD"]== "POST"){
        if(isset($_POST['login'])){
            $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
            
            if(empty($username)){
                echo "Username is empty";
            }else if(empty($password)){
                echo "Password is empty";
            }else{
                if (verifyPassword($username, $password, $conn)) {
                    
                    header('Location: dashboard.php');
                    
                    $_SESSION['username']=$username;
                    
                } else {
                    echo "Invalid username or password!";
                }
            }
        }else if(isset($_POST['register'])){
            header('Location: register.php');
        }

    }
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER[ 'PHP_SELF' ]) ?>" method="post">
            <h2 >Gatepass Login</h2>
            Username:
            <input type="text" name="username"><br>
            Password:
            <input type="password" name="password"><br>
            <input class ="login" type="submit" name="login" value="Login">
            <input type="submit" name="register" value="register">
            

        </form>
    </body>
</html>
