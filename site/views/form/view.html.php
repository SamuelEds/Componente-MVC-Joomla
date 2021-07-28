<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//ARQUIVO QUE SERÁ A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorld' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewForm extends JViewLegacy{

	//CRIAR VARIÁVEIS

	//ESTA VARIÁVEL IRÁ RECEBER O FORMULÁRIO.
	protected $formulario = null;

	//ESTA VARIÁVEL SERÁ RESPONSÁVEL PELO CONTROLE DE VRIFICAÇÃO DE PERMISSÕES.
	protected $canDo = null;

	public function display($tpl = null){

		//OBTER O FORMULÁRIO PARA EXIBIR.
		$this->formulario = $this->get('Form');

		//OBTER O ARQUIVO SCRIPT JAVASCRIPT PARA FAZER A VALIDAÇÃO NO LOADO DO FRONT-END.
		$this->script = $this->get('Script');

		//OBTER AS PERMISSÕES DO USUÁRIO.
		$this->canDo = JHelperContent::getActions('com_helloworld');

		//VERIFICAR SE O USUÁRIO TEM PERMISSÃO DE CRIAR UM NOVO REGISTRO.
		if(!$this->canDo->get('core.create')){

			//OBTER O APLICATIVO.
			$aplicativo = JFactory::getApplication();

			//EXIBIR UMA MENSAGEM DE AVISO QUE SERVE COMO UM ALERT BOOTSTRAP.
			$aplicativo->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
			$aplicativo->setHeader('status', 403, true);
			return;

		}

		//CHECAR OS ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//LANÇAR UM EXCEPTION.
			throw new Exception(implode('\n', $erros), 500);

		}

		//EXIBIR A VIEW
		parent::display($tpl);

		//SETAR CONFIGURAÇÕES PARA O DOCUMENTO.
		$this->setDocumento();
	}

	//SETAR CONFIIGURAÇÕES PARA O DOCUMENTO.
	protected function setDocumento(){

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO DO DOCUMENTO.
		$documento->setTitle(JText::_('COM_HELLOWORLD_HELLOWORLD_CREATIONS'));

		//ADICIONAR OS DOIS SCRIPTS NO DOCUMENTO.
		$documento->addScript(JURI::root() . $this->script);
		$documento->addScript(JURI::root() . '/administrator/components/com_helloworld'
										   . '/views/helloworld/submitbutton.js');

		//ADICIONAR UM TEXTO AO SCRIPT.
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');

	}

}

?>