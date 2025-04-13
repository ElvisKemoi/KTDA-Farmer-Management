<?php 
require_once('includes/connection.php'); 
session_start();

// We have to check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
include('includes/farmerHeader.php');


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
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <h1>My Produce</h1>
    <h4><?php echo $msgViewUser; ?></h4><hr>

    <table border="1">
    <tr>
        <th>Produce ID</th>
        <th>Farmer ID</th>
        <th>Quantity (kg)</th>
        <th>Date Recorded</th>
    </tr>

    <?php
    // Fetch produce records for the logged-in farmer
    $query = "SELECT ProduceID, FarmerID, Quantity, DateRecorded FROM produce WHERE FarmerID = ? ORDER BY DateRecorded DESC";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $farmerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if there are records
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['ProduceID']}</td>
                        <td>{$row['FarmerID']}</td>
                        <td>{$row['Quantity']}</td>
                        <td>{$row['DateRecorded']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No produce records found.</td></tr>";
        }

        mysqli_stmt_close($stmt);
    }
    ?>
</table>


</form>

<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>
