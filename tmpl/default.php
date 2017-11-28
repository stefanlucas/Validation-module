<?php
defined('_JEXEC') or die('Direct Access to this location is not
allowed.');

if (!isset($email)) {
	$email = "";
}
?>

<script type="text/javascript" language="javascript">
$(function($) {
	// Quando o formulário for enviado, essa função é chamada
	$("#formulario").submit(function() {
		// Exibe mensagem de carregamento
		$("#obs").html("<img src='<?php echo JURI::root().'modules/mod_validation/tmpl/loader.gif'; ?>' alt='Enviando' />");
	});
});
</script>

<script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
<div id="box_cadastro">
	<form id="formulario" action="<?php echo JUri::getInstance(); ?>" method="post" >   
	<p>Caso seja a primeira vez que esteja usando este e-mail, enviaremos um link para validá-lo.</p>
	<div id="grupo">
		<label>E-mail:</label>
		<input type="text" name="email" id="email" class="text" value="<?php echo $email?>"/>
	</div>		
	<?php
		if (isset($error)) {
			echo '<span style="color:red">'.$error.'</span><br>';
		}
	?>
	<div id="grupo" style="margin-bottom: 50px">
	<div class="g-recaptcha" data-sitekey="6LdCMDoUAAAAAHMT3uyda5FQV-GUXFDhA-J74fNh"></div>	
	</div>
	<input type="hidden" name="action" value="send_link" />	
	<div id="grupo">							
		<div id="bt_envia"><input type="submit" value="ENVIAR" class="btn" /></div>	
	</div>
	<div id="obs"></div> 	        
	</form>
</div>
