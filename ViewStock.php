<?php 
require_once('includes/connection.php'); 
session_start();

// This is checking if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
include('includes/header.php'); 


$officerID = $_SESSION['userID'];
$query = "SELECT OfficerID, CenterID, FName, LName FROM AGRICULTURAL_OFFICER WHERE OfficerID = '{$officerID}' LIMIT 1";

$result = mysqli_query($conn, $query);

if ($recordRow = mysqli_fetch_assoc($result)) {
    $userOfficerID = $recordRow['OfficerID'];
    $userCenterID = $recordRow['CenterID'];
    $userFName = $recordRow['FName'];
    $userLName = $recordRow['LName'];

    $msgViewUser = "Login as {$userOfficerID} - {$userFName} {$userLName} under Center - {$userCenterID}";
}
?>
    <h1>Store Info</h1>
    <h4><?php echo $msgViewUser ?></h4><hr>

    <form action="ViewStock.php" method = "post">

    </form>
   
    <table>
       <thead>
            <tr>
                <th>FertilizerID</th>
                <th>Description</th>
    			<th>QtyOnHand</th>			
    			<th>StoredDate</th>
    			<th>ExpireDate</th>
    		</tr>
    	</thead>
        
        <tbody>

            <?php
                
                $officerid = $_SESSION['userID'] ;

                $query = "SELECT FertilizerID , Description, QtyOnHand , StoredDate , ExpireDate  FROM fertilizer_management.stores fm join fertilizer f USING(FertilizerID) where  CenterID = (SELECT CenterID FROM fertilizer_management.agricultural_officer where OfficerID = '{$officerid}')";


                $result = $conn -> query($query);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

            ?>

            <tr>
                <td><?php echo $row["FertilizerID"]; ?></td>
                <td><?php echo $row["Description"]; ?></td>
                <td><?php echo $row["QtyOnHand"]; ?></td>
                <td><?php echo $row["StoredDate"]; ?></td>
                <td><?php echo $row["ExpireDate"]; ?></td>
            </tr>
          
            <?php
                    }
            
                } else {
                    echo "0 results";
                }

            ?>

       </tbody>
    </table>

<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>