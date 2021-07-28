<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CLASSE DE REGRA DE FORMULÁRIO PARA JOOMLA FRAMEWORK.
class JFormRuleTexto extends JFormRule{

	//UMA EXPRESSÃO REGULAR.
	//ISSO É TUDO QUE PRECISA NESSE MOMENTO.
	protected $regex  = '^[^0-9]+$';

}

?>