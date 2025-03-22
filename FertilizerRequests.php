<?php 
require_once('includes/connection.php'); 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page
    exit;
}

$farmerId = $_SESSION['userID'];
$query = "SELECT FarmerID, Address, FName, LName, NIC, TelNo FROM FARMER WHERE FarmerID = ? LIMIT 1";
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

<div>
    <h1>My Fertilizer Requests</h1>
    <hr>

    <?php
    $query = "SELECT FR.requestId, FR.farmerId, FR.landId, FR.fertilizerId, FR.amountRequested, FR.requestDate, 
                     F.Description AS fertilizerName, C.CropName 
              FROM FertilizerRequest FR 
              JOIN FERTILIZER F ON FR.fertilizerId = F.FertilizerID 
              JOIN CULTIVATION C ON FR.landId = C.LandID 
              WHERE FR.farmerId = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $farmerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>Request ID</th><th>Land ID</th><th>Crop Name</th><th>Fertilizer ID</th><th>Fertilizer Name</th><th>Amount Requested</th><th>Request Date</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['requestId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['landId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['CropName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['fertilizerId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['fertilizerName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['amountRequested']) . '</td>';
                echo '<td>' . htmlspecialchars($row['requestDate']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No fertilizer requests found.</p>';
        }
        mysqli_stmt_close($stmt);
    }
    ?>
</div>

<?php include('includes/footer.php'); ?>
<?php mysqli_close($conn); ?>
