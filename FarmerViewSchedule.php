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

<?php include('includes/farmerHeader.php'); ?>
    <div class="container mt-5">

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
    </div>
<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>