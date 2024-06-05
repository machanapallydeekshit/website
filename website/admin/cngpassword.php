<?php
    include("../db/database.php");
    session_start();

// Assuming the user ID is stored in the session after login
$username = $_SESSION['username'];
    


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $current_password = $_POST['opassword'];
    $new_password = $_POST['npassword'];
    $confirm_password = $_POST['cpassword'];

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
    } else {
        // Fetch the current password from the database
        $sql = "SELECT password FROM admin WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $sql = "UPDATE admin SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_hashed_password, $username);

            if ($stmt->execute()) {
                echo "Password changed successfully.";
            } else {
                echo "Error updating password.";
            }

            $stmt->close();
        } else {
            echo "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER[ 'PHP_SELF' ]) ?>" method="post">
            <h2>change password</h2>
            Enter Old password:
            <input type="passowrd" name="opassword"><br>
            Enter new Password:
            <input type="password" name="npassword"><br>
            Confirm new Password:
            <input type="password" name="cpassword"><br>
            <input type="submit" name="change" value="Change">

        </form>
    </body>
</html>
