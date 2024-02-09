<?php
session_start();
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Tile-Result</title>
    <link rel="stylesheet" href="test.css">
    <!-- FontAweome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

    <div class="info_box">
        <div class="info-title"><span>Title</span></div>
        <div class="info-list">
            <div class="info">Congratualtion! [Name] you obtained [OM] out of [FM] </div>
        </div>
        <div class="buttons">
            <button id="viewQuestion" class="continue">View Result</button>
        </div>
    </div>

    <!-- Quiz Box -->
    <div class="quiz_box" id="quizBox">
        <header>
            <div class="title">Title</div>
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