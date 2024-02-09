const info_box = document.querySelector(".info_box");
const exit_btn = info_box.querySelector(".buttons .quit");
const continue_btn = info_box.querySelector(".buttons .continue");
const quiz_box = document.querySelector(".quiz_box");
const time_line = document.querySelector("header .time_line");
const timeText = document.querySelector(".timer .time_left_txt");
const timeCount = document.querySelector(".timer .timer_sec");

// if Continue button clicked
continue_btn.onclick = () => {
    info_box.classList.remove("activeInfo"); // hide info box
    quiz_box.classList.add("activeQuiz"); // show quiz box
};
let currentQuestionIndex = 0;
let selectedOptions = {}; // Object to store selected options for each question

// Add event listener for the "Previous Question" button
document.getElementById('prevQuestion').addEventListener('click', function () {
    currentQuestionIndex--;
    if (currentQuestionIndex >= 0) {
        displayQuestion();
    } else {
        // Handle the case when the user is at the first question
        alert('This is the first question');
    }
});

// Modify the "Next Question" button event listener
document.getElementById('nextQuestion').addEventListener('click', function () {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        displayQuestion();
    } else {
        // Display modal when the user reaches the last question
        displayTestOverModal();
    }
});

function displayTestOverModal() {
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.innerHTML = `
        <div class="modal-content">
            <p>The test is over. Do you want to submit?</p>
            <div class="modal-buttons">
                <button id="submitYes">Yes</button>
                <button id="submitNo">No</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    const submitYesBtn = document.getElementById('submitYes');
    const submitNoBtn = document.getElementById('submitNo');

    submitYesBtn.addEventListener('click', function () {
        // Handle the logic for submitting the quiz
        submitQuiz();
        document.body.removeChild(modal);
    });

    submitNoBtn.addEventListener('click', function () {
        // Close the modal and potentially take some action
        document.body.removeChild(modal);
    });
}

// Update the "Start Quiz" button click event to show the "Previous Question" button
document.getElementById('startQuiz').addEventListener('click', function () {
    displayQuestion();
    document.getElementById('startQuiz').style.display = 'none';
    document.getElementById('prevQuestion').style.display = 'block';
    document.getElementById('nextQuestion').style.display = 'block';
});

function displayQuestion() {
    const question = questions[currentQuestionIndex];
    const questionSection = document.getElementById('questionSection');
    const questionCount = document.getElementById('questionCount');

    questionSection.innerHTML = `
        <div class="que_text">${question['question_text']}</div>
        <div class="option_list">
            ${optionsHTML(question)}
        </div>
    `;

    questionCount.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;

    // Add event listener to each option
    const options = document.querySelectorAll('.option');
    options.forEach((option, index) => {
        option.addEventListener('click', function () {
            // Update the selected option for the current question
            selectedOptions[currentQuestionIndex] = option.textContent;

            // Toggle the background color directly
            if (option.style.backgroundColor === 'yellow') {
                option.style.backgroundColor = '';
            } else {
                // Remove background color from all options first
                options.forEach(opt => opt.style.backgroundColor = '');
                // Set the background color of the clicked option
                option.style.backgroundColor = 'yellow';
            }
        });

        // Highlight the previously selected option for the current question
        if (selectedOptions[currentQuestionIndex] === option.textContent) {
            option.style.backgroundColor = 'yellow';
        }
    });
}

function optionsHTML(question) {
    // Return the HTML for options
    return `
        <div class="option">${question['option1']}</div>
        <div class="option">${question['option2']}</div>
        <div class="option">${question['option3']}</div>
        <div class="option">${question['option4']}</div>
    `;
}

function submitQuiz() {
    const postData = {
        quiz_id: quizId,
        user_id: userId,
        results: [], // Array to store results for each question
    };

    // Iterate through each question and add its data to the results array
    questions.forEach((question, index) => {
        const result = {
            ques_num: index + 1, // Assuming questions are 1-indexed
            selected_options: selectedOptions[index],
            correct_options: question.correct_option,
        };
        postData.results.push(result);
    });

    // Make an AJAX request to the server to submit the quiz results
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit_quiz.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Handle the success response from the server
            showViewResultsModal();
        } else {
            // Handle the error response from the server
            alert('Error submitting quiz. Please try again.');
        }
    };

    xhr.send(JSON.stringify(postData));
}


function showViewResultsModal() {
    const viewResultsModal = document.createElement('div');
    viewResultsModal.classList.add('modal');
    viewResultsModal.innerHTML = `
        <div class="modal-content">
            <p>Congratulations! your test is completed</p>
            <div class="modal-buttons">
                <button id="viewResultsYes">Result</button>
                
            </div>
        </div>
    `;
    document.body.appendChild(viewResultsModal);

    const viewResultsYesBtn = document.getElementById('viewResultsYes');
    

    viewResultsYesBtn.addEventListener('click', function () {
        // Redirect to the page where you want to display results
        window.location.href = 'view_results.php';
    });
}
