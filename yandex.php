<?php
require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer;
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'smtp.yandex.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl'; // public const ENCRYPTION_SMTPS = 'ssl';
$mail->Username = 'omg.demo.app@yandex.com';
$mail->Password = 'dknhlkohqftrcbki';
$mail->setFrom('omg.demo.app@yandex.com', 'FROM');
$mail->addAddress('smart.mgmt.mmt@gmail.com');
$mail->Subject = 'SUBJECT tes';
$mail->Body = 'BODY tes';
$mail->send();
?>