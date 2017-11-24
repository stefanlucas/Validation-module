<?php 
defined('_JEXEC') or die('Direct Access to this location is not
allowed.');

require_once('phpmailer/smtpmailer.php');

$email = $_POST["email"];
$hash = md5(rand(0,1000));

// banco de dados
$servername = "localhost";
$username = "root";
$password = "webmaster123";
$dbname = "galois";
$table_name = "j456_ouvidoria";

/*if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
	$secret = '6LdCMDoUAAAAAMq3O07L5exZhyD0lSYRY4corAt3';
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);
	dump($responseData);
	if (!$responseData->success) {
		echo 'A verificação de recapcha falhou, tente novamente';
		die();
	}
}
else {
	echo 'Clique na caixa de recaptcha';
	die();
}*/
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo 'E-mail inválido, digite novamente';
	die();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT email, active FROM $table_name WHERE email = '$email'";
    $user = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    
    if ($user['email'] == $email) {
    	if ($user['active']) {
   		echo "mostra message_form";
   		//include 'message_form.php';
    		die();
    	}
    	else {
    		$sql = "UPDATE $table_name SET hash = '$hash', expiration_date=(NOW() + INTERVAL 1 DAY) WHERE email = '$email'";
    	}
    }
    else {
    	$sql = "INSERT INTO $table_name (email, hash, expiration_date)
    	VALUES ('$email', '$hash', (NOW() + INTERVAL 1 DAY))";
    }
    $conn->exec($sql);
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
/* Construindo a mensagem*/
$remetente = 'ouvidoria.ime@gmail.com';
$senha = 'webmaster123';
$corpo 	= "Clique no link abaixo para validar seu e-mail e mandar uma mensagem para a ouvidoria.\n";
$corpo = $corpo.JUri::getInstance()."&action=verify&email=$email&hash=$hash";

/*destinatario, remetente, senha, nome do remetente, assunto, corpo*/
if (smtpmailer($email, $remetente, $senha, 'Ouvidoria IME-USP', 'Link de validação de e-mail', $corpo)) {
	echo "Send ok";
}
else {
	echo "Erro ao enviar a mensagem";
}
?>
