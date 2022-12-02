<?php
require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

function send_mail($to,$subj,$msg){
    $mail = new PHPMailer();

    // ---------- adjust these lines ---------------------------------------
    $mail->FromName = "Manajemen Kapabilitas"; // readable name
	$mail->Username = "eos.korlantas@gmail.com"; //"mgmt.kapabilitas.korlantas@matrik.co.id" ;// your GMail user name 
    $mail->Password = "Kopi,0100"; //"korlantas2019";  
    $mail->AddAddress($to); // recipients email
    
    $mail->Subject = $subj;
    $mail->Body    = $msg; 
    //-----------------------------------------------------------------------

	$mail->isHTML(true);
    $mail->Host = "ssl://smtp.gmail.com"; //"mail.matrik.co.id"; // GMail 
    $mail->Port = 465;
    $mail->IsSMTP(); // use SMTP
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->From = $mail->Username;
    if(!$mail->Send()){
        //echo "Mailer Error: " . $mail->ErrorInfo;
		return false;
    }else{
        //echo "Message has been sent";
		return true;
	}
}
?>