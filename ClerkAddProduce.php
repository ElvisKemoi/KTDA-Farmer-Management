<?php 
require_once('includes/connection.php'); 
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmerID = $_POST['farmerID'];
    $quantity = $_POST['quantity'];
    $dateRecorded = date("Y-m-d"); // Format matches DateRecorded column type
    $clerkID = $_SESSION['userID'] ?? null; // ClerkID should be from the session or a valid source

    if (!empty($farmerID) && !empty($quantity) && is_numeric($quantity) && !empty($clerkID)) {
        $query = "INSERT INTO produce (FarmerID, ClerkID, Quantity, DateRecorded) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssds", $farmerID, $clerkID, $quantity, $dateRecorded);
            if (mysqli_stmt_execute($stmt)) {
                $successMessage = "Produce added successfully!";
            } else {
                $errorMessage = "Error adding produce: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $errorMessage = "Please enter a valid quantity and ensure ClerkID is set.";
    }
}

// Fetch all farmers for the dropdown
$query = "SELECT FarmerID, FName, LName FROM Farmer ORDER BY FName ASC";
$result = mysqli_query($conn, $query);
?>

<?php include('includes/clerkHeader.php'); ?>

<style>
    form {
        width: 50%;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    label {
        font-weight: bold;
    }

    select, input[type="number"], input[type="submit"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .success {
        color: green;
        font-weight: bold;
    }

    .error {
        color: red;
        font-weight: bold;
    }
</style>

<h1 style="text-align: center;">Add New Produce</h1>

<?php 
if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; 
if (isset($errorMessage)) echo "<p class='error'>$errorMessage</p>"; 
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="farmerID">Select Farmer:</label>
    <select name="farmerID" required>
        <option value="">-- Select Farmer --</option>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo $row['FarmerID']; ?>">
                <?php echo "{$row['FName']} {$row['LName']}"; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="quantity">Quantity (kg):</label>
    <input type="number" name="quantity" step="0.01" min="0.01" required>

    <input type="submit" value="Add Produce">
</form>

<?php include('includes/footer.php'); ?>
<?php mysqli_close($conn); ?>
