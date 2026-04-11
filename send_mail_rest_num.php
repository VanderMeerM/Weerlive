<?php ob_start(); ?>

<?php 
set_include_path('../../PHPMailer');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$name = $_POST['name'];
$visemail= $_POST['email'];
$message = $_POST['message'];

try{

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    
    $mail->Host       = 'smtp.strato.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mailvoor@marcelvandermeer.nl';                     //SMTP username
    $mail->Password   = 'IeSPZHqmpCJXGwi';                 //SMTP password
 
           
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;    

    $mail->setFrom('mailvoor@marcelvandermeer.nl', 'Weersite');
    $mail->addAddress('mailvoor@marcelvandermeer.nl', 'Weersite');     //Add a recipient
    //$mail->addReplyTo($visemail, $visemail);
    $mail->CharSet    = 'utf-8';
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Aantal requests weersite';
    $mail->Body    = 
    'Het aantal requests op de <a href="https://www.marcelvandermeer.eu/weer/"> weersite </a> bedraagt nog 50.'; 
     //'This is the HTML message body <b>in bold!</b>';
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

   } 
   catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}


