<?php  

//IMEPDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//IMPORTAR O ARQUIVO 'route.php' E FAZER COM QUE SEJA UTILIZÁVEL A CLASSE 'HelloworldHelperRoute'.
//É ASSIM QUE TAMBÉM UTILIZAMOS OUTRAS CLASSE COMO 'JFactory', 'JRegistry', ENTRE OUTROS.
JLoader::register('HelloWorldHelperRoute', JPATH_ROOT . '/components/com_helloworld/helpers/route.php');

//ARQUIVO QUE SERÁ O MODELO DA VIEW 'helloworld'.
//OBSERVE QUE O NOME DO ARQUIVO DO MODELO PRECISA SER O MESMO DA VIEW, QUE NESSE CASO É 'helloworld'.

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelItem' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPOS DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelItem{

	//CRIANDO UMA VARIÁVEL PARA OBTER A MENSAGEM.
	protected $mensagem;

	//MÉTODO PARA PREENCHER AUTOMATICAMENTE O ESTADO DO MODELO.
	//ESTE MÉTODO DEVE SER CHAMADO UMA VEZ POR INSTANCIAÇÃO E É PROJETADO A SER CHAMADO NA PRIMEIRA CHAMADA AO MÉTODO 'getState()', A MENOS QUE ESTEJA DEFINIDO O MODELO SINALIZADOR DE CONFIGURAÇÃO PARA IGNORAR A SOLICITAÇÃO.
	//OBS: CHAMAR 'getState()' NESTE MÉTODO RESULTARÁ EM RECURSÃO.
	protected function populateState(){

		//PEGA O ID DA MENSAGEM
		$id = JFactory::getApplication()->input->get('opcao', null, 'INT');
		$this->setState('message.id', $id);

		//CARREGAR PARÂMETROS
		$this->setState('params', JFactory::getApplication()->getParams());
		parent::populateState();

	}

	//MÉTODO PARA OBTER UMA TABELA.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array()){

		//RETORNAR A FUNÇÃO JTABLE COM OS PARÂMETROS PADRÕES.
		return JTable::getInstance($type, $prefix, $config);

	}

	public function getItem(){

		if(!isset($this->item)){

			if(!empty($this->getState('message.id'))){

				$id = $this->getState('message.id');
			
			}else{

				$id = JFactory::getApplication()->input->get('id', 1, 'INT');
			}

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CONSTRUIR A CONSULTA.
			//CRIAR UM JOIN COM A TABELA DE CATEGORIAS.
			$query->select('h.texto, h.params, h.imagem AS imagem, c.title AS category, h.latitude AS latitude, h.longitude AS longitude')->from($db->quoteName('#__olamundo', 'h'))->leftJoin($db->quoteName('#__categories', 'c') . ' ON h.catid = c.id')->where('h.id = ' . (int) $id);

			//SETAR A QUERY.
			$db->setQuery((string) $query);

			//CASO SEJA ENCONTRADO ALGUM REGISTRO.
			if($this->item = $db->loadObject()){

				//CARREGAR A STRING JSON
				$params = new JRegistry;
				$params->loadString($this->item->params, 'JSON');
				$this->item->params = $params;

				//MESCLAR PARÂMETROS GLOBAIS COM PARÂMETROS DO ITEM.
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;

				//CONVERTA AS INFORMAÇÕES DA IMAGEM CONDIFICADA EM JSON EM UMA MATRIZ
				$image = new JRegistry;
				$image->loadString($this->item->imagem, 'JSON');

				//COLOCAR O ARRAY DENTRO DE UMA VARIÁVEL. (ELA SERÁ USADA NO ARQUIVO 'default.php')
				$this->item->imageDetails = $image;

			}
		}

		//RTORNAR TODOS OS REGISTROS.
		return $this->item;
		
	}

	public function getMapParams(){

		if($this->item){

			//OBTER A URL DE UMA DETERMINADA MENSAGEM. ISSO ESTÁ CONFIGURADO NO ARQUIVO DA CLASSE 'HelloworldHelperRoute'.
			$url = HelloWorldHelperRoute::getAjaxURL();

			$this->mapParams = array(

				'latitude' => $this->item->latitude,
				'longitude' => $this->item->longitude,
				'zoom' => 10,
				'texto' => $this->item->texto,
				'ajaxurl' => $url
			
			);

			//RETORNAR OS PARÂMETROS DEFINIDOS.
			return $this->mapParams;

		}else{

			//LANÇAR UMA EXCEÇÃO.
			throw new Exception('Sem detalhes helloworld disponíveis para o mapa.', 500);

		}

	}

	public function getMapSearchResults($mapbounds){

		try{

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CRIAR UMA CONSULTA.
			$query->select('o.id, o.texto, o.latitude, o.longitude')->from($db->quoteName('#__olamundo', 'o'))->where('

					o.latitude > '. $mapbounds['minlat'] .'
					 AND o.latitude < '. $mapbounds['maxlat'] .'
					 AND o.longitude > '. $mapbounds['minlng'] .'
					 AND o.longitude < '. $mapbounds['maxlng'] .'

				');

			//SETAR A QUERY.
			$db->setQuery($query);
			
			//CARREGAR OS DADOS ENCONTRADOS EM FORMATO OBJECT CLASS.
			$resultado = $db->loadObjectList();

		}catch(Exception $e){

			$msg = $e->getMessage();

			JFactory::getApplication()->enqueueMessage($msg, 'error');

			$resultado = null;

		}

		//CRIAR UMA LAÇO DE REPETIÇÃO PARA ARMAZENAR A URL.
		for ($i = 0; $i < count($resultado); $i++) {

			//ARMAZENAR A URL DE CADA MENSAGEM.
			$resultado[$i]->url = JRoute::_('index.php?option=com_helloworld&view=helloworld&id=' . $resultado[$i]->id);
		}

		//RETORNAR OS ITEMS ENCONTRADOS.
		return $resultado;

	}

	//UMA FUNÇÃO CRIADA A PARTIR DE UM PREFIXO 'get'.
	/*public function getUmaMensagem($id = 1){

		if(!is_array($this->mensagem)){

			$this->mensagem = array();

		}

		if(!isset($this->mensagem[$id])){

			//OBTENDO O APLICATIVO.
			$aplicativo = JFactory::getApplication();

			//OBTENDO O INPUT.
			$input = $aplicativo->input;

			//OBTENDO O ID ESCOLHIDO PELA SOLICITAÇÃO VIA HTTP POST.
			//A OPÇÃO ESCOLHIDA NO TIPO DE ITEM DE MENU SERÁ OBTIDA ATRAVÉS DO COMANDO 'JFactory::getApplication()->input->getInt('opcao', 1, 'INT')', CUJO, 'getInt' INFORMA QUE O TIPO DE DADO A SER OBTIDO É DO TIPO INTEIRO, 'opcao' É O NOME DO CAMPO CUJO O VALOR ESTÁ SENDO OBTIDO, NESSE CASO ESTÁ PEGANDO O VALOR DO CAMPO 'opcao' DO ARQUIVO 'default.xml', E O VALOR '1' É O VALOR PADRÃO.
			$id = $input->getInt('opcao', 1);

			//OBTER UMA INSTÂNCIA DA TABELA.
			$tabela = $this->getTable();

			//CARREGAR A MENSAGEM.
			$tabela->load($id);

			//ATRIBUIR A MENSAGEM.
			$this->mensagem[$id] = $tabela->texto;

		}

		//FAZENDO UM SWITCH CASE PARA INFORMAR A MENSAGEM ESCOLHIDA.
		/*switch ($id) {
			case 1:
					
				$this->mensagem = "Olá Mundo! - OPÇÃO 01";

				break;

			case 2:

				$this->mensagem = "Até logo mundo! - OUTRA OPÇÃO";

				break;
			
			default:
				
				$this->mensagem = "Olá Mundo! - OPÇÃO 01";

				break;
		}*/

		/*return $this->mensagem[$id];

		//ATRIBUIRÁ A MENSAGEM À VARIÁVEL NA VIEW.
		//return 'Olá mundo para o cliente - uma mensagem aleatória!';

	}*/



}

?>