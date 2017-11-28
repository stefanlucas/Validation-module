<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
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

<div id="box_cadastro">
  <?php
    if (isset($message)) 
      echo $message;
  ?>
  <form id="formulario" action="<?php echo JUri::getInstance(); ?>" method="post">   
        
  <div id="grupo">
    <label>Nome: </label>
    <input type="text" name="nome" id="nome" class="text"  />
  </div>    
                        
  <div id="grupo_mensagem"> 
    <label>*Mensagem:</label>
    <textarea name="mensagem" id="mensagem" rows="4" cols="40" class="text8"></textarea>
  </div>    
  <?php
      echo '<input type="hidden" name="email" value="'.$email.'">'
  ?>
  <?php
    if (isset($error)) {
      echo '<span style="color:red">'.$error.'</span><br>';
    }
  ?>  
  <input type="hidden" name="action" value="send_mail" />
  <div id="grupo">              
    <div id="obs">*Campo obrigatório.</div> 
    <div id="bt_envia"><input type="submit" value="ENVIAR" class="btn" /></div> 
  </div>                  
  </form>
</div>
