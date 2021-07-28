<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

class HelloWorldModelHelloWorlds extends JModelList{

	public function getListQuery(){

		//OBTER O BANCO DE DADOS
		$db = JFactory::getDbo();

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CRIAR A SOLICITAÇÃO.
		$query->select('*')->from('#__olamundo');

		//RETORNAR OS DADOS OBTIDOS.
		return $query;

	}

}

?>