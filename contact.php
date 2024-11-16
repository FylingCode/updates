<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
  .header {
    padding: 10px;
    text-align: center;
    background: #20BC79;
    color: white;
    font-size: 30px;
  }

  .ques {
    min-height: 493px;
  }
</style>

<body>
  <?php include "./partials/_header.php" ?>

  <div class="header my-5">
    <p>Contact Us</p>
  </div>

  <div class="container ques border border-success shadow-lg p-3 mb-5 bg-white rounded">
    <?php
    // Database connection
    $servername = "localhost"; 
    $username = "root";       
    $password = "";           
    $dbname = "idiscuss"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first_name = $last_name = $email_address = $phone_number = $query_des = "";
    $first_name_err = $last_name_err = $email_err =  $phone_err = $query_err = "";

    // Form submission handling
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate First Name
        if (empty(trim($_POST["first_name"]))) {
            $first_name_err = "First name is required.";
        } else {
            $first_name = htmlspecialchars(trim($_POST["first_name"]));
        }

        // Validate Last Name
        if (empty(trim($_POST["last_name"]))) {
            $last_name_err = "Last name is required.";
        } else {
            $last_name = htmlspecialchars(trim($_POST["last_name"]));
        }

        // Validate Email Address
        if (empty(trim($_POST["email_address"]))) {
            $email_err = "Email address is required.";
        } elseif (!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } else {
            $email_address = htmlspecialchars(trim($_POST["email_address"]));
        }

        // Validate Phone Number
        if (empty(trim($_POST["phone_number"]))) {
            $phone_err = "Phone number is required.";
        } elseif (!preg_match('/^[6-9][0-9]{9}$/', $_POST["phone_number"])) {
            $phone_err = "Phone number must start with 6, 7, 8, or 9 and be 10 digits long.";
        } else {
            $phone_number = htmlspecialchars(trim($_POST["phone_number"]));
        }

        // Validate Query Description
        if (empty(trim($_POST["query_des"]))) {
            $query_err = "Query description is required.";
        } else {
            $query_des = htmlspecialchars(trim($_POST["query_des"]));
        }

        // If no errors, insert data into the database
        if (empty($first_name_err) && empty($last_name_err) && empty($email_err)&& empty($phone_err) && empty($query_err)) {
            $sql = "INSERT INTO `contactus` (`first_name`, `last_name`, `email_address`, `phone_number`, `query_des`, `created_at`) VALUES ('$first_name', '$last_name', '$email_address', '$phone_number','$query_des', current_timestamp());";

            if ($conn->query($sql) === TRUE) {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> Form Submitted Successfully. We will catch you soon 😊
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
    ?>

    <?php
        if ($first_name_err || $last_name_err || $email_err || $phone_err || $query_err) {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please fix the following issues:
                <ul>';
                if ($first_name_err) echo "<li>$first_name_err</li>";
                if ($last_name_err) echo "<li>$last_name_err</li>";
                if ($email_err) echo "<li>$email_err</li>";
                if ($phone_err) echo "<li>$phone_err</li>";
                if ($query_err) echo "<li>$query_err</li>";
            echo '</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>
    
    <h1>Contact Us</h1>
    <form action="contact.php" method="POST">
        <div class="form-group my-3">
            <label for="firstName">Your First Name</label>
            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter your first name" maxlength="30" value="<?php echo htmlspecialchars($first_name); ?>" oninput="enableNextField('lastName')">
            <?php if ($first_name_err) echo "<small class='text-danger'>$first_name_err</small>"; ?>
        </div>

        <div class="form-group my-3">
            <label for="lastName">Your Last Name</label>
            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter your last name" maxlength="30" value="<?php echo htmlspecialchars($last_name); ?>" oninput="enableNextField('email')" disabled>
            <?php if ($last_name_err) echo "<small class='text-danger'>$last_name_err</small>"; ?>
        </div>

        <div class="form-group my-3">
            <label for="email_address">Email address</label>
            <input type="email" class="form-control" id="email" name="email_address" placeholder="Enter your email" maxlength="30" value="<?php echo htmlspecialchars($email_address); ?>" oninput="enableNextField('phone_number')" disabled>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <?php if ($email_err) echo "<small class='text-danger'>$email_err</small>"; ?>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" maxlength="12" value="<?php echo htmlspecialchars($phone_number); ?>" oninput="enableNextField('query_des')" disabled>
            <?php if ($phone_err) echo "<small class='text-danger'>$phone_err</small>"; ?>
        </div>

        <div class="form-group my-3">
            <label for="query_des">Elaborate your Query</label>
            <textarea class="form-control" id="query_des" name="query_des" rows="3" placeholder="Enter your query here" maxlength="200" oninput="enableNextField('submitButton')" disabled><?php echo htmlspecialchars($query_des); ?></textarea>
            <?php if ($query_err) echo "<small class='text-danger'>$query_err</small>"; ?>
        </div>

        <button type="submit" class="btn btn-success my-3" id="submitButton" disabled>Submit</button>
    </form>
</div>

<?php include "partials/_footer.php" ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Enable the next field based on the current input
    function enableNextField(nextFieldId) {
        var currentField = document.getElementById(nextFieldId);
        var submitButton = document.getElementById('submitButton');

        // Enable next field if the current field is filled
        if (nextFieldId === 'lastName' && document.getElementById('firstName').value.trim() !== "") {
            currentField.disabled = false;
        } else if (nextFieldId === 'email' && document.getElementById('lastName').value.trim() !== "") {
            currentField.disabled = false;
        } else if (nextFieldId === 'phone_number' && document.getElementById('email').value.trim() !== "") {
            currentField.disabled = false;
        } else if (nextFieldId === 'query_des' && document.getElementById('phone_number').value.trim() !== "") {
            currentField.disabled = false;
        }

       // Enable submit button once all fields are filled
        if (document.getElementById('firstName').value.trim() !== "" && 
            document.getElementById('lastName').value.trim() !== "" && 
            document.getElementById('email').value.trim() !== "" && 
            document.getElementById('phone_number').value.trim() !== "" && 
            document.getElementById('query_des').value.trim() !== "") {
              submitButton.disabled = false;
        }
    }
</script>

</body>

</html>
