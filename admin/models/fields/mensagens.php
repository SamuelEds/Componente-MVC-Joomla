<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CARREGAR UM TIPO DE CAMPO.
JFormHelper::loadFieldClass('list');

//INICIAR A CLASSE 'JFormField'.
//OBSERVE QUE O SUFIXO 'Mensagens' PRECISA SER O MESMO TIPO DO QUE O DEFINIDO NO 'type' DA FIELD DO ARQUIVO 'default.xml'
class JFormFieldMensagens extends JFormFieldList{

	//INFORMARA REFERÊNCIA PARA O TIPO DE CAMPO.
	protected $type = 'Mensagens';

	//ESSA FUNÇÃO ESPECÍFICA SERVE PARA CRIAR UMA LISTA SUSPENSA PARA UMA ENTRADA DE LISTA, OU SEJA, CRIA BASICAMENTE UM SELECT-OPTION.
	protected function getOptions(){

		//OBTER O BANCO DE DADOS.
		$db = JFactory::getDbo();

		//INICIAR A QUERY.
		$query = $db->getQuery(true);

		//CRIAR A SOLICITAÇÃO.

		/*

		NOTE COMO A SOLICITAÇÃO É FEITA, ISSO BASICAMENTE SERIA: 

		'SELECT #__olamundo.id as id, #__olamundo.texto as texto #__olamundo.catid as catid, #__categories.title as categoria FROM #__olamundo LEFT JOIN #__categories ON catid = #__categories.id WHERE published = 1'.

		*/
		$query->select('#__olamundo.id as id, #__olamundo.texto as texto, #__olamundo.catid as catid, #__categories.title as categoria');

		//ESPECIFICAR A PRIMEIRA TABELA DO BANCO DE DADOS.
		$query->from('#__olamundo');

		//CRIAR UM JOIN DA PRIMEIRA TABELA COM A TABELA DE CATEGORIAS PADRÃO DO JOOMLA.
		$query->leftJoin('#__categories on catid = #__categories.id');

		//VISUALIZAR SOMENTE ITENS PUBLICADOS.
		$query->where('#__olamundo.published = 1');

		//SETAR A QUERY NO BANCO DE DADOS
		$db->setQuery((string) $query);

		//ARMAZENAR OS DADOS OBTIDOS NA VARIÁVEL '$mensagens'. NOTE COMO É CARREGADO ATRAVÉS DA FUNÇÃO 'loadObjectList()', ISSO SIGNIFICA QUE ELE IRÁ OBTER OS DADOS DO BANCO EM FORMA DE OBJETOS.
		$mensagens = $db->loadObjectList();

		//CRIANDO UM ARRAY DE OPÇÕES
		$options = array();

		//CASO HOUVR DADOS RECUPERADOS, IRÁ FAZER UMA AÇÃO.
		if($mensagens){

			//CRIAR A LISTA DE OPÇÕES ATRAVÉS DEUM 'foreach'
			foreach ($mensagens as $dados) {

				//NOTE COMO AS OPÇÕES SÃO CRIADAS, ATRAVÉS DA FUNÇÃO JOOMLA 'JHtml_()'
				//OS PARÂMETROS DESSA FUNÇÃO SÃO: JHtml_('campo.javascript.definido', value, conteúdo_do_campo).
				//NOTE COMO É INFORMADO AS CATEGORIAS DE ACORDO COM CADA ITEM. ELE ESTÁ SENDO EXECUTADO COMO UMA CONDIÇÃO TERNÁRIA, QUE SE HOUVER ALGUMA CATEGORIA CADASTRADA, ELE EXIBIRÁ DE ACORDO COM CADA ITEM, SENÃO ENTÃO ELE APENAS FICARÁ EM BRANCO.
				$options[] = JHtml::_('select.option', $dados->id, $dados->texto . ' ' . ($dados->catid ? JText::_('JCATEGORY') .': (' . $dados->categoria . ')' : 'Sem categoria'));
			}
		}

		//FUNÇÃO 'array_merge' IRÁ COMBINAR UM OU MAIS ARRAYS.
		$options = array_merge(parent::getOptions(), $options);

		//RETORNAR AS OPÇÕES CRIADAS
		return $options;
	}

}

?>