<?php
session_start();
require_once 'dbconnect.php';
if (!isset($_SESSION['user_id'])) {
  header('location: admin-login.php');
  exit();
}
// Check if the user has the 'admin' role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
header('location: admin-login.php');
die();
}

$user_id = $_SESSION['user_id'];
$user_role =$_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add Questions</title>
    <link rel="stylesheet" href="add-question.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>



<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Questions</h2>
        <?php if(isset($_SESSION['addQuestion'])) : ?>
            <div class="alert__message error">
                <p><?= $_SESSION['addQuestion'];
                    unset($_SESSION['addQuestion']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form method="post" action="/quiz/add-question-logic.php" id="quizForm">
            <input type="text" placeholder="Test Title" name="test_title" id="testTitle">
            <textarea rows="6" placeholder="Test Description" name="test_desc" id="testDesc"></textarea>
            <label for="subjects">Subject</label>
    <select name="subjects">
    <option value="default" disabled>Choose the subject</option>
    <option value="physics">Physics</option>
    <option value="chemistry">Chemistry</option>
    <option value="maths">Maths</option>
    <option value="biology">Biology</option>
    <option value="computer">Computer</option>
</select>

       <!-- Existing question fields -->
<div class="question-fields" id="questionFields">
    <div class="question">
        <label for="question_num">Question number:</label>
        <input type="text" placeholder="Question number" name="question_num[]">
    </div>
    <div class="question">
        <label for="question">Question:</label>
        <input type="text" placeholder="Question" name="question[]" class="question_text">
    </div>
    <div class="options">
        <div class="option">
            <label for="option_1">Option 1:</label>
            <input type="text" placeholder="Option 1" name="option_1[]">
        </div>
        <div class="option">
            <label for="option_2">Option 2:</label>
            <input type="text" placeholder="Option 2" name="option_2[]">
        </div>
    </div>
    <div class="options">
        <div class="option">
            <label for="option_3">Option 3:</label>
            <input type="text" placeholder="Option 3" name="option_3[]">
        </div>
        <div class="option">
            <label for="option_4">Option 4:</label>
            <input type="text" placeholder="Option 4" name="option_4[]">
        </div>
    </div>
    <label for="correct_option">Correct option:</label>
    <select name="correct_option[]">
    <option value="default" disabled>Choose correct Option</option>
    <option value="Option 1">Option 1</option>
    <option value="Option 2">Option 2</option>
    <option value="Option 3">Option 3</option>
    <option value="Option 4">Option 4</option>
</select>



<div id="buttonsContainer">
    <!-- "ADD MORE" button -->
    <button type="button" class="btn" name="add_more" id="addMoreButton" onclick="addQuestion()">ADD MORE</button>

    <!-- "DONE" button -->
    <button type="submit" class="btn" name="done" id="doneButton">DONE</button>
</div>
</div>

        </form>
    </div>
</section>

<!-- ===========Form ENDS HERE============= -->


<script src="add-questions.js"></script>
</body>
</html>
