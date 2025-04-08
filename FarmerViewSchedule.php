<?php
require_once('includes/connection.php');
session_start();

// Predefined Pickup Venues and Times
$pickupVenues = [
    'Kinda' => [
        'days' => 'Monday to Saturday',
        'morning' => '10:00 AM',
        'evening' => '05:30 PM'
    ],
    'Westy' => [
        'days' => 'Monday to Saturday',
        'morning' => '11:00 AM',
        'evening' => '06:30 PM'
    ],
    'Nai' => [
        'days' => 'Monday to Saturday',
        'morning' => '12:00 PM',
        'evening' => '07:30 PM'
    ],
    'Kiro' => [
        'days' => 'Monday to Saturday',
        'morning' => '10:30 AM',
        'evening' => '05:00 PM'
    ],
    'Gikoe' => [
        'days' => 'Monday to Saturday',
        'morning' => '11:30 AM',
        'evening' => '06:00 PM'
    ]
];

// Fetch Pickup Schedules from Database
try {
    $schedulesQuery = "SELECT * FROM TeaPickupSchedules";
    $schedulesResult = mysqli_query($conn, $schedulesQuery);
    
    // Override predefined venues with database values if available
    if ($schedulesResult) {
        while ($schedule = mysqli_fetch_assoc($schedulesResult)) {
            if (isset($pickupVenues[$schedule['Venue']])) {
                $pickupVenues[$schedule['Venue']]['morning'] = $schedule['MorningTime'];
                $pickupVenues[$schedule['Venue']]['evening'] = $schedule['EveningTime'];
            }
        }
    }
} catch (Exception $e) {
    // Fallback to predefined venues if query fails
    error_log("Error fetching pickup schedules: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tea Pickup Schedules</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .pickup-venue {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .pickup-details {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link" href="Farmers.php">Farmers</a>
                        <a class="nav-item nav-link" href="FertilizerIssuing.php">Fertilizer Issuing</a>
                        <a class="nav-item nav-link" href="FertilizerRequests.php">Fertilizer Requests</a>
                        <a class="nav-item nav-link" href="LoanRequests.php">Loan Requests</a>
                        <a class="nav-item nav-link" href="MyProduce.php">My Produce</a>
                        <a class="nav-item nav-link" href="TaskScheduler.php">Task Scheduler</a>
                        <a class="nav-item nav-link active" href="Questionnaires.php">Questionnaires</a>
                    </div>
                </nav>
            </div>
        </div>

        <h1 class="mb-4 text-center">Tea Pickup Schedules</h1>
        
        <?php foreach($pickupVenues as $venue => $details): ?>
            <div class="pickup-venue">
                <h3 class="text-center"><?php echo htmlspecialchars($venue); ?></h3>
            </div>
            <div class="pickup-details">
                <p class="text-center">
                    <?php echo htmlspecialchars($details['days']); ?> - 
                    Morning: <?php echo htmlspecialchars($details['morning']); ?> | 
                    Evening: <?php echo htmlspecialchars($details['evening']); ?>
                </p>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <button onclick="window.location.href='logout.php'" class="btn btn-danger">Log Out</button>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>