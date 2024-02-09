function addQuestion() {
    // Clone the existing question fields
    var questionFields = document.getElementById('questionFields');
    var newQuestionFields = questionFields.cloneNode(true);

    // Clear the values of the new question fields
    var inputs = newQuestionFields.querySelectorAll('input, select');
    inputs.forEach(function (input) {
        input.value = '';
    });

    // Append the new question fields to the form
    document.getElementById('quizForm').appendChild(newQuestionFields);

    // Move the "Add More" and "Done" buttons below the last question
    var buttonsContainer = document.getElementById('buttonsContainer');
    buttonsContainer.appendChild(document.getElementById('addMoreButton'));
    buttonsContainer.appendChild(document.getElementById('doneButton'));
}
