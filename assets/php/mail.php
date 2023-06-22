<?php
require('././vendor/autoload.php');

$transport = new Swift_SmtpTransport('smtp-relay.sendinblue.com', 587);
$transport->setUsername('USER_SPMT');
$transport->setPassword('SMTP_KEY');

$mailer = new Swift_Mailer($transport);

$message = new Swift_Message('Confirmation Email');
$message->setFrom('noreply@hakkerspoulette.com');
$message->setTo($email);
$message->setBody('Thank you for contacting us! We have received your message.');

$result = $mailer->send($message);

