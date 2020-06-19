<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['destination'],FILTER_VALIDATE_EMAIL) ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "Argument missing!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$to = strip_tags(htmlspecialchars($_POST['destination']));


// Create the email and send the message

$email_subject = "Contacto de vascotour.com.ar: $name";
$email_body = "Información del contacto:\n\nNombre: $name\n\nEmail: $email_address\n\nTeléfono: $phone\n\nMensaje:\n$message";

//print_r(array($to,$email_subject,$email_body,$headers));


try {
   //Server settings
   $mail->isSMTP();                                            // Send using SMTP
   $mail->Host       = 'dtcwin080.ferozo.com';                    // Set the SMTP server to send through
   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
   $mail->Username   = 'no-reply@vascotour.net';                     // SMTP username
   $mail->Password   = 'a1mZkgmdCr';                               // SMTP password
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
   $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

   //Recipients
   $mail->setFrom('no-reply@vascotour.net', $name);
   $mail->addReplyTo($email_address, $name);
   $mail->addAddress($to);     // Add a recipient

   // Content
   $mail->Subject = $email_subject;
   $mail->Body    = $email_body;

   $mail->send();
   echo 'Mensaje enviado';
} catch (Exception $e) {
   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



// mail($to,$email_subject,$email_body,$headers);
return true;         
