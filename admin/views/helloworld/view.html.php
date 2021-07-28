<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pdoe ser acessada diretamente.');

class HelloWorldViewHelloWorld extends JViewLegacy{

	//CRIAR VARIÁVEL PARA RECEBER O FORMULÁRIO.
	protected $formulario = null;

	public function display($tpl = null){

		//OBTER DADOS DO MODELO.

		//OBTER O FORMULÁRIO DO MODELO.
		$this->formulario = $this->get('Form');

		//OBTER DADOS DO MODELO.
		$this->item = $this->get('Item');

		//VERIFICAR ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//EXIBIR ERROS.
			JError::raiseError(500, implode('<br/>', $erros));

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

			//TÍTULO SE FOR UM NOVO REGISTRO.
			$title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW');

		}else{

			//TÍTULO SE FOR UM REGISTRO EXISTENTE.
			$title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT');

		}

		//ADICIONAR O TÍTULO.
		JToolbarHelper::title($title, 'helloworld');

		//ADICIONAR UM BOTÃO PARA SALVAR ALTERAÇÕES.
		//NOTE O PARÂMETRO QUE SE REFERE AO CONTROLADOR 'helloworld' E A TASK 'save', FICANDO 'helloworld.save'.
		JToolbarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');

		//EXIBIR UM BOTÃO DE ABORTAR EDIÇÃO, O TÍTULO DO BOTÃO MUDARÁ DE ACORDO COM O REGISTRO (SE FOR NOVO OU EXISTENTE).
		JToolbarHelper::cancel('helloworld.cancel', $novo ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

	}

	//CONFIGURAR O DOCUMENTO NA PARTE DE EDIÇÃO.
	protected function setDocument(){

		//VERIFICAR SE UM REGISTRO ESTÁ SENDO EDITADO OU CRIADO.
		$novo = ($this->item->id < 1);

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO.
		$documento->setTitle($novo ? JText::_('COM_HELLOWORLD_HELLOWORLD_CREATING') : JText::_('COM_HELLOWORLD_HELLOWORLD_EDITING'));

	}

}

?>