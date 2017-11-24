<?php
require_once('phpmailer/smtpmailer.php');

$email = $_POST["email"];
$corpo = "E-mail: ".$email."\n"."Nome: ".$_POST["nome"]."\nMensagem: ".$_POST['mensagem'];
$remetente = 'ouvidoria.ime@gmail.com';
$senha = 'webmaster123';
if (smtpmailer($remetente, $remetente, $senha, 'Ouvidoria IME-USP', 'Mensagem da ouvidoria', $corpo)) {
	echo 'Mensagem enviada com sucesso!';
}
else {
	echo 'Erro ao enviar a mensagem';
}
?>
