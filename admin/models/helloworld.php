<?php  

//IMPEDIR O ACESSO DIRETO.s
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CLASSE MODELO 'HelloWorld'.

//CLASSE DO MODELO A SR UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelAdmin' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPOS DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelAdmin{

	//MÉTODO PARA OBTER UMA TABELA.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array()){

		//RETORNAR UMA INSTÂNCIA DA TABELA.
		return JTable::getInstance($type, $prefix, $config);

	}

	public function getForm($data = array(), $loadData = true){

		//OBTER O FORMULÁRIO.
		//O MÉTODO 'loadForm()' IRÁ PESQUISAR O FORMULÁRIO NA PASTA DE FORMULÁRIOS. (EM 'admin/models/forms').
		//DEPOIS DO PARÂMETRO 'com_helloworld.helloworld', É INSERIDO O NOME DO FORMULÁRIO NA PASTA DE FORMULÁRIOS CUJO O MODELO VAI TRABALHAR.
		$form = $this->loadForm('com_helloworld.helloworld', 'helloworld', array('control' => 'jform', 'load_data' => $loadData));

		//CASO A VARIÁVEL ESTEJA VAZIA, ELE RETORNARÁ FALSO COMO SENDO UM VALOR VAZIO.
		//OBS: É IMPORTANTE QUE NA COMPARAÇÃO SEJA USADO O 'empty' EM VEZ DO 'isset'.
		if(empty($form)){
			return false;
		}

		//RETORNAR O FORMULÁRIO
		return $form;

	}

	/**
	 * 
	 * MÉTODO PARA OBTER O SCRIPT QUE DEVE SER INCLUÍDO NO FORMULÁRIO.
	 * ESSE MÉTODO SERÁ ARMAZENADO NA VARIÁVEL '$this->script' NA VIEW.
	 * 
	 * */
	public function getScript(){

		return 'administrator/components/com_helloworld/models/forms/helloworld.js';

	}

	protected function loadFormData(){

		//VERIFICAR A SESSÃO PARA DADOS DO FORMULÁRIO INSERIDOS ANTERIORMENTE.
		$dados = JFactory::getApplication()->getUserState('com_helloworld.edit.helloworld.data', array());

		//CASO OS DADOS FOREM OBTIDOS, FARÁ UMA AÇÃO.
		if(empty($dados)){

			//TODOS OS DADOS PASSADOS PELO FORMULÁRIO SERÃO ARMAZENADOS NO ARRAY '$dados'.
			$dados =  $this->getItem();

		}

		//RETORNAR OS DADOS OBTIDOS.
		return $dados;

	}

	//MÉTODO PARA VERIFICAR SE ESTÁ TUDO BEM EM DELETAR UMA MENSAGEM. SUBSTITUI O MÉTODO 'JModelAdmin::canDelete()'.
	protected function canDelete($record){

		if(!empty($record->id)){

			return JFactory::getUser()->authorise('core.delete', 'com_helloworld.helloworld.' . $record->id);

		}

	}

}

?>