<?php 
require_once('includes/connection.php'); 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page
    exit;
}
include('includes/header.php');


$officerID = $_SESSION['userID'];
$query = "SELECT OfficerID, CenterID, FName, LName FROM AGRICULTURAL_OFFICER WHERE OfficerID = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $officerID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($recordRow = mysqli_fetch_assoc($result)) {
        $userOfficerID = $recordRow['OfficerID'];
        $userCenterID = $recordRow['CenterID'];
        $userFName = $recordRow['FName'];
        $userLName = $recordRow['LName'];

        $msgViewUser = "Login as {$userOfficerID} - {$userFName} {$userLName} under Center - {$userCenterID}";
    } else {
        $msgViewUser = "User details not found.";
    }
    mysqli_stmt_close($stmt);
}

function getAllFarmers($conn) {
    $query = "SELECT FarmerID, FName, LName, Address, TelNo, NIC FROM FARMER";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

    return $result; // Ensure it returns a mysqli_result object
}

// Update Farmer
if (isset($_POST['btn_update'])) {
    $farmerID = $_POST['txtFarmerID'];
    $firstName = $_POST['txtFirstName'];
    $lastName = $_POST['txtLastName'];
    $address = $_POST['txtAddress'];
    $telNo = $_POST['txtTelNo'];
    $NIC = $_POST['txtNIC'];
    $farmerPass = $_POST['txtFarmerPass'];

    $query = "UPDATE FARMER SET FName = ?, LName = ?, Address = ?, TelNo = ?, NIC = ?, Password = ? WHERE FarmerID = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $address, $telNo, $NIC, $farmerID, $farmerPass);
        $result = mysqli_stmt_execute($stmt);

        $msg2 = $result ? "Record updated successfully" : "Failed updating the record";
        mysqli_stmt_close($stmt);
    }
}

// Insert New Farmer
if (isset($_POST['btn_save'])) {
    $farmerID = $_POST['txtFarmerID'];
    $firstName = $_POST['txtFirstName'];
    $lastName = $_POST['txtLastName'];
    $address = $_POST['txtAddress'];
    $telNo = $_POST['txtTelNo'];
    $NIC = $_POST['txtNIC'];
    $farmerPass = $_POST['txtFarmerPass'];


    $query = "INSERT INTO FARMER (FarmerID, FName, LName, Address, TelNo, NIC, Password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $farmerID, $firstName, $lastName, $address, $telNo, $NIC, $farmerPass);
        $result = mysqli_stmt_execute($stmt);

        $msg2 = $result ? "New farmer added successfully" : "Failed adding new record";
        mysqli_stmt_close($stmt);
    }
}

// Generate New Farmer ID
if (isset($_POST['btnAddNew'])) {
    $query = "SELECT FarmerID FROM FARMER ORDER BY FarmerID DESC LIMIT 1";
    $result_set = mysqli_query($conn, $query);

    if ($record = mysqli_fetch_assoc($result_set)) {
        $farmerID = $record['FarmerID'];
        $farmerID = "F" . str_pad(((int)substr($farmerID, 1) + 1), 3, '0', STR_PAD_LEFT);
    } else {
        $farmerID = "F001";
    }
}

// Search Farmer by NIC
if (isset($_POST['btnSearchID'])) {
    $NIC = $_POST['txtNIC'];

    $query = "SELECT * FROM FARMER WHERE NIC = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $NIC);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($record = mysqli_fetch_assoc($result)) {
            $farmerID = $record['FarmerID'];
            $firstName = $record['FName'];
            $lastName = $record['LName'];
            $address = $record['Address'];
            $telNo = $record['TelNo'];
            $farmerPass = $record['Password'];
        } else {
            $msg1 = "No such Farmer ID exists";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
    <form action="Farmers.php" method = "post">

        <h1>View Farmer Info</h1>
        <h4><?php echo $msgViewUser ?></h4><hr>
    
        <table>

            <tr>
                <td>NIC No : </td>
                <td>
                    <input type="text" name = "txtNIC" value = "<?php echo (isset($NIC)) ? $NIC : ''; ?>"></input>
                    <button name="btnSearchID" type="submit" value="HTML">SEARCH</button>
                    <label for="lblMsg1"><b><?php echo (isset($msg1)) ? $msg1 : ''; ?></b></label>
                </td>
            </tr>
            <tr>
                <td>Farmer ID : </td>
                <td>
                    <input type="text" name = "txtFarmerID" value = "<?php echo (isset($farmerID)) ? $farmerID : ''; ?>"></input>
                    <button name="btnAddNew" type="submit" value="HTML">ADD NEW</button>
                </td>
            </tr>
            <tr>
                <td>First Name : </td>
                <td><input type="text" name="txtFirstName" value = "<?php echo (isset($firstName)) ? $firstName : ''; ?>"></input></td>
            </tr>
            <tr>
                <td>Last Name : </td>
                <td><input type="text" name = "txtLastName" value = "<?php echo (isset($lastName)) ? $lastName : ''; ?>"></input></td>
            </tr>
            <tr>
                <td>Address : </td>
                <td><input type="text" name = "txtAddress" value = "<?php echo (isset($address)) ? $address : ''; ?>"></input></td>
            </tr>
            <tr>
                <td>Tel No : </td>
                <td><input type="text" name = "txtTelNo" value = "<?php echo (isset($telNo)) ? $telNo : ''; ?>"></input></td>
            </tr>
            <tr>
                <td>Password : </td>
                <td><input type="password" name = "txtFarmerPass" value = "<?php echo (isset($farmerPass)) ? $farmerPass : ''; ?>"></input></td>
            </tr>
            
            <tr>
                <td> 
                </td>
            
                <td>
                    <button name="btn_update" type="submit" value="HTML">UPDATE</button>
                    <button name="btn_save" type="submit" value="HTML">SAVE NEW</button>
                    <label for="lblMsg2"><b><?php echo (isset($msg2)) ? $msg2 : ''; ?></b></label>
                </td>
            </tr>
            
        </table>

	</form> 


    <div>
    <h1>All Farmers</h1>
    <hr>


    <?php
    $farmers = getAllFarmers($conn);

    if ($farmers && mysqli_num_rows($farmers) > 0) {
        echo '<table>';
        echo '<tr><th>Farmer ID</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Tel No</th><th>NIC</th></tr>';
        while ($row = mysqli_fetch_assoc($farmers)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['FarmerID']) . '</td>';
            echo '<td>' . htmlspecialchars($row['FName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['LName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Address']) . '</td>';
            echo '<td>' . htmlspecialchars($row['TelNo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['NIC']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No farmers found.</p>';
    }
    ?>
</div>


<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>