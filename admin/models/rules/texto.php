<?php  

//ESSE ARQUIVO SERÁ USADO PELO SERVIDOR PARA FAZER A VERIFICAÇÃO DE VALIDAÇÃO.

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CLASSE PARA REGRA DE FORMULÁRIO DO FRAMEWORK JOOMLA.
class JFormRuleTexto extends JFormRule{

	//AS FUNÇÕES NECESSÁRIAS JÁ SÃO HERDADAS DE 'JFormRule', TUDO QUE PRECISAMOS É DE UMA EXPRESSÃO REGULAR.

	//DEFININDO UMA EXPRESSÃO REGULAR.
	protected $regex = '^[^\*]+$';
	//protected $regex = '^[^0-9]+$';

}

?>