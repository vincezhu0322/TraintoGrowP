<?php
include 'include/header.php';
include 'include/css.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // The students will have 7days to use video.
    $date_of_enrollment = date('Y-m-d');
    $video_end_date = date('Y-m-d', strtotime('+7 days')); 

    // Sanitize and validate the student input.
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
    if (!preg_match("/^[0-9]{5}(-[0-9]{4})?$/", $zip)) {
        $errors['zip'] = 'ZIP code is not in the correct format.';
    }
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = 'Phone number is not in the correct format.';
    }
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is not in a valid format.';
    }
    $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $fee = filter_input(INPUT_POST, 'fee', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $valid_payment_methods = ['ax', 'vs', 'mc', 'ds', 'cb', 'jpc', 'check'];
    if (!in_array($course, ['beginner', 'intermediate', 'advanced'])) {
        $errors['course'] = 'Course selection is invalid.';
    }
    if (!in_array($location, ['online', 'detroit'])) {
        $errors['location'] = 'Location selection is invalid.';
    }
    if (!in_array($fee, [200, 250])) {
        $errors['fee'] = 'Fee selection is invalid.';
    }
    if (!in_array($payment_method, $valid_payment_methods)) {
        $errors['payment_method'] = 'Payment method selection is invalid.';
    }

    // Sanitize credit card details
    $cardholderName = filter_input(INPUT_POST, 'cardholder_name', FILTER_SANITIZE_STRING);
    $cardNumber = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_NUMBER_INT);
    $cardExpiry = filter_input(INPUT_POST, 'card_expiry', FILTER_SANITIZE_STRING);
    $cardCVC = filter_input(INPUT_POST, 'card_cvc', FILTER_SANITIZE_NUMBER_INT);

    // Process the payment through a payment gateway
    // Send the credit card details to a payment processor's API
    // and not handle them directly for security
    // For example, demo processing logic in payment_gateway.php

    // After successful paymeny, generate a unique token
    $token = bin2hex(random_bytes(16)); // 32 characters long
    $expiryDate = new DateTime('+7 days'); // Token valid for 7 days
    // Store the token and expiry date in the database
    // Psuedo code to execute database queries
    storeTokenInDatabase($studentId, $token, $expiryDate->format('Y-m-d H:i:s'));

    // PDO database connection instance to prepare pseudo SQL statement (... represents other fields)
    $stmt = $pdo->prepare("INSERT INTO students (name, address, ...) VALUES (?, ?, ...)");
    $stmt->execute([$name, $address, ...]);

    // Send confirmation email with token
    $to = $email;
    $subject = 'Registration Confirmation';
    $message = "Hello " . $name . ",\n\n";
    $message .= "Thank you for registering for our course. Here are your registration details:\n";
    $message .= "Course: " . $course . "\n";
    $message .= "Location: " . $location . "\n";
    $message .= "Fee: $" . $fee . "\n";
    $message .= "Payment Method: " . $payment_method . "\n";
    $message .= "Date of Enrollment: " . $date_of_enrollment . "\n";
    $message = "To access the video content, use the following link: \n";
    $message .= "https://yourdomain.com/video_access.php?token=$token\n";
    $message .= "You will have access to the course videos for 7 days from the date of enrollment.\n\n";
    $message .= "Best regards,\n";
    $message .= "YodaTaylor's Training Team";
    $headers = 'From: no-reply@yourdomain.com' . "\r\n";
    $headers .= 'Reply-To: info@yourdomain.com' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    if(mail($to, $subject, $message, $headers)) {
        echo 'Confirmation email sent successfully!';
    } else {
        echo 'Email sending failed.';
    }

    // Display a success message or redirect
    echo "<script>alert('Thank you for registering. A confirmation email has been sent.'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <script src="credit_card_processing.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <!-- other css stylesheet links -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Student Registration Form</h2>
    <form action="student-registration.php" method="post">

        <!-- Student Personal Information -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="form-group">
            <label for="zip">Zip:</label>
            <input type="text" class="form-control" id="zip" name="zip" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <!-- Extra place for other form fields -->

        <!-- Course Information -->
        <div class="form-group">
            <label for="course">Course:</label>
            <select class="form-control" id="course" name="course">
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
            </select> <!-- Course level dropdown -->
        </div>
        <div class="form-group">
            <label for="location">Course Location:</label>
            <select class="form-control" id="location" name="location">
                <option value="online">Online</option>
                <option value="detroit">Detroit, MI</option>
            </select> <!-- Course location dropdown -->
        </div>
        <div class="form-group">
            <label for="fee">Fee:</label>
            <select class="form-control" id="fee" name="fee">
                <option value="200">$200</option>
                <option value="250">$250</option>
            </select> <!-- Course fee dropdown -->
        </div>

        <!-- Payment Information -->
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select class="form-control" id="payment_method" name="payment_method">
                <option value="ax">American Express (AX)</option>
                <option value="vs">Visa</option>
                <option value="mc">MasterCard</option>
                <option value="ds">Discover</option>
                <option value="cb">Citi Bank</option>
                <option value="jpc">JP Morgan Chase</option>
                <option value="check">Check</option>
            </select> <!-- Payment method dropdown -->
        </div>
        
        <!-- Credit Card Details -->
        <div id="credit-card-section">
            <input type="text" id="name" name="cardholder_name" placeholder="Cardholder Name" required>
            <input type="text" id="cardnumber" name="card_number" placeholder="Card Number" required>
            <input type="text" id="expirationdate" name="card_expiry" placeholder="MM/YY" required>
            <input type="text" id="securitycode" name="card_cvc" placeholder="CVC" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

</body>
</html>
