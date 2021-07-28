<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

/* CLASSE DE DEFINIÇÃO PARA 'HelloworldCategories' */

class HelloworldCategories extends JCategories{

	public function __construct($options = array()){

		//INFORMAR QUAL A TABELA DO BANCO DE DADOS QUE ESTÁ ASSOCIADO COM A TAABELA DE CATEGORIAS PADRÃO DO JOOMLA. 
		$options['table'] = '#__olamundo';

		//INFORMAR QUAL COMPONENTE A API DE CATEGORIAS DO JOOMLA VAI TRABALHAR.
		$options['extension'] = 'com_helloworld';

		parent::__construct($options);
	}

}


?>