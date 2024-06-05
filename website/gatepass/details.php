<!DOCTYPE html>
<html>
<head>
    <title>Visitor Details</title>
</head>
<body>
    <div >
        <?php
        session_start();
        include('../db/database.php'); // Include the database connection file
        date_default_timezone_set('Asia/Kolkata'); // Set to your desired timezone

        if (isset($_GET['passnumber'])) {
            $passnumber = intval($_GET['passnumber']);
            $sql = "SELECT * FROM visitor WHERE passnumber = '$passnumber'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <h2>Visitor Pass Entry Form</h2>
                <form action="<?php echo htmlspecialchars($_SERVER[ 'PHP_SELF' ]) ?>" method="post">
                    <div>
                        <label for="passnumber">Pass No:</label>
                        <input type="text" id="passnumber" name="passnumber" value="<?php echo htmlspecialchars($row["passnumber"]); ?>" readonly>
                    </div>
                    <div>
                    <label for="options">Pass Type :</label>
                    <select id="options" name="options">
                    <option value="admin">ADMIN</option>
                    <option value="security">Security</option>
                    </select>
                    </div>
                    <div>
                        <label for="oname">Officer Name to Visit:</label>
                        <input type="text" id="oname" name="oname" value="<?php echo htmlspecialchars($row["officername"]); ?>" readonly>
                    </div>
                    <div>
                        <label for="odesignation">Officer Designation:</label>
                        <input type="text" id="odesignation" name="odesignation" value="<?php echo htmlspecialchars($row["officerdesignation"]); ?>"readonly>
                    </div>
                    <div>
                        <label for="osection">Officer section:</label>
                        <input type="text" id="osection" name="osection" value="<?php echo htmlspecialchars($row["officersection"]); ?>" readonly>
                    </div>
                    <div>
                        <label for="letterno">Authority Letter No</label>
                        <input type="text" id="letterno" name="letterno" value="<?php echo htmlspecialchars($row["letterno"]); ?>"readonly>
                    </div>
                    <div>
                        <label for="vname">Visitor Name:</label>
                        <input type="text" id="vname" name="vname" value="<?php echo htmlspecialchars($row["visitorname"]); ?>"readonly>
                    </div>
                    <div>
                        <label for="vdesignation">Visitor Designation:</label>
                        <input type="text" id="vdesignation" name="vdesignation" value="<?php echo htmlspecialchars($row["visitordesignation"]); ?>" readonly>
                    </div>
                    <div>
                        <label for="sex">Sex:</label>
                        <select id="sex" name="sex">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileno">Visitor Mobile No:</label>
                        <input type="text" id="mobileno" name="mobileno" >
                    </div>
                    <div>
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location">
                    </div>
                    <div>
                        <label for="edt">Entry Date&Time:</label>
                        <input type="text" id="edt" name="edt" value="<?php echo htmlspecialchars(date('Y-m-d H:i:s')); ?>" readonly>
                    </div>
                    <div>
                        <label for="exdt">Exit Date&time</label>
                        <input type="text" id="exdt" name="exdt" value="<?php echo htmlspecialchars(date( 'Y-m-d H:i:s',strtotime('+1 day'))); ?>">

                    </div>
                    <div>
                        <label for="fileInput">Photo:</label>
                        <input type="file" id="fileInput" name="image" accept="image/*" required>
                        <button type="button" id="resetImageButton">Reset Image</button>
                    </div>
                    <input type="submit" name="save" value="save">
                    <button onclick="window.print()">print</button>
                </form>
                <script>
                // Get elements
                const fileInput = document.getElementById('fileInput');
                const resetImageButton = document.getElementById('resetImageButton');

                // Clear file input on reset button click
                resetImageButton.addEventListener('click', function() {
                fileInput.value = '';
                });
                </script>
                <?php
            } else {
                echo "<p>No details found for this visitor.</p>";
            }
        } else {
            echo "<p>Invalid visitor ID.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
<?php
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        $passtype =$_POST['options'];
        $oname =$_POST['oname'];
        $odesignation = $_POST['odesignation'];
        $osection = $_POST['osection'];
        $letterno =$_POST['letterno'];
        $vname= $_POST['vname'];
        $vdesignation = $_POST['vdesignation'];
        $sex =$_POST['sex'];
        $vnumber= $_POST['mobileno'];
        $location = $_POST['location'];
        $edt =$_POST['edt'];
        $exdt= $_POST['exdt'];

        if(isset($_POST['save'])){

            $stmt = $conn->prepare("INSERT INTO visited (passnumber,officername,officerdesignation,officersection,letterno,visitorname,visitordesignation,sex,visitormobileno,location,entrydatetime,exitdatetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("isssssssssss", $passnumber,$oname,$odesignation,$osection,$letterno,$vname,$vdesignation,$sex,$vnumber,$location,$edt,$exdt);
    
            // Execute the statement
            if ($stmt->execute()) {
                echo "File successfully saved : " . htmlspecialchars(basename($_FILES['image']['name']));
            } else {
                echo "Error saving file.";
            }
    
            // Close the statement
            $stmt->close();
        }
    }

?>