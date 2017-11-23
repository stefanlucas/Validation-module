<?php defined('_JEXEC') or die; 

//First get the current document object
$doc = &JFactory::getDocument();

//adds a linked style sheet
$doc->addStyleSheet(JURI::root().'modules/mod_validation/css/style.css');
$doc->addScript(JURI::root().'modules/mod_validation/js/jquery-1.3.2.js');

$jinput = JFactory::getApplication()->input;
$action = $jinput->get('action', null);

if ($action) {
	require(JModuleHelper::getLayoutPath('mod_validation', $action));	
}
else {
	require(JModuleHelper::getLayoutPath('mod_validation', 'default'));
}

?>
