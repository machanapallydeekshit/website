<?php
include("../db/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passnumber= rand(111111,999999);
    $letterno = $_POST['letterno'];
    $firmname = $_POST['firmname'];
    $vname =$_POST['vname'];
    $vdesignation = $_POST['vdesignation'];
    $oname =$_POST['oname'];
    $odesignation = $_POST['odesignation'];
    $osection = $_POST['osection'];
    $description =$_POST['description'];
    $fdate = $_POST['fdate'];
    $ftime =$_POST['ftime'];
    $tdate = $_POST['tdate'];
    $ttime = $_POST['ttime'];
    
    
    if(empty($letterno)){
        echo "Please enter Letter no";
    }else if (empty($oname)) {
        echo "please enter offcier name to visit ";
    }else if (empty($firmname)) {
        echo "please enter name of firm ";
    }else if (empty($vname)) {
        echo "please enter visitors name ";
    }else if (empty($vdesignation)) {
        echo "please enter visitor designation ";
    }else if (empty($odesignation)) {
        echo "please enter offcier designation ";
    }else if (empty($osection)) {
        echo "please enter offcier section ";
    }else if (empty($description)) {
        echo "please enter purpose of visit ";
    }else if (empty($fdate) || empty($ftime) || empty($tdate) || empty($ttime)) {
        echo "Please select date and time ";
    } else {
        
        
        $stmt = $conn->prepare("INSERT INTO visitor (passnumber,letterno,firmname,visitorname,visitordesignation,officername,officerdesignation,officersection,description,fromdate,fromtime,todate,totime) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("issssssssssss",$passnumber,$letterno,$firmname,$vname,$vdesignation,$oname,$odesignation,$osection,$description,$fdate,$ftime,$tdate,$ttime );
        try{
            $stmt->execute();
            echo "sent visitor's permission successfully<br>";
        } catch(Exception $e){
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    
    }
}
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <h2>Visitor Permission Entry From</h2>
        Letter No:
        <input type="text"  name="letterno" ><br>
        Name of the Firm:
        <input type="text" name="firmname"><br>
        Visitors Name:
        <input type="text" name="vname"><br>
        Visitor Designation:
        <input type="text" name="vdesignation"><br>
        Officer Name to visit:
        <input type="text" name="oname"><br>
        Officer Designation:
        <input type="text" name="odesignation"><br>
        OfficerSection:
        <input type="text" name="osection"><br>
        <label for="textarea">Purpose of Visit:</label>
        <textarea id="textarea"name="description">enter here </textarea><br>
        Permission From:
        <input type="date" name="fdate"><input type="time" name="ftime">To<input type="date" name="tdate"><input type="time" name="ttime"><br>
        <input type="submit" name="submit" value="submit"><br>
    </form>

</body>
</html>
