<?php

$to = "sam@eclass4learning.com";
$subject = "Testing";
$message = "This message was sent from the Dev Box server.";
$headers = "From: info@eclass4learning.com";

if(mail($to, $subject, $message, $headers)) {
    echo "Successfully sent an email to $to.";
} else {
    echo "Failed to send email.";
}
