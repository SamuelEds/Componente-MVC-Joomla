<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//IMPORTAR A CLASSE 'Registry'.
use Joomla\Registry\Registry;

//CLASSE MODELO 'HelloWorld'.

//CLASSE DO MODELO A SR UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelAdmin' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPOS DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelAdmin{

	//VARIÁVEL PADRÃO DO 'JModelAdmin'.
	//'JModelAdmin' PRECISA SABER DISSO PARA ARMAZENAR AS ASSOCIAÇÕES.
	protected $associationsContext = 'com_helloworld.item';

	/** 
	 * MÉTODO PARA SUBSTITUIR O 'getItem()' PARA PERMITIR CONVERTER AS INFORMAÇÕES A IMAGEM 
	 * CODIFICADA EM JSON NO REGISTRO DO BANCO DE DADOS EM UMA MATRIZ PARA O 
	 * PRÉ-PREENCHIMENTO SUBSEQUENTE DO FORMULÁRIO DE EDIÇÃO. 
	 * 
	 * ESSE MÉTODO TAMBÉM ESTÁ SENDO USADO PARA PREENCHER PREVIAMENTE AS ASSOCIAÇÕES.
	 * 
	 * */
	public function getItem($pk = null){

		//OBTER A FUNÇÃO PAI 'getItem()'
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

		//CARREGAR ITENS ASSOCIADOS.
		if(JLanguageAssociations::isEnabled()){

			$item->associations = array();

			if($item->id != null){

				$associations = JLanguageAssociations::getAssociations('com_helloworld', '#__olamundo', 'com_helloworld.item', (int) $item->id);
				
				foreach($associations as $tag => $associacao){

					$item->associations[$tag] = $associacao->id;
				
				}

			}

		}

		//RETORNAR VALORES ENCONTRADO.
		return $item;
	}

	//MÉTODO PARA OBTER UMA TABELA.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefixo = 'HelloWorldTable', $config = array()){

		//RETORNAR UMA INSTÂNCIA DA TABELA.
		return JTable::getInstance($type, $prefixo, $config);
	}

	//MÉTODO PARA OBTER O FORMULÁRIO.
	//'$data' - DADOS PARA O FORMULÁRIO.
	//'$loadData' - VERDADEIRO SE O FORMULÁRIO DEVE CARREGAR OS PRÓPRIOS DADOS (PADRÃO), FALSO CASO CONTRÁRIO.
	public function getForm($data = array(), $loadData = true){

		//OBTER O FORMULÁRIO.
		//O MÉTODO 'loadForm()' IRÁ PESQUISAR O FORMULÁRIO NA PASTA DE FORMULÁRIOS. (EM 'admin/models/forms').
		//DEPOIS DO PARÂMETRO 'com_helloworld.helloworld', É INSERIDO O NOME DO FORMULÁRIO NA PASTA DE FORMULÁRIOS CUJO O MODELO VAI TRABALHAR.
		$form = $this->loadForm(
			'com_helloworld.helloworld', 
			'helloworld', array('control' => 'jform', 'load_data' => $loadData));

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
	 * MÉTODO PARA PRÉ-PROCESSAR O FORMULÁRIO PARA ADICIONAR OS CAMPOS DE ASSOCIAÇÃO 
	 * DINAMICAMENTE.
	 * 
	 * @return NONE.
	 * 
	 **/

	protected function preprocessForm(JForm $form, $data, $group = 'helloworld'){

		//ITENS DE CONTEÚDO DE ASSOCIAÇÃO.
		
		//VERIFICAR SE AS ASSOCIAÇÕES ESTÃO HABILITADAS.
		if(JLanguageAssociations::isEnabled()){

			//OBTER AS ASSOCIAÇÕES.
			$languages = JLanguageHelper::getContentLanguages(false, true, null, 'ordering', 'ASC');
			
			if(count($languages) > 1){

				//CRIAR UM FORMULÁRIO EM FORMATO DE ARQUIVO XML.
				//A FUNÇÃO 'SimpleXMLElement' IRÁ CRIAR UM ELEMENTO COMO SE ESTIVESSE ESCREVENDO NUM ARQUIVO XML. NESSE CASO ELE IRÁ CRIAR UM FORMULÁRIO.
				//ESSE SERÁ O CAMPO EXIBIDO NA ABA DE ASSOCIAÇÕES.
				$adicionarForm = new SimpleXMLElement('<form />');
				$campos = $adicionarForm->addChild('fields');
				$campos->addAttribute('name', 'associations');
				$fieldset = $campos->addChild('fieldset');
				$fieldset->addAttribute('name', 'item_associations');

				foreach($languages as $language){


					$campo = $fieldset->addChild('field');
					$campo->addAttribute('name', $language->lang_code);
					
					//AQUI A LINHA É 'modal_olamundo' MESMO.
					$campo->addAttribute('type', 'modal_olamundo');
					$campo->addAttribute('language', $language->lang_code);
					$campo->addAttribute('label', $language->title);

					//BASICAMENTE, O CAMPO SÓ APARECE SE TIVER ALGUM VALOR AQUI (SE QUISER AJEITAR...).
					$campo->addAttribute('default', 1);
					$campo->addAttribute('translate_label', 'false');

				}

				$form->load($adicionarForm, false);

			}

		}

		parent::preprocessForm($form, $data, $group);

	} 

	//MÉTODO PARA OBTER OS DADOS QUE DEVEM SER INJETADOS NO FORMULÁRIO.
	protected function loadFormData(){

		//OBTER OS DADOS PELO MÉTODO 'getUserState()', UM MÉTODO QUE GERENCIA O COMPORTAMENTO DO USUÁRIO.
		//COLOCAR OS DADOS EM FORMA DE ARRAY DENTRO DA VARIÁVEL '$dados'.
		$dados = JFactory::getApplication()->getUserState('com_helloworld.edit.helloworld.data', array());

		//CASO OS DADOS FOREM OBTIDOS, FARÁ UMA AÇÃO.
		if(empty($dados)){

			//TODOS OS DADOS PASSADOS PELO FORMULÁRIO SERÃO ARMAZENADOS NO ARRAY '$dados'.
			$dados = $this->getItem();
		}

		//RETORNAR OS DADOS OBTIDOS.
		return $dados;
	}

	/*
	
		MÉTODO PARA OBTER O SCRIPT QUE DEVE SER INCLUÍDO NO FORMULÁRIO.
		ESSE MÉTODO SERÁ ARMAZENADO NA VARIÁVEL '$this->script' NA VIEW.
	
	*/
		public function getScript(){
			return 'administrator/components/com_helloworld/models/forms/helloworld.js';
		}

	/*
	
		MÉTODO PARA SUBSTITUIR A FUNÇÃO 'save()' DO 'JModelAdmin' PARA LIDAR COM O 'Salvar como cópia' CORRETAMENTE.

		* '$dados' - OS DADOS DO REGISTRO HELLOWORLD ENVIADOS A PARTIR DO FORMULÁRIO. 
	
	*/
		public function save($dados){

			//OBTER O 'input' DA APLICAÇÃO.
			$input = JFactory::getApplication()->input;

			//IMPORTAR O ARQUIVO 'categories.php' E FAZER COM QUE SEJA UTILIZÁVEL A CLASSE 'CategoriesHelper'.
			//É ASSIM QUE TAMBÉM UTILIZAMOS OUTRAS CLASSE COMO 'JFactory', 'JRegistry', ENTRE OUTROS.
			JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/categories.php');

			//VALIDAR O ID DE CATEGORIA
			if((int) $dados['catid'] > 0){

				//'validateCategoryId' RETORNA 0 SE O 'catid' NÃO FOR ENCONTRADO.
				$dados['catid'] = CategoriesHelper::validateCategoryId($dados['catid'], 'com_helloworld');
			}

			//ALTERE O TEXTO E O ALIAS PARA SALVAR COMO CÓPIA
			if($input->get('task') == 'save2copy'){

				$origTabela = clone $this->getTable();
				$origTabela->load($input->get('id'));

				if($dados['texto'] == $origTabela->texto){

					//A FUNÇÃO 'generateNewTitle()' FAZ COM QUE O JOOMLA SUPORTE A ADIÇÃO DE NÚMERO E NO TÍTULO E NO ALIAS ATÉ ENCONTRAR UMA COMBINAÇÃO ATÉ ONDE A COMBINAÇÃO DE ALIAS + CATEGORIA NÃO EXISTA NO BANCO DE DADOS.
					//A FUNÇÃO 'list' CRIA VARIÁVEIS COMO SE FOSSEM ARRAYS.
					list($texto, $alias) = $this->generateNewTitle($dados['catid'], $dados['alias'], $dados['texto']);
					$dados['texto'] = $texto;
					$dados['alias'] = $alias;
				}else{

					if($dados['alias'] == $origTabela->alias){
						$dados['alias'] = '';
					}

				}

				//A PRÁTICA DO JOOMLA É DEFINIR UM NOVO RECURSO COMO DESPUBLICADO.
				$dados['published'] = 0;
			}

			//SALVAR OS DADOS NORMALMENTE.
			return parent::save($dados);
		}

	//MÉTODO PARA VERIFICAR SE ESTÁ TUDO BEM PARA EXCLUIR UMA MENSAGEM. SUBSTITUI 'JModelAdmin::canDelete'.
		protected function canDelete($record){

			if(!empty($record->id)){

				return JFactory::getUser()->authorise("core.delete", "com_helloworld.helloworld." . $record->id);
			}
		}
	}

	?>