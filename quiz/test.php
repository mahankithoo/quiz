<?php
session_start();
require_once 'dbconnect.php';

// Check if quiz_id is set in the URL
if (isset($_GET['quiz_id'])) {
    $quizId = $_GET['quiz_id'];

    // Fetch quiz details based on the quiz_id
    $sql = "SELECT * FROM quiz_sets WHERE quiz_id = $quizId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $quizTitle = $row['title'];
        $quizDescription = $row['description'];
    } else {
        // Redirect to an error page
        header('Location: error.php');
        exit();
    }

    // Fetch questions for the given quiz_id
    $questionsSql = "SELECT * FROM questions WHERE quiz_id = $quizId";
    $questionsResult = mysqli_query($conn, $questionsSql);
    $questions = [];

    if ($questionsResult && mysqli_num_rows($questionsResult) > 0) {
        while ($questionRow = mysqli_fetch_assoc($questionsResult)) {
            $questions[] = $questionRow;
        }
    }
} else {
    // Redirect to an error page 
    header('Location: error.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $quizTitle; ?></title>
    <link rel="stylesheet" href="test.css">
    <!-- FontAweome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

    <div class="info_box">
        <div class="info-title"><span><?php echo $quizTitle; ?></span></div>
        <div class="info-list">
            <div class="info"><?php echo $quizDescription; ?></div>
        </div>
        <div class="buttons">
            <button class="quit">Exit Test</button>
            <button id="startQuiz" class="continue">Start Quiz</button>
        </div>
    </div>

    <!-- Quiz Box -->
    <div class="quiz_box" id="quizBox">
        <header>
            <div class="title"><?php echo $quizTitle; ?></div>
            <div class="timer">
                <div class="time_left_txt">Time Left</div>
                <div class="timer_sec">15</div>
            </div>
            <div class="time_line"></div>
        </header>
        <section id="questionSection">
            <!-- Questions will be dynamically inserted here -->
        </section>

       
<footer>
    <div class="total_que">
        <span id="questionCount"></span>
    </div>
    <button id="prevQuestion" class="prev_btn show" style="display: none;">Previous Question</button>
    <button id="nextQuestion" class="next_btn show">Next Question</button>
</footer>

    </div>
<script>
    const questions = <?php echo json_encode($questions); ?>;
    const quizId = <?php echo json_encode($quizId ?? null); ?>;
    const userId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;


</script>

<script src="test.js"></script>

</body>
</html>