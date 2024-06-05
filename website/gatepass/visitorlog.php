<?php
    include('../db/database.php');
    session_start();

?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <h2>Visitor Details</h2>
    <table border="1">
        <thead>
            <tr>
                <th>S.no</th>
                <th>Visitor Name</th>
                <th>Designation</th>
                <th>Generate pass</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT passnumber,visitorname, visitordesignation FROM visitor";
            $result = $conn->query($sql);
            $sno = 1;

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $sno . "</td>";
                    echo "<td>" . $row["visitorname"] . "</td>";
                    echo "<td>" . $row["visitordesignation"] . "</td>";
                    echo "<td><a href='details.php?passnumber=" . $row["passnumber"] . "'>Details</a></td>";
                    echo "</tr>";
                    $sno++;
                }
            } else {
                echo "<tr><td colspan='4'>No visitors found</td></tr>";
            }

            $conn->close();
            ?>
            
        </tbody>
    </table>
</body>
</html>