<?php
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('location: admin-login.php');
    exit();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location: admin-login.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $testTitle = mysqli_real_escape_string($conn, $_POST['test_title']);
    $testDesc = mysqli_real_escape_string($conn, $_POST['test_desc']);
    $subjects = mysqli_real_escape_string($conn, $_POST['subjects']);

    // Insert quiz set data into the quiz_sets table
    $insertQuizSetQuery = "INSERT INTO quiz_sets (title, description, subjects, submitted_by) 
    VALUES ('$testTitle', '$testDesc','$subjects', {$_SESSION['user_id']})";
    $resultQuizSet = mysqli_query($conn, $insertQuizSetQuery);

    if (!$resultQuizSet) {
        $_SESSION['addQuestion'] = "Error adding quiz set. Please try again.";
        header('Location: add-questions.php');
        exit();
    }

    // Get the quiz_id of the inserted quiz set
    $quizId = mysqli_insert_id($conn);

   // Loop through the submitted questions and insert them into the questions table
   foreach ($_POST['question_num'] as $key => $questionNum) {
    $questionText = mysqli_real_escape_string($conn, $_POST['question'][$key]);
    $option1 = mysqli_real_escape_string($conn, $_POST['option_1'][$key]);
    $option2 = mysqli_real_escape_string($conn, $_POST['option_2'][$key]);
    $option3 = mysqli_real_escape_string($conn, $_POST['option_3'][$key]);
    $option4 = mysqli_real_escape_string($conn, $_POST['option_4'][$key]);
    $correctOption = mysqli_real_escape_string($conn, $_POST['correct_option'][$key]);


    // Insert question data into the questions table
    $insertQuestionQuery = "INSERT INTO questions (quiz_id, question_num, question_text, option1, option2, option3, option4, correction_option) 
                            VALUES ($quizId, $questionNum, '$questionText', '$option1', '$option2', '$option3', '$option4', '$correctOption')";
    $resultQuestion = mysqli_query($conn, $insertQuestionQuery);

    if (!$resultQuestion) {
        $_SESSION['addQuestion'] = "Error adding questions. Please try again.";
        header('Location: add-questions.php');
        exit();
    }
}

    $_SESSION['addQuestion'] = "Questions added successfully!";
    header('Location: add-questions.php');
    exit();
} else {
    header('Location: add-questions.php');
    exit();
}
?>
