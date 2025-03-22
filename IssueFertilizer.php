<?php 
require_once('includes/connection.php'); 
session_start();

// Check if the user is logged in as an agricultural officer
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'officer') {
    header("Location: login.php");
    exit;
}

$officerId = $_SESSION['userID'];
$query = "SELECT OfficerID, FName, LName, CenterID FROM AGRICULTURAL_OFFICER WHERE OfficerID = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $officerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($recordRow = mysqli_fetch_assoc($result)) {
        $userOfficerId = $recordRow['OfficerID'];
        $userFName = $recordRow['FName'];
        $userLName = $recordRow['LName'];
        $centerId = $recordRow['CenterID'];
    } else {
        die("User details not found.");
    }
    mysqli_stmt_close($stmt);
}

// Handle approval request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $requestId = $_POST['requestId'];
    $landId = $_POST['landId'];
    $fertilizerId = $_POST['fertilizerId'];
    $amountRequested = floatval($_POST['amountRequested']); // Ensure it's a float

    // Check fertilizer stock in officer's center
    $stockQuery = "SELECT QtyOnHand FROM STORES WHERE FertilizerID = ? AND CenterID = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $stockQuery);
    mysqli_stmt_bind_param($stmt, "ss", $fertilizerId, $centerId);
    mysqli_stmt_execute($stmt);
    $stockResult = mysqli_stmt_get_result($stmt);
    $stockRow = mysqli_fetch_assoc($stockResult);

    if ($stockRow && $stockRow['QtyOnHand'] >= $amountRequested) {
        // Deduct from stock
        $updateStockQuery = "UPDATE STORES SET QtyOnHand = QtyOnHand - ? WHERE FertilizerID = ? AND CenterID = ?";
        $stmt = mysqli_prepare($conn, $updateStockQuery);
        mysqli_stmt_bind_param($stmt, "dss", $amountRequested, $fertilizerId, $centerId);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error updating stock: " . mysqli_error($conn));
        }

        // Insert into RECEIVES table
        $issueDate = date('Y-m-d');
        $insertQuery = "INSERT INTO RECEIVES (LandID, FertilizerID, IssueDate, Amount) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sssd", $landId, $fertilizerId, $issueDate, $amountRequested);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error inserting into RECEIVES: " . mysqli_error($conn));
        }

        // Delete the request
        $deleteRequestQuery = "DELETE FROM FertilizerRequest WHERE requestId = ?";
        $stmt = mysqli_prepare($conn, $deleteRequestQuery);
        mysqli_stmt_bind_param($stmt, "i", $requestId);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error deleting request: " . mysqli_error($conn));
        }

        echo "<p>Request approved successfully!</p>";
    } else {
        echo "<p>Insufficient stock in your center to approve this request.</p>";
    }
}
?>


<?php include('includes/header.php'); ?>
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
    <h1>Fertilizer Requests</h1>
    <hr>

    <?php
    $query = "SELECT FR.requestId, FR.farmerId, FR.landId, FR.fertilizerId, FR.amountRequested, FR.requestDate, 
                     F.Description AS fertilizerName, C.CropName 
              FROM FertilizerRequest FR 
              JOIN FERTILIZER F ON FR.fertilizerId = F.FertilizerID 
              JOIN CULTIVATION C ON FR.landId = C.LandID";
    
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>Request ID</th><th>Land ID</th><th>Crop Name</th><th>Fertilizer ID</th><th>Fertilizer Name</th><th>Amount Requested</th><th>Request Date</th><th>Action</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['requestId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['landId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['CropName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['fertilizerId']) . '</td>';
                echo '<td>' . htmlspecialchars($row['fertilizerName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['amountRequested']) . '</td>';
                echo '<td>' . htmlspecialchars($row['requestDate']) . '</td>';
                echo '<td><form method="POST"><input type="hidden" name="requestId" value="' . htmlspecialchars($row['requestId']) . '"><input type="hidden" name="landId" value="' . htmlspecialchars($row['landId']) . '"><input type="hidden" name="fertilizerId" value="' . htmlspecialchars($row['fertilizerId']) . '"><input type="hidden" name="amountRequested" value="' . htmlspecialchars($row['amountRequested']) . '"><button type="submit" name="approve">Approve</button></form></td>';
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