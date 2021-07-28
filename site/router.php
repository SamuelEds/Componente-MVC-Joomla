<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die;

//ARQUIVO DE ROTEAMENTO DO COMPONENTE HELLOWORLD.

//CLASSE DE ROTEAMENTO DO COMPONENTE.
//OBSERVE A NOMENCLATURA DA CLASSE. SEGUE O PADRÃO '<nome_do_componente>Router'.
//ESTÁ IMPLEMENTADO A INTERFACE 'JComponentRouterInterface' PARA FAZER A MANIPULAÇÃO DO ROTEAMENTO DE COMPONENTE PADRÃO DO JOOMLA.
class HelloWorldRouter implements JComponentRouterInterface{

	public function build(&$query){

		$segmentos = array();

		if(isset($query['id'])){

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR A QUERY.
			$qr = $db->getQuery(true);

			//CRIAR A CONSULTA.
			$qr->select('alias')->from('#__olamundo')->where('id = ' . $db->quote($query['id']));

			//SETAR A QUERY
			$db->setQuery($qr);

			//OBTER A LISTA DE ALIAS DO BANCO DE DADOS.
			$alias = $db->loadResult();

			$segmentos[] = $alias;

			unset($query['id']);
		}

		unset($query['view']);
		
		return $segmentos;

	}

	public function parse(&$segments){

		$vars = array();

		//OBTER O BANCO DE DADOS
		$db = JFactory::getDbo();

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CONSTRUIR A CONSULTA.
		$query->select('id')->from('#__olamundo')->where('alias = ' . $db->quote($segments[0]));

		//SETAR A QUERY.
		$db->setQuery($query);

		//CARREGAR OS ID's DO BANCO DE DADOS.
		$id = $db->loadResult();

		if(!empty($id)){

			$vars['id'] = $id;
			$vars['view'] = 'helloworld';

		}

		return $vars;

	}

	//FUNÇÃO QUE SERÁ CAHAMADA PRIMEIRO.
	public function preprocess($query){

		//PEGAR A URL (QUERY - 'id, view, itemid, etc').
		return $query;

	}

}

?>