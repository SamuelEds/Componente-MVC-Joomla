<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

/* ARQUIVO MODELO DA VIEW 'category' */

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelList' PARA A VIEW 'form', EXISTEM TAMBÉM OUTROS TIPOs DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'Category' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelCategory extends JModelList{

	public function __construct($config = array()){

		//CONFIGURAR QUAIS CAMPOS PODEM ATUAR COMO FILTROS.
		if(empty($config['filter_fields'])){

			$config['filter_fields'] = array('id', 'texto', 'alias');

		}

		//ENVIAR DADOS PARA O MODELO-PAI.
		parent::__construct($config);
	}

	/*
		IMPORTANTE: É PRECISO QUE SEJA CRIADO UM ARQUIVO '.xml' NA PASTA 'forms' QUE SERÁ A RESPONSÁVEL PELA ENTREGA DE RESULTADOS DO FILTRO. A NOMENCLATURA DO ARQUIVO DEVE SER 'filter_<nome_do_modelo_de_onde_vem_os_filtros>.xml', QUE NESSE CASO, OS FILTROS ESTÃO SENDO EXTRAÍDOS DO MODELO 'Category'. NO ARQUIVO ENCONTRA-SE O MODO DE CONFIGURAÇÃO DO MESMO.
	*/

	//MÉTODO PARA PREENCHER AUTOMATICAMENTE O ESTADO DO MODELO.
	//ESTE MÉTODO DEVE SER CHAMADO UMA VEZ POR INSTANCIAÇÃO E É PROJETADO A SER CHAMADO NA PRIMEIRA CHAMADA AO MÉTODO 'getState()', A MENOS QUE ESTEJA DEFINIDO O MODELO SINALIZADOR DE CONFIGURAÇÃO PARA IGNORAR A SOLICITAÇÃO.
	//OBS: CHAMAR 'getState()' NESTE MÉTODO RESULTARÁ EM RECURSÃO.
	protected function populateState($ordering = null, $direction = null){

		parent::populateState($ordering, $direction);

		//OBTER O APLICATIVO DO SITE
		$aplicativo = JFactory::getApplication('site');

		//OBTER O ID DO ITEM PARA USAR COMO ID DE CATEGORIA. ESSE 'id' É O VALUE ATRIBUTO 'name' NO ARQUIVO 'default.xml' DA VIEW 'category'.
		$catid = $aplicativo->input->getInt('id');

		//SETAR UM STATE PARA O ID DE CATEGORIA.
		//É COMO SE ESTIVESSE PEGANDO DIRETAMENTE UM CAMPO DO BANCO DE DADOS.
		$this->setState('category.id', $catid);

	}

	protected function getListQuery(){

		//OBTER O BANCO DE DADOS.
		$db = JFactory::getDbo();

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//OBTER O ESTADO. ISSO FOI SETADO NA FUNÇÃO 'populateState()'
		$catid = $this->getState('category.id');

		//CONSTRUIR A CONSULTA.
		$query->select('id, texto, alias')->from($db->quoteName('#__olamundo'))->where('catid = ' . $catid);

		//CRIAR UM SISTEMA PARA ORDENAR OS ITEMS BUSCADOS NO BANCO.

		//A ORDENAÇÃO PADRÃO É PELO TEXTO...
		$orderColuna = $this->state->get('list.ordering', 'texto');

		//...EM SENTIDO CRESCENTE.
		$ordemDirecao = $this->state->get('list.direction', 'ASC');

		//FAZER A ORDENAÇÃO NA QUERY.
		$query->order($db->escape($orderColuna) . ' ' . $db->escape($ordemDirecao));

		//RETORNAR A CONSULTA CONSTRUÍDA.
		return $query;
	}

}

?>