<?php 
defined('_JEXEC') or die('Direct Access to this location is not
allowed.');

require_once("phpmailer/class.phpmailer.php");

$email = $_POST["email"];
$hash = md5(rand(0,1000));

// Conectando banco de dados
$servername = "localhost";
$username = "root";
$password = "webmaster123";
$dbname = "galois";
$table_name = "j456_ouvidoria";

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
	$secret = '6Le64DkUAAAAAOsaWGiEgnDG7yts75uTTbE6IS60';
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);
	if (!$responseData->success) {
		echo 'A verificação de recapcha falhou, tente novamente';
		die();
	}
}
else {
	echo 'Clique na caixa de recaptcha';
	die();
}
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
    	$sql = "INSERT INTO j456_ouvidoria (email, hash, expiration_date)
    	VALUES ('$email', '$hash', (NOW() + INTERVAL 1 DAY))";
    }
    
    // use exec() because no results are returned
   	$conn->exec($sql);

	define('GUSER', 'ouvidoria.ime@gmail.com');	// <-- Insira aqui o seu GMail
	define('GPWD', 'webmaster123');		// <-- Insira aqui a senha do seu GMail
	$corpo 	= "Clique no link abaixo para validar seu e-mail e mandar uma mensagem para a ouvidoria.\n";
	$corpo = $corpo.$juri_root."modules/mod_validation/verify.php";

	function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
		global $error;
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->IsSMTP();		// Ativar SMTP
		$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
		$mail->SMTPAuth = true;		// Autenticação ativada
		$mail->SMTPSecure = 'tls';	// TLS REQUERIDO pelo GMail
		$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
		$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
		$mail->Username = GUSER;
		$mail->Password = GPWD;
		$mail->SetFrom($de, $de_nome);
		$mail->Subject = $assunto;
		$mail->Body = $corpo;
		$mail->AddAddress($para);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else return true;
	}

	if (smtpmailer($email, GUSER, 'Ouvidoria IME-USP', '	Link de validação de e-mail', $corpo)) {
		echo "Link de validação enviado com sucesso! Verifique sua caixa de entrada";
		die();
	}
	if (!empty($error)) echo $error;
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

?>
