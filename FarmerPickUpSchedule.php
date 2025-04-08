<?php
require_once('includes/connection.php');
session_start();

// Updated Admin Credentials
$admin_credentials = [
    'A001' => 'abcd1234',  // Corrected password
    'A002' => '123xyz', 
    'A003' => '#170#'
];

// Improved Admin Authentication Check
$isAdmin = false;
if (isset($_SESSION['userID']) && isset($admin_credentials[$_SESSION['userID']])) {
    $isAdmin = true;
}

// Predefined Pickup Venues
$pickupVenues = [
    'Kinda', 'Westy', 'Nai', 'Kiro', 'Gikoe'
];

// If not an admin, redirect to login
if (!$isAdmin) {
    header("Location: Login.php");
    exit;
}

// Initialize error message
$error_message = '';
$success_message = '';

// Create or Update Pickup Schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_schedule'])) {
    // Validate inputs
    if (!isset($_POST['venue']) || !isset($_POST['morning_time']) || !isset($_POST['evening_time'])) {
        $error_message = "All fields are required.";
    } else {
        $venue = mysqli_real_escape_string($conn, $_POST['venue']);
        $morningTime = mysqli_real_escape_string($conn, $_POST['morning_time']);
        $eveningTime = mysqli_real_escape_string($conn, $_POST['evening_time']);

        // Check if venue is valid
        if (!in_array($venue, $pickupVenues)) {
            $error_message = "Invalid venue selected.";
        } else {
            // Prepare and execute the query
            try {
                // Use REPLACE INTO to update if exists, insert if not
                $scheduleQuery = "REPLACE INTO TeaPickupSchedules (Venue, MorningTime, EveningTime) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $scheduleQuery);
                
                if ($stmt === false) {
                    throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
                }
                
                mysqli_stmt_bind_param($stmt, "sss", $venue, $morningTime, $eveningTime);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Schedule for $venue updated successfully.";
                } else {
                    $error_message = "Failed to update schedule: " . mysqli_error($conn);
                }
                
                mysqli_stmt_close($stmt);
            } catch (Exception $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        }
    }
}

// Fetch Existing Pickup Schedules
$schedulesQuery = "SELECT * FROM TeaPickupSchedules ORDER BY Venue";
$schedulesResult = mysqli_query($conn, $schedulesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tea Pickup Schedule Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Tea Pickup Schedules</h1>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label>Pickup Venue</label>
                <select class="form-control" name="venue" required>
                    <option value="">Select Venue</option>
                    <?php foreach($pickupVenues as $venue): ?>
                        <option value="<?php echo htmlspecialchars($venue); ?>"><?php echo htmlspecialchars($venue); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Morning Pickup Time</label>
                <input type="time" class="form-control" name="morning_time" required>
            </div>
            
            <div class="form-group">
                <label>Evening Pickup Time</label>
                <input type="time" class="form-control" name="evening_time" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="create_schedule">Create/Update Schedule</button>
        </form>

        <h2 class="mt-5">Current Pickup Schedules</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Morning Time</th>
                    <th>Evening Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($schedulesResult) {
                    while ($schedule = mysqli_fetch_assoc($schedulesResult)): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($schedule['Venue']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['MorningTime']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['EveningTime']); ?></td>
                </tr>
                <?php 
                    endwhile; 
                } else {
                    echo "<tr><td colspan='3'>No schedules found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>