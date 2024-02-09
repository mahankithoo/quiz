<?php
session_start();
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Subjects</title>
    <link rel="stylesheet" href="test-sets.css">
</head>
<body>
    <div id="quizSetsContainer">
        <?php
        $subjects = array("Physics", "Chemistry", "Maths", "Biology", "Computer");

        foreach ($subjects as $subject) {
            echo '<div class="quizSet">';
            echo '<h2>' . $subject . '</h2>';
            echo '<p>Click on the button</p>';
            echo '<button onclick="startQuiz(\'' . $subject . '\')">Show Tests</button>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        function startQuiz(subject) {
            // Redirect to the quiz sets page with the selected subject
            window.location.href = 'test-sets.php?subject=' + encodeURIComponent(subject);
        }
    </script>
</body>
</html>
