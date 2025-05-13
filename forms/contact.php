<?php
// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (
        empty($_POST["name"]) || 
        empty($_POST["email"]) || 
        empty($_POST["subject"]) || 
        empty($_POST["message"])
    ) {
        http_response_code(400);
        echo "Please fill in all required fields.";
        exit;
    }

    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please enter a valid email address.";
        exit;
    }

    // Email setup
    $to = "ab9974085@gmail.com"; // Change to your receiving email
    $email_subject = "New contact from: $name";
    $email_body = "You have received a new message from your website contact form.\n\n".
                  "Name: $name\n".
                  "Email: $email\n".
                  "Subject: $subject\n".
                  "Message:\n$message";

    $headers = "From: $name <$email>";

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "OK";
    } else {
        http_response_code(500);
        echo "Failed to send message. Please try again later.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>