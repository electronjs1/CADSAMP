<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from       = "cad.lscsd@gmail.com";
$address = $to;
$mail       = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->IsSMTP(); 
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;  // Enable SMTP authentication
$mail->Username = 'cad.lscsd@gmail.com'; // логин от почты
$mail->Password = 'xXG-CsN-UjB-RG3'; // пароль от почты
$mail->SMTPSecure = 'ssl';  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to 

$mail->setFrom('cad.lscsd@gmail.com'); 
$mail->AddAddress($address);

$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body    =$body;
$mail->AltBody = '';

$mail->Send();
}
?>
