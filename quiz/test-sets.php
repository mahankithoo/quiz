<?php
session_start();
require_once 'dbconnect.php';

// Retrieve the selected subject from the URL
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';

// Fetch quiz sets based on the selected subject
$sql = "SELECT * FROM quiz_sets WHERE subjects = '$subject'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Sets</title>
    <link rel="stylesheet" href="test-sets.css">
</head>
<body>
    <div id="quizSetsContainer">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="quizSet">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<button onclick="startQuiz(' . $row['quiz_id'] . ')">Start Test</button>';
                echo '</div>';
            }
        } else {
            echo 'No quiz sets found for ' . $subject;
        }

        mysqli_close($conn);
        ?>
    </div>

    <script>
        function startQuiz(quizId) {
            // Redirect to the quiz page with the quiz_id
            window.location.href = 'test.php?quiz_id=' + quizId;
        }
    </script>
</body>
</html>
