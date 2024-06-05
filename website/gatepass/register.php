<?php
include("../db/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $mobileno = $_POST['mobileno'];
    $address = $_POST['address'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $npassword = $_POST['npassword'];
    $rpassword = $_POST['rpassword'];
    $userid = rand(1111111, 9999999);
    
    if(empty($npassword)){
        echo "Please enter new password";
    }else if ($npassword !== $rpassword) {
        echo "Password does not match";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
        }else{
        $password = password_hash($npassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO gatepass (id,password,name,age,gender,email,mobileno,address,designation,department) 
                        VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssssss", $userid, $password, $name, $age, $gender, $email, $mobileno, $address, $designation, $department);
        try{
            $stmt->execute();
            echo "you are registered successfully<br>";
            echo "Your userid is: $userid<br>";
        } catch(Exception $e){
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    }
}
?>
<!DOCTYPE html>
<html>

<head></head>

<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <h2>Gatepass Register</h2>
        Name:
        <input type="text" name="name"><br>
        Age:
        <input type="number" name="age"><br>
        Gender:
        <input type="text" name="gender"><br>
        Email:
        <input type="email" name="email"><br>
        Mobile NO:
        <input type="number" name="mobileno"><br>
        Address:
        <input type="text" name="address"><br>
        Designation:
        <input type="text" name="designation"><br>
        Department:
        <input type="text" name="department"><br>
        Enter new password:
        <input type="password" name="npassword"><br>
        Re-Enter new password:
        <input type="password" name="rpassword"><br>
        <a href="../gatepass/gatepass.php">back to login</a>
        <input type="submit" name="register" value="Register"><br>
    </form>

</body>

</html>
