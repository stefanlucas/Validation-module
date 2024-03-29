<?php
require_once('phpmailer/smtpmailer.php');

$data = date("d/m/y");// Data do envio
$hora = date("H:i");// Hora do envio

$nome = $_POST["nome"];
$email = $_POST["email"];
$mensagem = $_POST["mensagem"];	

if ($mensagem == "") {
	$error = "O campo da mensagem não pode estar vazio";
	require('message_form.php');
	return;
}

$email_ouvidoria = 'ouvidoria.ime@gmail.com';
$assunto_ouvidoria = "Ouvidoria IME-USP | Novo contato ";
$assunto_usuario = "Ouvidoria IME-USP | Retorno automático";
$corpo_ouvidoria = "Nome............: $nome\n".
	"E-mail..........: $email\n".
	"Mensagem........: $mensagem\n".
	"Data............: $data\n".
	"Hora............: $hora\n";
if ($nome == "") {
	$nome = "amigo(a)";
}
$corpo_usuario = "Olá, $nome.\nObrigado pela mensagem, em breve entraremos em contato.\n";	

if (smtpmailer($email_ouvidoria, $email, $assunto_ouvidoria, $corpo_ouvidoria)) {
	smtpmailer($email, 'norepy@ime.usp.br', $assunto_usuario, $corpo_usuario);
	echo 'Mensagem enviada com sucesso!';
}
else {
	echo 'Erro ao enviar a mensagem';
}

?>
