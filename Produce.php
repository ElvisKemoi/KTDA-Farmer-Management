<?php 
require_once('includes/connection.php'); 
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
include('includes/header.php'); 

// Fetch farmer details
$farmerId = $_SESSION['userID'];
$query = "SELECT OfficerID, CenterID, FName, LName FROM AGRICULTURAL_OFFICER WHERE OfficerID = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $farmerId);
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
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <h1>All Produce</h1>
    <h4><?php echo $msgViewUser; ?></h4><hr>

    <table>
        <tr>
            <th>Produce ID</th>
            <th>Farmer ID</th>
            <th>Farmer Name</th>
            <th>Quantity (kg)</th>
            <th>Date Recorded</th>
        </tr>

        <?php
        // Fetch all produce records (No filtering by FarmerID)
        $query = "SELECT p.ProduceID, p.FarmerID, f.FName, f.LName, p.Quantity, p.DateRecorded 
                  FROM produce p 
                  JOIN Farmer f ON p.FarmerID = f.FarmerID
                  ORDER BY p.DateRecorded DESC";
        $stmt = mysqli_prepare($conn, $query);
        $totalProduce = 0;

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['ProduceID']}</td>
                            <td>{$row['FarmerID']}</td>
                            <td>{$row['FName']} {$row['LName']}</td>
                            <td>{$row['Quantity']} kg</td>
                            <td>{$row['DateRecorded']}</td>
                          </tr>";
                    
                    // Calculate total produce quantity
                    $totalProduce += $row['Quantity'];
                }
                
                // Display total produce row
                echo "<tr class='total-row'>
                        <td colspan='3'>Total Produce</td>
                        <td>{$totalProduce} kg</td>
                        <td></td>
                      </tr>";
            } else {
                echo "<tr><td colspan='5'>No produce records found.</td></tr>";
            }

            mysqli_stmt_close($stmt);
        }
        ?>
    </table>

</form>

<?php include('includes/footer.php'); ?>
<?php mysqli_close($conn); ?>
