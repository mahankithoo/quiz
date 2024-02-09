<?php
session_start();
require_once 'dbconnect.php';

// Retrieve the data sent from the client
$data = json_decode(file_get_contents('php://input'), true);

// Validate the data (add more validation as needed)

// Insert data into the quiz_results table
$query = "INSERT INTO quiz_results (user_id, quiz_id, ques_num, selected_options) 
          VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

foreach ($data['results'] as $result) {
    mysqli_stmt_bind_param($stmt, 'iiis', $data['user_id'], $data['quiz_id'], $result['ques_num'], $result['selected_options']);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the error (you might want to log it or take other actions)
        http_response_code(500);
        echo 'Error submitting quiz. Please try again.';
        exit;
    }
}

mysqli_stmt_close($stmt);

// Send a success response to the client
http_response_code(200);
echo 'Quiz submitted successfully!';
?>
