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

// Fetch Available Questionnaire Templates
$templatesQuery = "SELECT * FROM QuestionnaireTemplates";
$templatesResult = mysqli_query($conn, $templatesQuery);

// Submit Questionnaire
if (isset($_POST['submit_questionnaire'])) {
    $templateId = $_POST['template_id'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert main response record
        $responseQuery = "INSERT INTO QuestionnaireResponses (FarmerID, TemplateID) VALUES (?, ?)";
        $responseStmt = mysqli_prepare($conn, $responseQuery);
        mysqli_stmt_bind_param($responseStmt, "si", $farmerId, $templateId);
        mysqli_stmt_execute($responseStmt);
        $responseId = mysqli_insert_id($conn);

        // Insert individual question responses
        $detailQuery = "INSERT INTO QuestionResponses (ResponseID, QuestionID, ResponseText) VALUES (?, ?, ?)";
        $detailStmt = mysqli_prepare($conn, $detailQuery);

        foreach ($_POST['responses'] as $questionId => $responseText) {
            mysqli_stmt_bind_param($detailStmt, "iis", $responseId, $questionId, $responseText);
            mysqli_stmt_execute($detailStmt);
        }

        // Commit transaction
        mysqli_commit($conn);
        $msg = "Questionnaire submitted successfully";
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        $msg = "Failed to submit questionnaire: " . $e->getMessage();
    }
}

// Fetch Questionnaire History
$historyQuery = "
    SELECT qr.ResponseID, qt.TemplateName, qr.SubmissionDate 
    FROM QuestionnaireResponses qr
    JOIN QuestionnaireTemplates qt ON qr.TemplateID = qt.TemplateID
    WHERE qr.FarmerID = ?
    ORDER BY qr.SubmissionDate DESC
";
$historyStmt = mysqli_prepare($conn, $historyQuery);
mysqli_stmt_bind_param($historyStmt, "s", $farmerId);
mysqli_stmt_execute($historyStmt);
$historyResult = mysqli_stmt_get_result($historyStmt);
?>


<div class="questionnaire-container">
    <h1>Questionnaires</h1>

    <?php if (isset($msg)): ?>
        <p><?php echo $msg; ?></p>
    <?php endif; ?>

    <!-- Available Questionnaire Templates -->
    <?php while ($template = mysqli_fetch_assoc($templatesResult)): ?>
        <div class="questionnaire-template">
            <h2><?php echo $template['TemplateName']; ?></h2>
            <p><?php echo $template['Description']; ?></p>

            <form method="post">
                <input type="hidden" name="template_id" value="<?php echo $template['TemplateID']; ?>">
                
                <?php 
                // Fetch questions for this template
                $questionsQuery = "SELECT * FROM Questions WHERE TemplateID = ?";
                $questionsStmt = mysqli_prepare($conn, $questionsQuery);
                mysqli_stmt_bind_param($questionsStmt, "i", $template['TemplateID']);
                mysqli_stmt_execute($questionsStmt);
                $questionsResult = mysqli_stmt_get_result($questionsStmt);
                ?>

                <?php while ($question = mysqli_fetch_assoc($questionsResult)): ?>
                    <div class="question">
                        <label><?php echo $question['QuestionText']; ?></label>
                        
                        <?php if ($question['QuestionType'] == 'Text'): ?>
                            <input type="text" name="responses[<?php echo $question['QuestionID']; ?>]" 
                                   <?php echo $question['Required'] ? 'required' : ''; ?>>
                        
                        <?php elseif ($question['QuestionType'] == 'Number'): ?>
                            <input type="number" name="responses[<?php echo $question['QuestionID']; ?>]" 
                                   <?php echo $question['Required'] ? 'required' : ''; ?>>
                        
                        <?php elseif ($question['QuestionType'] == 'Date'): ?>
                            <input type="date" name="responses[<?php echo $question['QuestionID']; ?>]" 
                                   <?php echo $question['Required'] ? 'required' : ''; ?>>
                        
                        <?php elseif ($question['QuestionType'] == 'MultipleChoice'): ?>
                            <?php 
                            // Fetch multiple choice options
                            $optionsQuery = "SELECT * FROM QuestionOptions WHERE QuestionID = ?";
                            $optionsStmt = mysqli_prepare($conn, $optionsQuery);
                            mysqli_stmt_bind_param($optionsStmt, "i", $question['QuestionID']);
                            mysqli_stmt_execute($optionsStmt);
                            $optionsResult = mysqli_stmt_get_result($optionsStmt);
                            ?>
                            <select name="responses[<?php echo $question['QuestionID']; ?>]" 
                                    <?php echo $question['Required'] ? 'required' : ''; ?>>
                                <?php while ($option = mysqli_fetch_assoc($optionsResult)): ?>
                                    <option value="<?php echo $option['OptionText']; ?>">
                                        <?php echo $option['OptionText']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>

                <button type="submit" name="submit_questionnaire">Submit Questionnaire</button>
            </form>
        </div>
    <?php endwhile; ?>

    <!-- Questionnaire Submission History -->
    <h2>Submission History</h2>
    <table>
        <thead>
            <tr>
                <th>Response ID</th>
                <th>Questionnaire Name</th>
                <th>Submission Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($history = mysqli_fetch_assoc($historyResult)): ?>
            <tr>
                <td><?php echo $history['ResponseID']; ?></td>
                <td><?php echo $history['TemplateName']; ?></td>
                <td><?php echo $history['SubmissionDate']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>

<?php mysqli_close($conn); ?>