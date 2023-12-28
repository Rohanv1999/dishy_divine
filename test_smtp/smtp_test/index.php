<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer( true );

try {
                          // Server settings
    $mail->SMTPDebug = 0; // for detailed debug output
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->Username = 'giftmania1907@gmail.com'; // YOUR gmail email
    $mail->Password = 'quvtocgtrqsqlpbv';        // YOUR gmail password

    // Sender and recipient settings
    $mail->setFrom( 'giftmania1907@gmail.com', 'MR. Sachin PHP' );
    $mail->addAddress( 'phpfact@gmail.com' );

    // Setting the email content
    $mail->IsHTML( true );
    $mail->Subject = "Send email using Gmail SMTP and PHPMailer";
    $mail->Body    = 'HTML message body. <b>Gmail</b> SMTP email body.';
    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    echo "Email message sent.";

} catch ( Exception $e ) {
    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}
