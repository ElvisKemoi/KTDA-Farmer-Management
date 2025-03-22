<?php 
require_once('includes/connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}
    $farmerId = $_SESSION['userID'];
  
    $query = "SELECT FarmerID, Address, FName, LName FROM Farmer WHERE FarmerID = '{$farmerId}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($recordRow = mysqli_fetch_assoc($result)) {

        $userFarmerID = $recordRow['FarmerID'];
        $userFarmerAddress = $recordRow['Address'];
        $userFName = $recordRow['FName'];
        $userLName = $recordRow['LName'];
        $msg1 = $recordRow['FName'] ." " .$recordRow['LName'];


        $msgViewUser = "Login as {$userFarmerID} - {$userFName} {$userLName} From - {$userFarmerAddress}";

    }

    $farmerID = $farmerId;
    
    $query1 = "SELECT FName, LName FROM FARMER WHERE FarmerID = '{$farmerID}' LIMIT 1";
    $query2 = "SELECT LandID FROM CULTIVATION WHERE FarmerID = '{$farmerID}' ";

    $result1 = mysqli_query($conn, $query1);

    if ($record = mysqli_fetch_assoc($result1)) {

        $msg1 = $record['FName'] . " " . $record['LName'];

        $result2 = mysqli_query($conn, $query2);

    } else {
        $msg1 = "No such FarmerID exists";
    }
        

    if (isset($_POST['btnBrowseLand'])) {

        $LandID = $_POST['listLandIDs'];

        $query1 = "SELECT * FROM CULTIVATION WHERE LandID = '{$LandID}' LIMIT 1";

        $result3 = mysqli_query($conn, $query1);

        if ($recordCult = mysqli_fetch_assoc($result3)) {

            $landID = $recordCult['LandID'];
            $cropName = $recordCult['CropName'];
            $landArea = $recordCult['LandArea'];
            $month = $recordCult['Month'];

        }
    }

    if (isset($_POST['txtLandID'])) {

        $chsLandID = $_POST['txtLandID'];
    
        $query1 = "SELECT * FROM CULTIVATION WHERE LandID = '{$chsLandID}' LIMIT 1";
        $query2 = "SELECT * FROM FERTILIZER 
                   WHERE FertilizerID = ANY 
                   (SELECT FertilizerID FROM STORES)";
    
        $result3 = mysqli_query($conn, $query1);
        $result4 = mysqli_query($conn, $query2);
    
        if ($recordCult = mysqli_fetch_assoc($result3)) {
            $chsLandID = $recordCult['LandID'];
            $chsCropName = $recordCult['CropName'];
            $chsLandArea = $recordCult['LandArea'];
            $chsMonth = $recordCult['Month'];
        }
    }
    
    if (isset($_POST['btnBrowseFertilizer'])) {

        $fertilizerName = $_POST['listFertilizers'];
    
        $query = "SELECT a.FertilizerID, a.Description, b.QtyOnHand, b.ExpireDate 
                  FROM FERTILIZER a 
                  JOIN STORES b ON a.FertilizerID = b.FertilizerID 
                  WHERE a.FertilizerID = (SELECT FertilizerID FROM FERTILIZER WHERE Description = '{$fertilizerName}')";
    
        $result5 = mysqli_query($conn, $query);
    
        if ($record = mysqli_fetch_assoc($result5)) {
            $fertilizerID = $record['FertilizerID'];
            $description = $record['Description'];
            $expireDate = $record['ExpireDate'];
            $qtyOnHand = $record['QtyOnHand'];
        }
    }
    

    /////////////////////////////////////////////////


    if (isset($_POST['txtFerilizerID'])) {

        $chsFertilizerID = $_POST['txtFerilizerID'];
    
        $query = "SELECT a.FertilizerID, a.Description, b.QtyOnHand, b.ExpireDate 
                  FROM FERTILIZER a 
                  JOIN STORES b ON a.FertilizerID = b.FertilizerID 
                  WHERE a.FertilizerID = '{$chsFertilizerID}'";
    
        $result6 = mysqli_query($conn, $query);
    
        if ($record = mysqli_fetch_assoc($result6)) {
            $chsFertilizerID = $record['FertilizerID'];
            $chsDescription = $record['Description'];
            $chsExpireDate = $record['ExpireDate'];
            $chsQtyOnHand = $record['QtyOnHand'];
        }
    }
    
    //////////////////////////////////////////////////////////////////////////
    if (isset($_POST['btnSave'])) {
        // Capture form data
        $farmerID = $farmerId;
        $landID = $_POST['txtLandID'];
        $fertilizerID = $_POST['txtFerilizerID'];
        $amount = $_POST['txtAmount'];
        $currentDate = date('Y-m-d');
    
        // Insert request into FertilizerRequest table
        $query = "INSERT INTO FertilizerRequest (farmerId, landId, fertilizerId, amountRequested, requestDate) 
                  VALUES (?, ?, ?, ?, ?)";
    
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssds", $farmerID, $landID, $fertilizerID, $amount, $currentDate);
    
        if (mysqli_stmt_execute($stmt)) {
            $msg2 = "Fertilizer request submitted successfully";
        } else {
            $msg2 = "Failed to submit request";
        }
    
        // Close the statement
        mysqli_stmt_close($stmt);
    }
    
?>



<?php include('includes/farmerHeader.php'); ?>
    
    <form action="FarmerIssueFertilizer.php" method = "post">

        <h1>Fertilizer Issuing | Request</h1>
        <h4><?php echo $msgViewUser ?></h4><hr>
    
        <table>

           

            <tr>
                <td>Browse what Land to be Selected : </td>
                <td>
                    <select name = "listLandIDs" style="width: 150px;">
                        <?php
                        
                        // Iterating through the product array
                        while($recordLands = mysqli_fetch_assoc($result2)){
                        ?>
                            <option value="<?php echo $recordLands['LandID']; ?>"><?php echo $recordLands['LandID']; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <button name="btnBrowseLand" type="submit" value="HTML">BROWSE</button>

                    <label for="lblLandID"><b><?php echo (isset($landID)) ? $landID : ''; ?></b></label>                    

                    <label for="lblCropName"><b><?php echo (isset($cropName)) ? $cropName : ''; ?></b></label>

                    <label for="lblLandArea"><b><?php echo (isset($landArea)) ? $landArea . "  ha" : ''; ?></b></label>

                    <label for="lblMonth"><b><?php echo (isset($month)) ? $month : ''; ?></b></label>
                </td>

            </tr>

            <tr>
                <td>Enter Land ID: </td>

                <td>
                    <input type="text" name = "txtLandID" value = "<?php echo (isset($chsLandID)) ? $chsLandID : ''; ?>"></input>
                    <button name="btnSubmitLandID" type="submit" value="HTML">SUBMIT</button>
                    
                </td>
            </tr>

            <tr>
                <td>Land ID : </td>
                <td><label for="lblChsLandID"><b><?php echo (isset($chsLandID)) ? $chsLandID : ''; ?></b></label></td>
            </tr>
            <tr>
                <td>Crop Name : </td>
                <td><label for="lblChsCropName"><b><?php echo (isset($chsCropName)) ? $chsCropName : ''; ?></b></label></td>
            </tr>
            <tr>
                <td>Land Area : </td>
                <td><label for="lblChsLandArea"><b><?php echo (isset($chsLandArea)) ? $chsLandArea . "  ha" : ''; ?></b></label></td>
            </tr>
            <tr>
                <td>Month : </td>
                <td><label for="lblChsMonth"><b><?php echo (isset($chsMonth)) ? $chsMonth : ''; ?></b></label></td>
            </tr>
            
            <tr>
                <td>Browse what Fertilizer to be selected : </td>
                <td>
                    <select name = "listFertilizers" style="width: 150px;">
                        <?php
                        
                        // Iterating through the product array
                        while($recFertilizer = mysqli_fetch_assoc($result4)){
                        ?>
                            <option value="<?php echo $recFertilizer['Description']; ?>"><?php echo $recFertilizer['Description']; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <button name="btnBrowseFertilizer" type="submit" value="HTML">BROWSE</button>

                    <label for="lblFertilizerID"><b><?php echo (isset($fertilizerID)) ? $fertilizerID : ''; ?></label>

                    <label for="lblDescription"><b><?php echo (isset($description)) ? $description : ''; ?></label>

                    <label for="lblExpireDate"><b><?php echo (isset($expireDate)) ? $expireDate : ''; ?></label>

                    <label for="lblQtyOnHand"><b><?php echo (isset($qtyOnHand)) ? $qtyOnHand . "  kgs" : ''; ?></label>
                </td>

            </tr>
            
            <tr>
                <td>Fertilizer ID : </td>
                <td>
                    <input type="text" name = "txtFerilizerID" value = "<?php echo (isset($chsFertilizerID)) ? $chsFertilizerID : ''; ?>"></input>
                    <button name="btnSubmitFertilizerID" type="submit" value="HTML">SUBMIT</button>    
                </td>
            </tr>

            <tr>
                <td>Fertilizer ID : </td>
                <td><label for="lblChsFertilizerID"><b><?php echo (isset($chsFertilizerID)) ? $chsFertilizerID : ''; ?></b></label></td>
            </tr>

            <tr>
                <td>Description : </td>
                <td><label for="lblChsDescription"><b><?php echo (isset($chsDescription)) ? $chsDescription : ''; ?></b></label></td>
            </tr>

            <tr>
                <td>Date of Expiry : </td>
                <td><label for="lblChsExpireDate"><b><?php echo (isset($chsExpireDate)) ? $chsExpireDate : ''; ?></b></label></td>
            </tr>

            <tr>
                <td>Qty on Hand : </td>
                <td><label for="lblChsQtyOnHand"><b><?php echo (isset($chsQtyOnHand)) ? $chsQtyOnHand . "  kgs": ''; ?></b></label></td>
            </tr>

            <tr>
                <td>Amount(Kgs) : </td>
                <td>
                    <input type="text" name = "txtAmount" value = "<?php echo (isset($amount)) ? $amount : ''; ?>"></input>
                    <button name="btnSave" type="submit" value="HTML">SAVE</button>
                    <label for="lblSaveMsg"><b><?php echo (isset($msg2)) ? $msg2 : ''; ?></b></label>
                </td>
            </tr>
            
        </table>

	</form> 

<?php include('includes/footer.php'); ?>

</body>
</html>

<?php mysqli_close($conn); ?>