<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorlds' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorlds extends JViewLegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO.
	public function display($tpl = null){

		//OBTER O APLICATIVO JOOMLA.
		$aplicativo = JFactory::getApplication();

		//ARMAZENAR UM CONTEXTO PARA SER USADO DEPOIS.
		//$contexto = "helloworld.list.admin.helloworld";

		//PEGAR DADOS DO MODELO.

		//------------------------------------------------------------\\

		//AQUI ENCONTRA-SE VARIÁVEL CUJO NOMES NÃO PODEM SER MODIFICADOS.

		//AS VARIÁVEIS '$this->filter_order' E '$this->filter_order_Dir' IRÃO ARMAZENAR A COLUNA DE CLASSIFICAÇÃO ATIVA E A DIREÇÃO DE CLASSIFICAÇÃO, RESPECTIVAMENTE. ESSAS VARÁVEIS SÃO RECUPERADAS DAS VARIÁVEIS DE ESTADO DO APLICATIVO.
		
		//$this->filter_order = $aplicativo->getUserStateFromRequest($contexto.'filter_order', 'filter_order', 'texto', 'cmd');
		//$this->filter_order_Dir = $aplicativo->getUserStateFromRequest($contexto.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');

		//IMPORTANTE: O NOME DAS VARIÁVEIS DEVE OBRIGATORIAMENTE ESTAR ESCRITOS COMO MOSTRA ABAIXO.('$this->state', '$this->filterForm', '$this->activeFilters'). JOOMLA NÃO ACEITA QUALQUER TIPO DE NOMENCLATURA.

		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		//QUAIS PERMISSÕES ESTE USUÁRIO (ATIVO NO MOMENTO) POSSUI? O QUE ELE PODE FAZER?
		//A CLASSE 'JHelperContent' É USADA PARA ENCONTRAR AS PERMISSÕES.
		$this->canDo = JHelperContent::getActions('com_helloworld');

		//------------------------------------------------------------\\

		//PEGAR DADOS DO MODELO.
		//OS MÉTODOS 'getItems' E 'getPagination' JÁ SÃO DEFINIDOS AUTOMATICAMENTE NO MODELO 'JModelList'.
		//'this->get('Items')' E '$this->get('Pagination')' SÃO FUNÇÕES NATIVAS DO MODELO USADO NO ARQUIVO DE MODELO DESTA VIEW, QUE NO CASO É 'helloworld.php'.
		$this->items = $this->get('Items');
		
		//FUNÇÃO PARA GERENCIAR OBJETOS DE PAGINAÇÃO.
		$this->paginacao = $this->get('Pagination');

		//FAZER UMA VERIFICAÇÃO DE ERRORS.
		if(count($errors = $this->get('Errors')) > 0){
			//INFORMAR OS ERROS NA TELA.
			JError::raiseError(500, implode('<br/>', $errors));
			return false;
		}

		//DEFINE O SUBMENU E A BARRA DE FERRAMENTAS D BARRA LATERAL, MAS NÃO DA JANELA MODAL.
		if($this->getLayout() !== "modal"){
		
			//DEFINIR O SUBMENU.
			HelloWorldHelper::addSubmenu('helloworlds');
			
			//CHAMADA PARA CRIAR A BARRA DE TAREFAS E O NÚMERO DE ITEMS ENCONTRADOS. 
			$this->barraTarefas();

		}else{

			//SE ESTIVER SENDO EXIBIDO PARA SELECIONAR UM REGISTRO COMO UMA ASSOCIAÇÃO, ENTÃO 'forceLanguage' É DEFINIDO.
			if($forcarIdioma = $aplicativo->input->get('forcedLanguage', '', 'CMD')){

				//CRIAR UM XML SIMPLES.
				$languageXML = new SimpleXMLElement('<field name="language" type="hidden" default="'. $forcarIdioma .'" />');
				$this->filterForm->setField($languageXML, 'filter', true);

				//DESATIVAR O FILTRO DE IDIOMA ATIVO PARA QUE AS FERRAMENTAS DE PESQUISA NÃO SEJAM ABERTAS POR PADRÃO COM ESTE FILTRO.
				unset($this->activeFilters['language']);
			}
		}

		//PREPARAR O MAPEAMENTO DO ID PAI PARA O ID's DE SEUS FILHOS.
		$this->ordering = array();

		foreach($this->items as $item){

			$this->ordering[$item->parent_id][] = $item->id;

		}

		//EXIBIR A VIEW.
		parent::display($tpl);

		//SETAR O DOCUMENTO
		$this->setDocumento();
	}

	//CRIAR UMA BARRA DE TAREFAS.
	protected function barraTarefas(){

		//INSTANCIAR A BARRA DE TAREFAS.
		//ISSO É NECESSÁRIO POIS O BOTÃO DE 'PROCESSO EM LOTE' É PERSONALIZÁVEL E NÃO PODE SIMPLESMENTE CHAMAR O MÉTODO 'JToolbarHelper'.
		$barra = JToolbar::getInstance('toolbar');

		//ARMAZENAR O TÍTULO EM UMA VARIÁVEL.
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		$titulo = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS');

		//AQUI VAI MOSTRAR O NÚMERO DE REGISTROS AO LADO DO TÍTULO.
		if($this->paginacao->total){
			$titulo .= "<span style='font-size: 0.5em; vertical-align: middle;'>(".$this->paginacao->total.")</span>";
		}

		//OBSERVE OS ARGUMENTOS ENTRE PARÊNTESES, ELES SERVEM PARA DEFINIR UMA INSTÂNCIA USADA PELO CONTROLADOR PARA FAZER UMA AÇÃO QUANDO O USUÁRIO APERTAR NO BOTÃO.
		//CADA PARÂMETRO É CRIADO COMO '...('nome_do_controlador.task')'.

		//DEFINIR UM TÍTULO.
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		JToolbarHelper::title($titulo);

		//VERIFICAR SE O USUÁRIO ATUAL (USUÁRIO LOGADO) TEM PERMISSÃO DE CRIAR UM NOVO ITEM.
		if($this->canDo->get('core.create')){
			
			//DEFINIR O BOTÃO DE 'Novo'.
			//AQUI O NOME DO CONTROLADOR É 'helloworld' E A TASK É 'add'
			JToolbarHelper::addNew('helloworld.add');
		}


		//VERIFICAR SE O USUÁRIO ATUAL (USUÁRIO LOGADO) TEM PERMISSÃO DE EDITAR UM ITEM.
		if($this->canDo->get('core.edit')){

			//DEFINIR UM BOTÃO PARA EDITAR.
			//AQUI O NOME DO CONTROLADOR É 'helloworld' E A TASK É 'edit'
			JToolbarHelper::editList('helloworld.edit');
		}

		//VERIFICAR SE O USUÁRIO ATUAL (USUÁRIO LOGADO) TEM PERMISSÃO DE DELETAR UM ITEM.
		if($this->canDo->get('core.delete')){

			//DEFINIR UM BOTÃO PARA DELETAR.
			//AQUI O NOME DO CONTROLADOR É 'helloworlds' E A TASK É 'delete'
			//AQUI USA OUTRO CONTROLADOR, POR QUE ELE É ESPECÍFICO PARA ESSA VIEW, JÁ QUE É UM CONTROLE DE EXCLUSÃO DE UM ITEM.
			JToolbarHelper::deleteList('','helloworlds.delete');
		}

		//VERIFICAR SE O USUÁRIO ATUAL (USUÁRIO LOGADO) TEM PERMISSÃO DE EDITAR UM ITEM.
		if($this->canDo->get('core.edit')){

			//DEFINIR UM BOTÃO PARA FAZER O CHECKIN DE UM REGISTRO.
			JToolbarHelper::checkin('helloworlds.checkin');

		}

		//ADICIONAR O BOTÃO DE PROCESSO EM LOTE.
		if($this->canDo->get('core.create') && $this->canDo->get('core.edit') && $this->canDo->get('core.edit.state')){

			//USAMOS UM LAYOUT JOOMLA PADRÃO PARA OBTER O HTML PARA O BOTÃO DE LOTE.
			$layout = new JLayoutFile('joomla.toolbar.batch');

			//OBTER A RENDERIZAÇÃO HTML DO BOTAO.
			$botaoHtmlLote = $layout->render(array('title' => JText::_('JTOOLBAR_BATCH')));

			//ADICIONAR O BOTÃO NA BARRA.
			$barra->appendButton('Custom', $botaoHtmlLote, 'batch');

		}

		//ADICIONAR O BOTÃO DE OPÇÕES NA BARRA DE FERRAMENTAS QUANDO O USUÁRIO ESTIVER AUTORIZADO PARA ISSO.
		//VERIFICAR SE O USUÁRIO ATUAL (USUÁRIO LOGADO) TEM PERMISSÃO DE ADICIONAR UM NOVO ITEM.
		if($this->canDo->get('core.admin')){

			//CRIAR UMA BARRA DE PREFERÊNCIAS. (CRIAR BOTÃO DE OPÇÕES).
			JToolbarHelper::preferences('com_helloworld');

			//CRIAR UM DIVISOR NA BARRA DE TAREFAS.
			JToolbarHelper::divider();
		}


	}

	//MÉTODO PARA SETAR AS PROPRIEDADES DO DOCUMENTO.
	public function setDocumento(){

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO DO NAVEGADOR.
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		$documento->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION'));
	}

}

?>