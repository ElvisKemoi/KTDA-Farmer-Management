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
        $msgViewUser = "Login as {$userFarmerID} - {$userFName} {$userLName} From - {$userFarmerAddress}";
    }

    // Query to fetch farmer details
    $query1 = "SELECT FName, LName FROM FARMER WHERE FarmerID = '{$farmerId}' LIMIT 1";
    $result1 = mysqli_query($conn, $query1);

    if ($record = mysqli_fetch_assoc($result1)) {
        $msg1 = $record['FName'] . " " . $record['LName'];
    } else {
        $msg1 = "No such FarmerID exists";
    }

    // Fetch existing loan details if any
    $existingLoanQuery = "SELECT * FROM loans WHERE FarmerID = '{$farmerId}'";
    $existingLoanResult = mysqli_query($conn, $existingLoanQuery);

    // Handle loan request submission
    if (isset($_POST['btnSaveLoanRequest'])) {
        $loanAmount = mysqli_real_escape_string($conn, $_POST['txtLoanAmount']);
        $currentDate = date('Y-m-d');

        // Prepare the insert query using mysqli
        $query = "INSERT INTO loans (FarmerID, Amount, Status, ApplicationDate) 
                  VALUES ('{$farmerId}', {$loanAmount}, 'Pending', '{$currentDate}')";

        if (mysqli_query($conn, $query)) {
            $msg2 = "Loan request submitted successfully";
        } else {
            $msg2 = "Failed to submit loan request: " . mysqli_error($conn);
        }
    }
?>

<?php include('includes/farmerHeader.php'); ?>
    
<form action="FarmerLoanRequest.php" method="post">
    <h1>Loans</h1>
    <h4><?php echo $msgViewUser ?></h4><hr>

    <table>
        <tr>
            <td>Existing Loans:</td>
            <td>
                <table border="1">
                    <tr>
                        <th>Loan ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Application Date</th>
                    </tr>
                    <?php 
                    while($existingLoan = mysqli_fetch_assoc($existingLoanResult)) {
                    ?>
                    <tr>
                        <td><?php echo $existingLoan['LoanID']; ?></td>
                        <td><?php echo $existingLoan['Amount']; ?></td>
                        <td><?php echo $existingLoan['Status']; ?></td>
                        <td><?php echo $existingLoan['ApplicationDate']; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>Loan Amount (Ksh): </td>
            <td>
                <input type="number" name="txtLoanAmount" min="1000" step="100" required>
                <button name="btnSaveLoanRequest" type="submit">Submit Loan Request</button>
                <label for="lblSaveMsg"><b><?php echo (isset($msg2)) ? $msg2 : ''; ?></b></label>
            </td>
        </tr>
    </table>
</form> 

<?php include('includes/footer.php'); ?>

</body>
</html>

<?php mysqli_close($conn); ?>