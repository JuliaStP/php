<?php

require_once '../vendor/autoload.php';
require '../config.php';

function send($from, $to) {
    $transport = (new Swift_SmtpTransport(SMTP, PORT, CERTIFICATE))
        ->setUsername(USER_NAME)
        ->setPassword(PASSWORD);
    $mailer = new Swift_Mailer($transport);
    // Create the message
    $message = (new Swift_Message())
        // Give the message a subject
        ->setSubject('Swiftmailer is here')
        // Set the From address with an associative array
        ->setFrom($from)
        ->setTo($to)
        ->setBody('Here is the message itself')
        // And optionally an alternative body
        ->addPart('<q>Here is the message itself</q>', 'text/html')

        ->attach(Swift_Attachment::fromPath('index.php'));
    // Send the message
    $result = $mailer->send($message);
    var_dump($result);
}