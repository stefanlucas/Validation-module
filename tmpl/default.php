<?php
defined('_JEXEC') or die('Direct Access to this location is not
allowed.');
?>

<script type="text/javascript" language="javascript">

$(function($) {

	// Quando o formulário for enviado, essa função é chamada
	$("#formulario").submit(function() {
		// Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
		var nome = $("#nome").val();
		var email = $("#email").val();		
		var mensagem = $("#mensagem").val();


		// Exibe mensagem de carregamento
		$("#obs").html("<img src='<?php echo JURI::root().'modules/mod_validation/loader.gif'; ?>' alt='Enviando' />");
		// Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
		$.post('<?php echo JURI::root().'modules/mod_validation/contato.php';?>', {nome: nome, email: email, mensagem: mensagem}, function(resposta) {	
				// Quando terminada a requisição
				// Exibe a div status
				$("#obs").slideDown();
				// Se a resposta é um erro
				if (resposta != false) {
					// Exibe o erro na div	
					$("#obs").html(resposta);					
				} 
				// Se resposta for false, ou seja, não ocorreu nenhum erro
				else {
					// Exibe mensagem de sucesso
					$("#obs").html("<font color=#090 size=4px;>Mensagem enviada com sucesso!</font>");
					// Limpando todos os campos
					$("#nome").val("");
					$("#email").val("");					
					$("#mensagem").val("");

				}
		});
	});
});
</script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<div id="box_cadastro">
	<form id="formulario" action="<?php $doc->getBase(); ?>" method="post" >   
	<p>Caso seja a primeira vez que esteja usando este e-mail, enviaremos um link para validá-lo.</p>
	<div id="grupo">
		<label>E-mail:</label>
		<input type="text" name="email" id="email" class="text"  />
	</div>		
	<?php
		if (isset($error)) {
			echo '<span style="color:red">'.$error.'</span><br>';
		}
	?>
	<div id="grupo" style="margin-bottom: 50px">
	<div class="g-recaptcha" data-sitekey="6Le64DkUAAAAANsWDrglmm8Mo6t0Wx6UlGn649Lm"></div>	
	</div>
	<input type="hidden" name="action" value="send_link" />
	<div id="grupo">							
		<div id="bt_envia"><input type="submit" value="ENVIAR" class="btn" /></div>	
	</div>	        
	</form>
</div>