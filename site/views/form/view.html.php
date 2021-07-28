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
	protected $podeFazer;

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO. 
	public function display($tpl = null){

		//OBTER O FORMULÁRIO PARA EXIBIR.
		$this->formulario = $this->get('Form');

		//OBTER O ARQUIVO DE SCRIPT JAVASCRIPT PARA VALIDAÇÃO DO LADO DO CLIENTE.
		$this->script = $this->get('Script');

		//VERIFICAR SE O ATUAL USUÁRIO TEM PERMISSÃO PARA CRIAR UM NOVO REGISTRO.
		$this->podeFazer = JHelperContent::getActions('com_helloworld');

		//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
		if(JLanguageMultilang::isEnabled()){

			//OBTER A TAG DO IDIOMA ATUAL.
			$lang = JFactory::getLanguage()->getTag();

			//FAZER COM QUE A LINGUAGEM ATUAL SEJA A PADRÃO.
			//ESSE CÓDIGO IRÁ SETAR O CAMPO 'language'.
			//O MÉTODO 'stFieldAttribute()' IRÁ SETAR ALGUM ATRIBUTO PARA O CAMPO DESEJADO. OS PARÂMETROS SIGNIFICAM: ('campo_desejado', 'nome_do_atributo', 'valor_do_atributo').
			$this->formulario->setFieldAttribute('language', 'default', $lang);

		}

		//VERIFICAR O ATUAL USUÁRIO PODE CRIAR UMA NOVA MENSAGEM.
		if(!($this->podeFazer->get('core.create'))){

			//OBTER O APLICATIVO.
			$aplicativo = JFactory::getApplication();

			//LANÇAR UMA MENSAGEM DE ERROR PADRÃO DO JOOMLA.
			//AS LETRAS EM MAIÚSCULAS IRÃO SER SUBSTITUÍDAS PELA TRADUÇÃO PADRÃO DO JOOMLA.
			$aplicativo->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR', 'error'));
			$aplicativo->setHeader('status', 400, true); 
		
		}

		//VERIFICAR SE HÁ ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//LANÇAR UM ERRO.
			throw new Exception(implode('<br/>', $erros));

		}

		//EXIBIR AS VIEW.
		parent::display($tpl);

		//CHAMAR O MÉTODO DE SETAR O DOCUMENTO.
		$this->setDocumento();
	}

	//MÉTODO PARA CONFIGURAR O DOCUMENTO HTML.
	public function setDocumento(){

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//SETAR O TÍTULO DO DOCUMENTO.
		$documento->setTitle(JText::_('COM_HELLOWORLD_HELLOWORLD_CREATING'));

		//ADICIONAR AO DOCUMENTO DOIS ARQUIVOS SCRIPTS.
		$documento->addScript(JURI::root() . $this->script);
		$documento->addScript(JURI::root() . "/administrator/components/com_helloworld/views/helloworld/submitbutton.js");

		//ADICIONAR UM TEXTO AO SCRIPT.
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
	}

}

?>