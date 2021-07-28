<?php  

//IMPEDIR O ACESSO DIRETO.s
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//IMPORTAR A CLASSE 'Registry'.
use Joomla\Registry\Registry;

//CLASSE MODELO 'HelloWorld'.

//CLASSE DO MODELO A SR UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelAdmin' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPOS DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelAdmin{

	/* MÉTODO PARA SUBSTITUIR O 'getItem()' PARA PERMITIR CONVERTER AS INFORMAÇÕES A IMAGEM CODIFICADA EM JSON NO REGISTRO DO BANCO DE DADOS EM UMA MATRIZ PARA O PRÉ-PREENCHIMENTO SUBSEQUENTE DO FORMULÁRIO DE EDIÇÃO. */
	public function getItem($pk = null){

		//OBTER A FUNÇÃO PAI 'getItem()'.
		$item = parent::getItem($pk);

		//VERIFICAR SE EXISTE ALGUM CAMPO CUJO O ATRIBUTO 'name' TEM O VALOR 'image' COMO INFORMADO ABAIXO.
		//LEMBRE-SE QUE ESSE MODELO IRÁ PESQUISAR OS CAMPOS (FIELDS) NO ARQUIVO XML DO FORMULÁRIO, QUE É O 'helloworld.xml' DA PASTA 'forms'.
		if($item && property_exists($item, 'image')){

			//CRIAR UM NOVO REGISTRO DE DADOS.
			//NOTE O PARÂMETRO '$item->image', CUJO 'image' É O VALUE DO ATRIBUTO 'name' DE UM DOS CAMPOS (FIELDS) DO FORMULÁRIO NO ARQUIVO XML.
			$registro = new Registry($item->image);

			//O MESMO CONCEITO SEGUE PARA ESTE CUJO O VALUE É 'image-info', PORÉM O TRAÇO NÃO VALE AQUI, FICANDO 'imageinfo'.
			$item->imageinfo = $registro->toArray();

		}

		return $item;

	}

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

	/*
	
		MÉTODO PARA SUBSTITUIR A FUNÇÃO 'save()' DO 'JModelAdmin' PARA LIDAR COM O 'Salvar como cópia' CORRETAMENTE.

		* '$dados' - OS DADOS DO REGISTRO HELLOWORLD ENVIADOS A PARTIR DO FORMULÁRIO. 
	
	*/
	public function save($data){

		//OBTER O INPUT DA APLICAÇÃO.
		$input = JFactory::getApplication()->input;

		//IMPORTAR O ARQUIVO 'categories.php' E FAZER COM QUE SEJA UTILIZÁVEL A CLASSE 'CategoriesHelper'.
		//É ASSIM QUE TAMBÉM UTILIZAMOS OUTRAS CLASSE COMO 'JFactory', 'JRegistry', ENTRE OUTROS.
		JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/categories.php');

		if((int) $data['catid'] > 0){

			$data['catid'] = CategoriesHelper::validateCategoryId($data['catid'], 'com_helloworld');

		}

		//ALTERE O TEXTO E O ALIAS PARA SALVAR COMO CÓPIA.
		if($input->get('task') == 'save2copy'){

			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));

			if($data['texto'] == $origTable->texto){

				//A FUNÇÃO 'generateNewTitle()' FAZ COM QUE O JOOMLA SUPORTE A ADIÇÃO DE NÚMERO E NO TÍTULO E NO ALIAS ATÉ ENCONTRAR UMA COMBINAÇÃO ATÉ ONDE A COMBINAÇÃO DE ALIAS + CATEGORIA NÃO EXISTA NO BANCO DE DADOS.
				//A FUNÇÃO 'list' CRIA VARIÁVEIS COMO SE FOSSEM ARRAYS.
				list($texto, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['texto']);
				$data['texto'] = $texto;
				$data['alias'] = $alias;

			}else{

				if($data['alias'] == $origTable->alias){


					$data['alias'] = '';

				}

			}

			//A PRÁTICA PADRÃO DO JOOMLA É DEFINIR O NOVO REGISTRO COMO NÃO PUBLICADO.
			$data['published'] = 0;

		}

		//SALVAR OS DADOS NORMALMENTE.
		return parent::save($data);

	}

	//MÉTODO PARA VERIFICAR SE ESTÁ TUDO BEM PARA EXCLUIR UMA MENSAGEM. SUBSTITUI 'JModelAdmin::canDelete'.
	/*protected function canDelete($registro){

		if(!empty($registro->id)){

			return JFactory::getUser()->authorise('core.delete', 'com_helloworld.helloworld.' . $registro->id);

		}

	}*/

}

?>