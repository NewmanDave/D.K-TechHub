<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect the form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Basic validation to check if fields are empty
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit;
    }

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email format.'
        ]);
        exit;
    }

    // If everything is fine, proceed to handle the form submission
    // Define the recipient email address (replace with your email address)
    $to = "davidkomla0247363060@gmail.com";
    $subject = "New message from: $name";
    $body = "You have received a new message from $name ($email):\n\n$message";
    $headers = "From: $email" . "\r\n" .
        "Reply-To: $email" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // Send the email
    $mailSent = mail($to, $subject, $body, $headers);

    // If the email was sent successfully
    if ($mailSent) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Your message has been sent successfully!'
        ]);
    } else {
        // If email sending failed
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error sending your message. Please try again later.'
        ]);
    }

} else {
    // If the form was not submitted via POST
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
