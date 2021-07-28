<?php 

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CLASSE MODELO 'Form'.

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelAdmin' PARA A VIEW 'form', EXISTEM TAMBÉM OUTROS TIPOs DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'Form' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelForm extends JModelAdmin{

	//MÉTODO PARA OBTER UM OBJETO JTABLE.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array()){

		//RETORNAR UMA INSTÂNCIA DA TABELA.
		return JTable::getInstance($type, $prefix, $config);
	}

	//MÉTODO PARA OBTER UM FORMULÁRIO DE REGISTRO.
	//ESSE MÉTODO DEVE SER OBRIGATÓRIO QUANDO FOR USAR O MODELO 'JModelAdmin'.
	public function getForm($data = array(), $loadData = true){

		//OBTER O FORMULÁRIO.
		//O MÉTODO 'loadForm()' IRÁ PESQUISAR O FORMULÁRIO NA PASTA DE FORMULÁRIOS. (EM 'site/models/forms').
		//DEPOIS DO PARÂMETRO 'com_helloworld.form', É INSERIDO O NOME DO FORMULÁRIO NA PASTA DE FORMULÁRIOS CUJO O MODELO VAI TRABALHAR.
		$formulario = $this->loadForm('com_helloworld.form', 'add-form', array('control' => 'jform', 'load_data' => $loadData));

		//CASO NÃO OBTIVER NENHUM FORMULÁRIO...
		if(empty($formulario)){

			//IRÁ LANÇAR UM ERRO.
			$erros = $this->getErrors();
			throw new Exception(implode('\n', $erros), 500);
			
		}

		//RETORNAR O FORMULÁRIO ENCONTRADO.
		return $formulario;
	}

	//MÉTODO PARA OBTER OS DADOS QUE DEVEM SER INJETADOS NO FORMULÁRIO.
	protected function loadFormData(){

		//VERIFICAR A SESSÃO PARA DADOS DE FORMULÁRIO INSERIDOS ANTERIORMENTE.
		$dados = JFactory::getApplication()->getUserState('com_helloworld.edit.helloworld.data', array());

		//RETORNAR OS DADOS ENCONTRADOS.
		return $dados;

	}

	//MÉTODO PARA OBTER O SCRIPT QUE DEVE SER INCLUÍDO NO FORMULÁRIO.
	//IRÁ RETORNAR O SCRIPT ASSOCIADO À VALIDAÇÃO DE TEXTO DO CAMPO HELLOWORLD
	public function getScript(){

		//IRÁ RETORNAR O SCRIPT.
		return 'administrator/components/com_helloworld/models/form/helloworld.js';
	}

	/**
	 * 
	 * PREPARAR O REGISTRO HELLOWORLD QUANDO FOR SALVAR NO BANCO.
	 * 
	 * NESSA FUNÇÃO TAMBÉM SERÁ DEFINIDO O VALOR DA ORDEM DO NOVO REGISTRO COMO 
	 * 'max + 1', ISSO PARA QUE ELE APAREÇA NO FINAL.
	 * 
	 * */

	protected function prepareTable($table){

		//REORDENE OS REGISTROS DENTRO DA CATEGORIA PARA QUE O NOVO REGISTRO SEJA O PRIMEIRO.
		/*if(empty($table->id)){
			$table->reorder('catid = ' . (int) $table->catid);
		}*/

	}

	//FUNÇÃO PARA LIMPAR O CACHE.
	protected function cleanCache($group = null, $cliente_id = 0){

		parent::cleanCache('com_helloworld');

	}

}

?>