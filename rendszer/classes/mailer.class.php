<?php
if(!defined('SZINT1') || SZINT1 !== 666)
    die('Hozzáférés megtagadva');

require_once(MAILER_DIR . 'class.phpmailer.php');

function sendEmail($Email, $Nick, $Targy, $Uzenet, $f_mail = 'blueedragonnteam@gmail.com', $f_name = 'BD-Team') {
    $from_mail = 'blueedragonnteam@gmail.com';
    $from_name = 'BD-Team';

    $mail = new PHPMailer();
    $mail->From = $from_mail;
    $mail->FromName = $from_name;
    $mail->IsSMTP(); 
    $mail->IsHTML(true);
    $mail->CharSet = 'iso-8859-2';
    $mail->SetLanguage('hu', '/PHPMailer/language');
    $mail->WordWrap = 50;

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';

    $mail->SMTPAuth = true;
    $mail->Username = $from_mail;
    $mail->Password = 'Bdt34em1';

    $mail->Sender = $from_mail;
    $mail->AddReplyTo($f_mail, $f_name);
    $mail->AddAddress($Email, $Nick);
    $mail->Subject = $Targy;
    $mail->Body = $Uzenet;

    if($mail->Send()) {
        $mail->ClearAddresses();
    	return true;
    } else {
    	return false;
    }
}

?>
