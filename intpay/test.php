<?php
// PHP server-side validation (unchanged)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($age) || !is_numeric($age) || $age < 18) {
        $errors[] = "Age must be a valid number and at least 18.";
    }

    if (empty($errors)) {
        // Process the form data (e.g., save to database)
        echo "Form successfully submitted!";
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form with Client-Side Validation</title>
    <script>
        // JavaScript for enabling/disabling fields based on prior input
        function enableEmailField() {
            let name = document.getElementById('name').value;
            let emailField = document.getElementById('email');

            // Enable email field if name is filled
            if (name.trim() !== "") {
                emailField.disabled = false; // Enable email field
            } else {
                emailField.disabled = true;  // Disable email field if name is empty
                document.getElementById('age').disabled = true; // Disable age field
            }
        }

        function enableAgeField() {
            let email = document.getElementById('email').value;
            let ageField = document.getElementById('age');

            // Enable age field if email is valid
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (emailPattern.test(email)) {
                ageField.disabled = false; // Enable age field if email is valid
            } else {
                ageField.disabled = true;  // Disable age field if email is invalid
            }
        }

        // JavaScript for form validation
        function validateForm() {
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;
            let age = document.getElementById('age').value;
            let errorMessages = [];

            // Clear previous error messages
            let errorContainer = document.getElementById('errorMessages');
            errorContainer.innerHTML = '';

            // Check if the name is empty
            if (name === "") {
                errorMessages.push("Name is required.");
            }

            // Check if the email is valid
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (email === "" || !emailPattern.test(email)) {
                errorMessages.push("Please enter a valid email address.");
            }

            // Check if the age is valid
            if (age === "" || isNaN(age) || age < 18) {
                errorMessages.push("Age must be a valid number and at least 18.");
            }

            // If there are errors, display them and prevent form submission
            if (errorMessages.length > 0) {
                errorMessages.forEach(function(msg) {
                    errorContainer.innerHTML += "<p style='color: red;'>" + msg + "</p>";
                });
                return false; // Prevent form submission
            }

            return true; // Allow form submission if no errors
        }

        // Disable email and age fields on page load if the name and email are empty
        window.onload = function() {
            document.getElementById('email').disabled = true;
            document.getElementById('age').disabled = true;
        }
    </script>
</head>
<body>

<h2>Registration Form</h2>

<!-- Error message container -->
<div id="errorMessages"></div>

<!-- Form starts here -->
<form method="POST" onsubmit="return validateForm()">
    <div style="display: flex; gap: 20px;">
        <!-- Column 1: Name -->
        <div style="flex: 1;">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required oninput="enableEmailField()"><br><br>
        </div>
        
        <!-- Column 2: Email -->
        <div style="flex: 1;">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" oninput="enableAgeField()"><br><br>
        </div>

        <!-- Column 3: Age -->
        <div style="flex: 1;">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age"><br><br>
        </div>
    </div>

    <input type="submit" value="Submit">
</form>

</body>
</html>
