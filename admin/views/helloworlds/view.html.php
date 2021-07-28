<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorlds' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorlds extends JViewLegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO.
	public function display($tpl = null){

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();
		$contexto = 'com_helloworld.list.admin.helloworld';


		/******************************************************************************************/

		//AQUI ENCONTRA-SE VARIÁVEL CUJO NOMES NÃO PODEM SER MODIFICADOS.

		//AS VARIÁVEIS '$this->filter_order' E '$this->filter_order_Dir' IRÃO ARMAZENAR A COLUNA DE CLASSIFICAÇÃO ATIVA E A DIREÇÃO DE CLASSIFICAÇÃO, RESPECTIVAMENTE. ESSAS VARÁVEIS SÃO RECUPERADAS DAS VARIÁVEIS DE ESTADO DO APLICATIVO.
		
		$this->filter_order = $aplicativo->getUserStateFromRequest($contexto.'filter_order', 'filter_order', 'texto', 'cmd');
		$this->filter_order_Dir = $aplicativo->getUserStateFromRequest($contexto.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');

		//IMPORTANTE: O NOME DAS VARIÁVEIS DEVE OBRIGATORIAMENTE ESTAR ESCRITOS COMO MOSTRA ABAIXO.('$this->state', '$this->filterForm', '$this->activeFilters'). JOOMLA NÃO ACEITA QUALQUER TIPO DE NOMENCLATURA.

		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		/******************************************************************************************/

		//PEGAR DADOS DO MODELO.
		//OS MÉTODOS 'getItems' E 'getPagination' JÁ SÃO DEFINIDOS AUTOMATICAMENTE NO MODELO 'JModelList'.
		//'this->get('Items')' E '$this->get('Pagination')' SÃO FUNÇÕES NATIVAS DO MODELO USADO NO ARQUIVO DE MODELO DESTA VIEW, QUE NO CASO É 'helloworlds.php'.
		$this->items = $this->get('Items');

		//FUNÇÃO PARA GERENCIAR OBJETOS DE PAGINAÇÃO.
		$this->paginacao = $this->get('Pagination');

		//CHECAR OS ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//INFORMAR OS ERROS NA TELA.
			JError::raiseError(500, implode('<br/>', $erros));

			return false;
		}

		//ADICIONAR BARRA DE TAREFAS NO BACK-END E EXIBIR O NÚMERO DE ITENS ENCONTRADOS.
		$this->barraTarefas();

		//EXIBIR A VIEW.
		parent::display($tpl);

		//SETAR CONFIGURAÇÕES PARA O DOCUMENTO.
		$this->setDocumento();
	}

	//ADICIONAR TÍTULO E BARRA DE TAREFAS.
	protected function barraTarefas(){

		//CRIAR UMA VARIÁVEL COM O TÍTULO PADRÃO QUE SERÁ ARMAZENADA NO TÍTULO.
		$titulo = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS');

		if($this->paginacao->total){

			$titulo .= '<span style="font-size: 0.5em; vertical-align: middle;">'. $this->paginacao->total .'</span>';

		}

		//ADICIONAR UM TÍTULO
		JToolbarHelper::title($titulo, 'helloworld');

		//ADICIONAR UM BOTÃO DE 'Novo'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworld' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'add', FICANDO 'helloworld.add'.
		JToolbarHelper::addNew('helloworld.add');

		//ADICIONAR UM BOTÃO DE 'Editar'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworld' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'edit', FICANDO 'helloworld.edit'.
		JToolbarHelper::editList('helloworld.edit');

		//ADICIONAR UM BOTÃO DE 'Deletar'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworlds' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'delete', FICANDO 'helloworlds.delete'.
		JToolbarHelper::deleteList('', 'helloworlds.delete');

	}

	//CONFIGURAR O DOCUMENTO
	protected function setDocumento(){

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO DO DOCUMENTO.
		$documento->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION'));


	}

}

?>