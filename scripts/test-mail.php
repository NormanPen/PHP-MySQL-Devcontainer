<?php
// scripts/test-mail.php
$to = 'test@example.com';
$subject = 'Mailhog Test';
$message = "Testmail von PHP an Mailhog.";
$headers = "From: test@localhost\r\nContent-Type: text/plain; charset=UTF-8";

if (mail($to, $subject, $message, $headers)) {
    echo "Mail wurde erfolgreich an Mailhog gesendet.\n";
} else {
    echo "Mail konnte NICHT gesendet werden.\n";
}
