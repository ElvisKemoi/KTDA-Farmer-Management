<?php 
require_once('includes/connection.php'); 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
 include('includes/farmerHeader.php'); 


$farmerId = $_SESSION['userID'];

// Add New Task
if (isset($_POST['btn_add_task'])) {
    $taskTitle = $_POST['txtTaskTitle'];
    $taskDescription = $_POST['txtTaskDescription'];
    $taskDate = $_POST['txtTaskDate'];

    $query = "INSERT INTO FarmerTasks (FarmerID, TaskTitle, TaskDescription, TaskDate) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $farmerId, $taskTitle, $taskDescription, $taskDate);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $msg = "Task added successfully";
        } else {
            $msg = "Failed to add task: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// Complete/Delete Task
if (isset($_POST['btn_complete_task'])) {
    $taskId = $_POST['txtTaskID'];

    $query = "DELETE FROM FarmerTasks WHERE TaskID = ? AND FarmerID = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $taskId, $farmerId);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $msg = "Task completed and removed";
        } else {
            $msg = "Failed to complete task: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch Existing Tasks
$taskQuery = "SELECT TaskID, TaskTitle, TaskDescription, TaskDate FROM FarmerTasks WHERE FarmerID = ? ORDER BY TaskDate";
$taskStmt = mysqli_prepare($conn, $taskQuery);
$tasks = [];

if ($taskStmt) {
    mysqli_stmt_bind_param($taskStmt, "s", $farmerId);
    mysqli_stmt_execute($taskStmt);
    $taskResult = mysqli_stmt_get_result($taskStmt);

    while ($task = mysqli_fetch_assoc($taskResult)) {
        $tasks[] = $task;
    }
    mysqli_stmt_close($taskStmt);
}
?>
<div class="task-scheduler">
    <h1>My Task Scheduler</h1>
    
    <!-- Add Task Form -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h3>Add New Task</h3>
        <table>
            <tr>
                <td>Task Title:</td>
                <td><input type="text" name="txtTaskTitle" required></td>
            </tr>
            <tr>
                <td>Task Description:</td>
                <td><textarea name="txtTaskDescription" rows="3"></textarea></td>
            </tr>
            <tr>
                <td>Task Date:</td>
                <td><input type="date" name="txtTaskDate" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_add_task">Add Task</button>
                </td>
            </tr>
        </table>
    </form>

    <!-- Existing Tasks -->
    <h3>My Tasks</h3>
    <?php if (!empty($msg)): ?>
        <p><?php echo $msg; ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Task Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['TaskTitle']); ?></td>
                    <td><?php echo htmlspecialchars($task['TaskDescription']); ?></td>
                    <td><?php echo date('d M Y', strtotime($task['TaskDate'])); ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="hidden" name="txtTaskID" value="<?php echo $task['TaskID']; ?>">
                            <button type="submit" name="btn_complete_task">Complete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>