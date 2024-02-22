<?php
require __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Change the following details according to yours
$gmail = "catalanwilfredo97@gmail.com";
$app_password = "sykmmtpojmudqbik";

$sender_name = "JJCK Realty Services";

try {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $mail->isSMTP();  //Send using SMTP

    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through

    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Port = 587;

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true; //Whether to use SMTP authentication

    $mail->Username   = $gmail; //SMTP username
    $mail->Password   = $app_password; //SMTP password

    /** Set who the message is to be sent from
     *  For gmail, this generally needs to be the same as the user you logged * in as. */
    $mail->setFrom($gmail, $sender_name);

    // Retrieve email and OTP from session variables
    $receiver_email = $_SESSION['email'];
    $random_otp = $_SESSION['otp'];

    $mail_subject = "Email Verification";
    $mail_body = "Your OTP is: $random_otp";

    // who will receive the email
    $mail->addAddress($receiver_email);

    $mail->isHTML(true);
    $mail->Subject = $mail_subject; // Subject of the Email
    $mail->Body = $mail_body; // Mail Body

    //For Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');  // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // You can specify the file name

    $mail->send();
    echo "Email has been sent successfully.";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
