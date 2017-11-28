<?php 
require_once("class.phpmailer.php");

$usuario = 'ouvidoria.ime@gmail.com';
$senha = 'webmaster123';

function smtpmailer($destinatario, $remetente, $assunto, $corpo) { 
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'tls';	// TLS REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = $usuario;
	$mail->Password = $senha;
	$mail->From = $remetente;
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($destinatario);
	if(!$mail->Send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		return false;
	} 
	else return true;
}

?>
