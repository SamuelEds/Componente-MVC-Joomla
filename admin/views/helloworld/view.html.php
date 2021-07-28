<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pdoe ser acessada diretamente.');

class HelloWorldViewHelloWorld extends JViewLegacy{

	//CRIAR VARIÁVEL PARA RECEBER O FORMULÁRIO.
	protected $formulario = null;

	//CRIAR A VARIÁVEL DE REGISTROS.
	protected $item;

	//CRIAR A VARIÁVEL QUE RECEBERÁ O SCRIPT.
	protected $script;

	//CRIAR A VARIÁVEL QUE RECEBERÁ AS PERMISSÕES.
	protected $canDo;

	public function display($tpl = null){

		//OBTER DADOS DO MODELO.

		//OBTER O FORMULÁRIO DO MODELO.
		$this->formulario = $this->get('Form');

		//OBTER DADOS DO MODELO.
		$this->item = $this->get('Item');

		//OBTER OS SCRIPTS.
		$this->script = $this->get('Script');

		//QUAIS PERMISSÕES O ATUAL USUÁRIO POSSUI?? O QUE ELE PODE FAZER?
		//O DOIS ÚLTIMOS PARÂMETROS ESPECIFIAM A VIEW E O ID DO ITEM.
		$this->canDo = JHelperContent::getActions('com_helloworld', 'helloworld', $this->item->id);

		//VERIFICAR ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//LANÇAR UMA EXCEÇÃO
			throw new Exception(implode('\n', $erros), 500);

			//EXIBIR ERROS.
			//JError::raiseError(500, implode('<br/>', $erros));

		}

		//EXIBIR BARRA DE TAREFAS.
		$this->barraTarefas();

		//EXIBIR VIEW.
		parent::display($tpl);
	}

	//CRIAR BOTÕES DE EDIÇÃO NA BARRA DE TAREFAS
	protected function barraTarefas(){

		//OBTER O INPUT DA APLICAÇÃO.
		$input = JFactory::getApplication()->input;

		//VERIFICAR SE ESTÁ SENDO ADICIONADO UM NOVO ITEM (REGISTRO) OU UM ITEM (REGISTRO) EXISTENTE ESTÁ SENDO MODIFICADO.
		$novo = ($this->item->id == 0);

		//CRIAR UM TÍTULO DE ACORDO COM O ITEM.
		if($novo){

			//VERIFICAR A PERMISSÃO PARA NOVOS REGISTROS.
			if($this->canDo->get('core.create')){

				//BOTÃO PARA DE APLICAR ALTERAÇÕES.
				JToolbarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');

				//ADICIONAR UM BOTÃO PARA SALVAR ALTERAÇÕES.
				//NOTE O PARÂMETRO QUE SE REFERE AO CONTROLADOR 'helloworld' E A TASK 'save', FICANDO 'helloworld.save'.
				JToolbarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');

				//SALVAR E CRIAR NOVO REGISTRO.
				JToolbarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

			}

			//EXIBIR UM BOTÃO DE ABORTAR EDIÇÃO, O TÍTULO DO BOTÃO MUDARÁ DE ACORDO COM O REGISTRO (SE FOR NOVO OU EXISTENTE).
			JToolbarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CANCEL');

			//TÍTULO SE FOR UM NOVO REGISTRO.
			$title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW');

		}else{

			//VERIFICAR PERMISSÃO PARA EDITAR.
			if($this->canDo->get('core.edit')){

				//PODE SALVAR NOVOS REGISTROS.
				JToolbarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');

				//ADICIONAR UM BOTÃO PARA SALVAR ALTERAÇÕES.
				//NOTE O PARÂMETRO QUE SE REFERE AO CONTROLADOR 'helloworld' E A TASK 'save', FICANDO 'helloworld.save'.
				JToolbarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');

				//VERIFICAR PERMISSÃO PARA SALVAR E CRIAR NOVOREGISTRO
				if($this->canDo->get('core.create')){

					JToolbarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

				}

			}

			//VERIFICAR PERMISSÃO PARA CRIAR NOVO REGISTRO.
			if($this->canDo->get('core.create')){

				//CRIAR BOTÃO DE CÓPIA.
				JToolbarHelper::custom('helloworld.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);

			}

			//TÍTULO SE FOR UM REGISTRO EXISTENTE.
			$title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT');

			//EXIBIR UM BOTÃO DE ABORTAR EDIÇÃO, O TÍTULO DO BOTÃO MUDARÁ DE ACORDO COM O REGISTRO (SE FOR NOVO OU EXISTENTE).
			JToolbarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CLOSE');
		}


		//ADICIONAR O TÍTULO.
		JToolbarHelper::title($title, 'helloworld');

	}

	//CONFIGURAR O DOCUMENTO NA PARTE DE EDIÇÃO.
	protected function setDocument(){

		//CARREGAR AS DEPENDÊNCIAS NECESSÁRIAS PARA O FUNCIONAMENTO DOS SCRIPTS.
		JHtml::_('behavior.framework');
		JHtml::_('behavior.formvalidator');

		//VERIFICAR SE UM REGISTRO ESTÁ SENDO EDITADO OU CRIADO.
		$novo = ($this->item->id < 1);

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO.
		$documento->setTitle($novo ? JText::_('COM_HELLOWORLD_HELLOWORLD_CREATING') : JText::_('COM_HELLOWORLD_HELLOWORLD_EDITING'));

		//CARREGAR OS SCRIPTS NO DOCUMENTO.
		$documento->addScript(JURI::root() . $this->script);
		$documento->addScript(JURI::root() . '/administrator/components/com_helloworld/views/helloworld/submitbutton.js');

		//CARREGAR A MENSAGEM DE ERRO NO ARQUIVO JAVASCRIPT 'submitbutton.js'.
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');

	}

}

?>