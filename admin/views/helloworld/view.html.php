<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorlds' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorld extends JViewLegacy{

	//CRIAR A VARIÁVEL QUE RECEBERÁ O FORMULÁRIO DE VISUALIZAÇÃO.
	protected $form = null;
	
	//CRIAR A VARIÁVEL DE REGISTROS.
	protected $item;

	//CRIAR A VARIÁVEL QUE RECEBERÁ O SCRIPT.
	protected $script;

	//CRIAR A VARIÁVEL QUE RECEBERÁ AS PERMISSÕES.
	protected $canDo;

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO.
	public function display($tpl = null){

		//OBTER OS DADOS DO MODELO PERTENCENTE A ESTA VIEW.

		//OBTER O FORMULÁRIO DO MODELO.
		$this->formulario = $this->get('Form');
		$this->items = $this->get('Item');

		//AQUI SERÁ A VARIÁVEL RESPONSÁVEL POR CARREGAR SCRIPTS DO PROJETO.
		$this->script = $this->get('Script');

		//QUAIS PERMISSÕES O ATUAL USUÁRIO POSSUI?? O QUE ELE PODE FAZER?
		//O DOIS ÚLTIMOS PARÂMETROS ESPECIFIAM A VIEW E O ID DO ITEM.
		$this->canDo = JHelperContent::getActions('com_helloworld', 'helloworld', $this->items->id);

		//VERIFICAR SE EXISTEM ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//EXIBIR OS ERROS.
			JError::raiseError(500, implode('<br/>', $erros));
			return false;
		}

		//ADICIONAR A BARRA DE FERRAMENTAS
		$this->adicionarBarraFerramentas();

		//EXIBIR A VIEW.
		parent::display($tpl);

		//SETAR AS PROPRIEDADES DO DOCUMENTO.
		$this->setDocumento();
	}

	//FUNÇÃO PARA ADICIONAR BARRA DE FERRAMENTAS.
	protected function adicionarBarraFerramentas(){


		//OCULTAR O MENU PRINCIPAL. (ESSE NEGÓCIO É CHATO, POR ISSO TÁ COMENTADO, MAS SE QUISER USA AÍ.)
		//$aplicativo = JFactory::getApplication()->input;
		//$aplicativo->set('hidemainmenu', true);

		//VERIFICAR SE FOI ADICIONADO UM NOVO REGISTRO. (VALOR: TRUE OU FALSE).
		$itemNovo = ($this->items->id == 0);

		//ADICIONAR UM TÍTULO DE 'Novo Registro' CASO FOR CRIADO UM NOVO REGISTRO OU ADICIONAR UM TÍTULO DE 'Editar Registro' CASO FOR FORNECIDO PARA EDITAR UM REGISTRO EXISTENTE CONFORME A CONDIÇÃO TERNÁRIA.
		JToolbarHelper::title($itemNovo ? JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW') : JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT'), 'helloworld');

		//CRIAR ALGUMAS AÇÕES PARA REGISTROS NOVOS E EXISTENTES.
		if($itemNovo){

			//PARA NOVOS REGISTROS, VERIFIQUE A PERMISSÃO DE CRIAR UM ITEM.
			if($this->canDo->get('core.create')){

				JToolbarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');

				//EXIBIR UM BOTÃO DE SALVAR.
				JToolbarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');
				JToolbarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}

			//EXIBIR UM BOTÃO DE CANCELAR.
			JToolbarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CANCEL');

		}else{

			//PARA REGISTROS EXISTENTES, VERIFIQUE A PERMISSÃO DE EDIÇÃO.
			if($this->canDo->get('core.edit')){

				//PODE SALVAR O NOVO REGISTRO.
				JToolbarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
				JToolbarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');

				//PODE SALVAR O REGISTRO, MAS VERIFICAR SE TEM PERMISSÃO DE CRIAR NOVO REGISTRO.
				if($this->canDo->get('core.create')){

					JToolbarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

				}
			}

			//VERIFICAR SE TEM PERMISSÃO DE CRIAR NOVO REGISTRO.
			if($this->canDo->get('core.create')){

				//CRIAR BOTÃO DE SALVAR E COPIAR.
				JToolbarHelper::custom('helloworld.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			JToolbarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CLOSE');
		}
	}

	//MÉTODO PARA CONFIGURAR AS PROPRIEDADES DO DOCUMENTO.
	public function setDocumento(){

		//SAÍDAS HTML PARA CARREGAR O SCRIPT DE VALIDAÇÃO.
		//ESSES DOIS COMANDOS SÃO ESSECIAIS, POIS PERMITEM QUE OS SCRIPTS SEJAM CARREGADOS PRIMEIRO DO QUE OS SCRIPTS NATIVOS DO JOOMLA E QUE NÃO OCORRA ERROS DURANTE ESSE PROCESSO.
		JHtml::_('behavior.framework');
		JHtml::_('behavior.formvalidator');
		
		//VERIFICAR SE UM ITEM NOVO FOI ADICIONADO.
		$itemNovo = ($this->items->id == 0);

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//MUDAR O TÍTULO DO DOCUMENTO.
		$documento->setTitle($itemNovo ? JText::_('COM_HELLOWORLD_HELLOWORLD_CREATING') : JText::_('COM_HELLOWORLD_HELLOWORLD_EDITING'));
		
		//ADICIONAR AO DOCUMENTO DOIS ARQUIVOS SCRIPTS.
		$documento->addScript(JURI::root() . $this->script);
		$documento->addScript(JURI::root() . "/administrator/components/com_helloworld"."/views/helloworld/submitbutton.js");

		//ADICIONAR TEXTO AO SCRIPT.
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');

		/*
			ESSA VIEW AGORA:
			- VERIFICA SE NÃO TEM ERROS NO MODELO.
			- ADICIONA DOIS ARQUIVOS SCRIPT.
			- INJETA TRADUÇÃO DE JAVASCRIPT USANDO O COMANDO 'JText::script()'.
		*/
	}
}

?>