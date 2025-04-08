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

// If not an admin, redirect to login
if (!$isAdmin) {
    header("Location: Login.php");
    exit;
}

// Create New Questionnaire Template
if (isset($_POST['create_template'])) {
    $templateName = $_POST['template_name'];
    $description = $_POST['description'];

    // Insert Template
    $templateQuery = "INSERT INTO QuestionnaireTemplates (TemplateName, Description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $templateQuery);
    mysqli_stmt_bind_param($stmt, "ss", $templateName, $description);
    mysqli_stmt_execute($stmt);
    $templateId = mysqli_insert_id($conn);

    // Insert Questions
    if (isset($_POST['questions'])) {
        $questionQuery = "INSERT INTO Questions (TemplateID, QuestionText, QuestionType, Required) VALUES (?, ?, ?, ?)";
        $questionStmt = mysqli_prepare($conn, $questionQuery);

        foreach ($_POST['questions'] as $question) {
            mysqli_stmt_bind_param($questionStmt, "issi", 
                $templateId, 
                $question['text'], 
                $question['type'], 
                $question['required']
            );
            mysqli_stmt_execute($questionStmt);
        }
    }
}

// Fetch Existing Templates
$templatesQuery = "SELECT * FROM QuestionnaireTemplates ORDER BY CreatedDate DESC";
$templatesResult = mysqli_query($conn, $templatesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Questionnaire Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create Questionnaire Template</h1>
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="template_name" placeholder="Template Name" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="Template Description"></textarea>
            </div>
            
            <div id="questions-container">
                <div class="question-row mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="questions[0][text]" placeholder="Question Text">
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="questions[0][type]">
                                <option value="Text">Text</option>
                                <option value="Number">Number</option>
                                <option value="Date">Date</option>
                                <option value="MultipleChoice">Multiple Choice</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="questions[0][required]" value="1">
                                <label class="form-check-label">Required</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="addQuestion()">Add Question</button>
                <button type="submit" class="btn btn-primary" name="create_template">Create Template</button>
            </div>
        </form>

        <h2 class="mt-5">Existing Templates</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Template Name</th>
                    <th>Description</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($template = mysqli_fetch_assoc($templatesResult)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($template['TemplateName']); ?></td>
                    <td><?php echo htmlspecialchars($template['Description']); ?></td>
                    <td><?php echo htmlspecialchars($template['CreatedDate']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    let questionIndex = 1;
    function addQuestion() {
        const container = document.getElementById('questions-container');
        const newRow = document.createElement('div');
        newRow.className = 'question-row mb-3';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="questions[${questionIndex}][text]" placeholder="Question Text">
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="questions[${questionIndex}][type]">
                        <option value="Text">Text</option>
                        <option value="Number">Number</option>
                        <option value="Date">Date</option>
                        <option value="MultipleChoice">Multiple Choice</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="questions[${questionIndex}][required]" value="1">
                        <label class="form-check-label">Required</label>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        questionIndex++;
    }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>