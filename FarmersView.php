<?php 
require_once('includes/connection.php'); 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$farmerId = $_SESSION['userID'];
$query = "SELECT FarmerID, Address, FName, LName, NIC, TelNo FROM Farmer WHERE FarmerID = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $farmerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($recordRow = mysqli_fetch_assoc($result)) {
        $userFarmerId = $recordRow['FarmerID'];
        $userAddress = $recordRow['Address'];
        $userFName = $recordRow['FName'];
        $userLName = $recordRow['LName'];
        $userNIC = $recordRow['NIC'];
        $userTelNo = $recordRow['TelNo'];

        $msgViewUser = "Login as {$userFarmerId} - {$userFName} {$userLName} from - {$userAddress}";
    } else {
        $msgViewUser = "User details not found.";
    }
    mysqli_stmt_close($stmt);
}
// Update Farmer
if (isset($_POST['btn_update'])) {
    $farmerID = $_POST['txtFarmerID'];
    $firstName = $_POST['txtFirstName'];
    $lastName = $_POST['txtLastName'];
    $address = $_POST['txtAddress'];
    $telNo = $_POST['txtTelNo'];
    $farmerPass = $_POST['txtFarmerPass'];

    if (empty($farmerPass)) {
        // Update without changing the password
        $query = "UPDATE FARMER SET FName = ?, LName = ?, Address = ?, TelNo = ? WHERE FarmerID = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $address, $telNo, $farmerID);
        }
    } else {
        // Update including the password change
        $query = "UPDATE FARMER SET FName = ?, LName = ?, Address = ?, TelNo = ?, Password = ? WHERE FarmerID = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            // Hash the password before storing it
            $hashedPassword = $farmerPass;
            // $hashedPassword = password_hash($farmerPass, PASSWORD_BCRYPT);
            
            mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $address, $telNo, $hashedPassword, $farmerID);
        }
    }

    // Execute the query if prepared successfully
    if ($stmt) {
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $msg2 = "Record updated successfully";
        } else {
            $msg2 = "Failed updating the record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

?>

<?php include('includes/farmerHeader.php'); ?>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
 
<style>
    
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

</style>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <h1>My Information</h1>
    <h4><?php echo $msgViewUser; ?></h4><hr>

    <table>
        <tr>
            <td>NIC No: </td>
            <td>
                <input type="text" name="txtNIC" value="<?php echo isset($userNIC) ? $userNIC : ''; ?>" />
                <label for="lblMsg1"><b><?php echo isset($msg1) ? $msg1 : ''; ?></b></label>
            </td>
        </tr>
        <tr>
            <td>My Farmer ID: </td>
            <td>
                <input type="text" name="txtFarmerID" value="<?php echo isset($userFarmerId) ? $userFarmerId : ''; ?>" />
            </td>
        </tr>
        <tr>
            <td>First Name: </td>
            <td><input type="text" name="txtFirstName" value="<?php echo isset($userFName) ? $userFName : ''; ?>" /></td>
        </tr>
        <tr>
            <td>Last Name: </td>
            <td><input type="text" name="txtLastName" value="<?php echo isset($userLName) ? $userLName : ''; ?>" /></td>
        </tr>
        <tr>
            <td>Address: </td>
            <td><input type="text" name="txtAddress" value="<?php echo isset($userAddress) ? $userAddress : ''; ?>" /></td>
        </tr>
        <tr>
            <td>Tel No: </td>
            <td><input type="text" name="txtTelNo" value="<?php echo isset($userTelNo) ? $userTelNo : ''; ?>" /></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="txtFarmerPass" value="" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button name="btn_update" type="submit">UPDATE</button>
                <label for="lblMsg2"><b><?php echo isset($msg2) ? $msg2 : ''; ?></b></label>
            </td>
        </tr>

    </table>

</form>

<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>
