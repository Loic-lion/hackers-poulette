<?php
$to = $email;
$subject = "Message Received";
$message = "Thank you for contacting us.\n\nWe have received your message and will get back to you soon.";
$header = "From: Hakkers Poulette <noreply@hakkerspoulette.com>";

if (mail($to, $subject, $message, $header)) {
    $response .= "Insertion to the db ok.<br>";

    $response .= "Email confirmation sent.";
} else {
    $response .= "Error sending email confirmation.<br>";
}
