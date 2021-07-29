<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//IMPORTAR O ARQUIVO 'route.php' E FAZER COM QUE SEJA UTILIZÁVEL A CLASSE 'HelloworldHelperRoute'.
//É ASSIM QUE TAMBÉM UTILIZAMOS OUTRAS CLASSE COMO 'JFactory', 'JRegistry', ENTRE OUTROS.
JLoader::register('HelloworldHelperRoute', JPATH_ROOT . '/components/com_helloworld/helpers/route.php');

//ARQUIVO QUE SERÁ O MODELO DA VIEW 'helloworld'.
//OBSERVE QUE O NOME DO ARQUIVO DO MODELO PRECISA SER O MESMO DA VIEW, QUE NESSE CASO É 'helloworld'.

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelItem' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPODE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelItem{
	
	//CRIAR UMA VARÁVEL PROTEGIDA.
	protected $mensagem;

	//CRIAR UMA VARIÁVEL PROTEGIDA PARA ITEM DE OBJETO.
	protected $item;

	//MÉTODO PARA OBTER UMA TABELA.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array()){

		//RETORNAR A FUNÇÃO JTABLE COM OS PARÂMETROS PADRÕES.
		return JTable::getInstance($type, $prefix, $config);
	}

	//MÉTODO PARA PREENCHER AUTOMATICAMENTE O ESTADO DO MODELO.
	//ESTE MÉTODO DEVE SER CHAMADO UMA VEZ POR INSTANCIAÇÃO E É PROJETADO A SER CHAMADO NA PRIMEIRA CHAMADA AO MÉTODO 'getState()', A MENOS QUE ESTEJA DEFINIDO O MODELO SINALIZADOR DE CONFIGURAÇÃO PARA IGNORAR A SOLICITAÇÃO.
	//OBS: CHAMAR 'getState()' NESTE MÉTODO RESULTARÁ EM RECURSÃO.
	protected function populateState(){

		//PEGAR O ID DA MENSAGEM.
		$id = JFactory::getApplication()->input->get('opcao', 0, 'INT');
		$this->setState('message.id', $id);

		//CARREGAR OS PARÂMETROS;
		$this->setState('params', JFactory::getApplication()->getParams());
		parent::populateState();
	}

	//COMPREENDER A MENSAGEM ESCRITA EM JSON PARA SER EXIBIDA AO USUÁRIO.
	public function getItem($id = null){

		if(!isset($this->item) || !is_null($id)){

			//VERIFICAR SE A VIEW FOI ACESSADA DIRETO NO ITEM DE MENU 'mensagens'.
			if($this->getState('message.id') == 0){

				//IRÁ PEGAR O ID PELA URL (ISSO QUANDO ACESSADO PELA VIEW DA LISTA DE CATEGORIAS).
				$id = is_null($id) ? JFactory::getApplication()->input->get('id', 1, 'INT') : $id;

			}else{

				//IRÁ PEGAR O ID PELO MODAL DE OPÇÕES (ISSO QUANDO ACESSADO PELA VIEW DAS MENSAGENS DIRETAMENTE).
				$id = is_null($id) ? $this->getState('message.id') : $id;

			}

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CONSTRUIR A CONSULTA.
			$query->select('h.texto, h.params, h.imagem as imagem, 
				c.title AS categoria, c.access AS catAccess,
				h.latitude AS latitude, 
				h.longitude AS longitude, h.access AS access,
				h.id AS id,
				h.alias AS alias, h.catid AS catid, 
				h.parent_id AS parent_id, 
				h.level AS level, h.description AS description')->from($db->quoteName('#__olamundo', 'h'))->leftJoin('#__categories AS c ON h.catid = c.id')->where('h.id = ' . (int) $id);

			//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
			if(JLanguageMultilang::isEnabled()){

				//OBTER A TAG DO IDIOMA ATUAL.
				$lang = JFactory::getLanguage()->getTag();

				//FAZER A FILTRAGEM DE IDIOMA POR SQL.
				$query->where('h.language IN("*", "' . $lang . '")');

			}

			//SETAR A QUERY.
			$db->setQuery((string) $query);

			if($this->item = $db->loadObject()){

				//CARREGAR A STRING JSON.
				$parametros = new JRegistry;

				//TEM QUE CONSERTAR ISSO DEPOIS.
				//$parametros->loadString($this->item->params, 'JSON');
				$this->item->params = $parametros;

				//MESCLAR OS PARÂMETROS GLOBAIS COM OS PARÂMETROS DE ITEM.
				//OBSERVE A PALAVRA-CHAVE 'clone' QUE FARÁ UM CLONE COM AS MESMAS PROPRIEDADES DO '$this->getState()'.
				$parametros = clone $this->getState('params');
				$parametros->merge($this->item->params);
				$this->item->params = $parametros;

				//CONVERTA AS INFORMAÇÕES DA IMAGEM, CODIFICADA EM JSON, EM UMA MATRIZ.
				$image = new JRegistry;
				$image->loadString($this->item->imagem, 'JSON');

				//COLOCAR O ARRAY DENTRO DE UMA VARIÁVEL. (ELA SERÁ USADA NO ARQUIVO 'default.php')
				$this->item->imageDetails = $image;

				//VERIFIQUE SE O USUÁRIO PODE ACESSAR ESSE REGISTRO (E CATEGORIA).

				//OBTER O USUÁRIO ATUAL.
				$usuario = JFactory::getUser();

				//OBER AS AUTORIZAÇÕES DOS NÍVEIS DE ACESSO PARA O REGISTRO.
				$niveisAcessoUsuario = $usuario->getAuthorisedViewLevels();

				//É O ADMIN
				if($usuario->authorise('core.admin')){

					$this->item->canAccess = true;

				}else{

					if($this->item->catid == 0){

						$this->item->canAccess = in_array($this->item->access, $niveisAcessoUsuario);

					}else{

						$this->item->canAccess = in_array($this->item->access, $niveisAcessoUsuario) && in_array($this->item->catAccess, $niveisAcessoUsuario);

					}

				}

			}else{

				//LANÇAR UM ERRO CASO A QUERY NÃO FOR CARREGADA.
				throw new Exception('HelloWorld não foi encontrado! :(', 404);

			}
		}

		//RETORNAR OS ITEMS ENCONTRADOS.
		return $this->item;
	}

	//UMA FUNÇÃO CRIADA A PARTIRI DE UM PREFIXO 'get'.
	//POR PADRÃO, A FUNÇÃO TERÁ O VALOR 1 COMO PARÂMETRO.
	public function getUmaMensagem($pos = 1){

		if(!is_array($this->mensagem)){
			$this->mensagem = array();
		}
		
		//CASO NÃO TIVER NADA DENTRO DA VARIÁVEL, ACONTECERÁ UMA AÇÃO.
		if(!isset($this->mensagem[$pos])){

			//A OPÇÃO ESCOLHIDA NO TIPO DE ITEM DE MENU SERÁ OBTIDA ATRAVÉS DO COMANDO 'JFactory::getApplication()->input->getInt('opcao', 1, 'INT')', CUJO, 'getInt' INFORMA QUE O TIPO DE DADO A SER OBTIDO É DO TIPO INTEIRO, 'opcao' É O NOME DO CAMPO CUJO O VALOR ESTÁ SENDO OBTIDO, NESSE CASO ESTÁ PEGANDO O VALOR DO CAMPO 'opcao' DO ARQUIVO 'default.xml', E O VALOR '1' É O VALOR PADRÃO.
			$opcaoEscolhida = JFactory::getApplication()->input->getInt('opcao', 1, 'INT');

			//OBTER UMA INSTÂNCIA DA JTABLE HELLOWORLD
			$table = $this->getTable();

			//CARREGAR OS DADOS DA TABELA DE ACORDO COM A OPÇÃO ESCOLHIDA
			$table->load($opcaoEscolhida);

			//ATRIBUIR A MENSAGEM PARA A VARIÁVEL;
			$this->mensagem[$pos] = $table->texto;

			//UM SWITCH CASE DE LEVES. PARA PASSAR O VALOR PARA A VARIÁVEL.
			/*switch($opcaoEscolhida){
				case 1:
					$mensagem = 'Olá Mundo!!';
					break;
				case 2:
					$mensagem = 'Adeus, Mundo!!';
					break;
				case 3:
					$mensagem = 'Denovo Mundo??';
					break;
				default:
					$mensagem = 'Olá Mundo!!';
					break;
				}*/

			//RETORNAR O VALOR ESCOLHIDO.
			//return $mensagem;
			}

		//RETORNAR O VALOR ESCOLHIDO.
		return $this->mensagem[$pos];

		}

		public function getMapParams(){

			//SE HOUVER DADOS NO BANCO, FAZ UMA AÇÃO.
			if($this->item){

				//OBTER A URL DE UMA DETERMINADA MENSAGEM. ISSO ESTÁ CONFIGURADO NO ARQUIVO DA CLASSE 'HelloworldHelperRoute'.
				$url = HelloworldHelperRoute::getAjaxUrl();

				//FAZER A CONFIGURAÇÃO DO JS POR MEIO DE ARRAY PARA CONFIGURAR O MAPA.
				$this->mapParams = array(
					'latitude' => $this->item->latitude,
					'longitude' => $this->item->longitude,
					'zoom' => 10,
					'texto' => $this->item->texto,
					'ajaxurl' => $url
				);

				//RETORNAR O RESULTADO ENCONTRADO.
				return $this->mapParams;
			}else{

				//CASO NÃO HOUVER DADOS NO BANCO, LANÇAR UMA EXCEÇÃO.
				throw new Exception('Nenhum detalhe do helloworld disponível para o mapa.', 500);
			}
			
		}

		public function getMapSearchResults($mapbounds){
			
			if(JFactory::getConfig()->get('caching') >= 1){

				//CONSTRUIR UM ID DE CACHE COM BASE NAS CONDIÇÕES PARA A CLÁUSULA WHERE DO SQL.
				$groups = implode(',', JFactory::getUser()->getAuthorisedViewLevels());
				$cacheId = $groups . '.' . $mapbounds['minlat'] . '.' . $mapbounds['maxlat'] . '.' . $mapbounds['minlng'] . '.' . $mapbounds['maxlng'];

				//VRIFICAR SE O SITE É MULTILÍNGUE.
				if(JLanguageMultilang::isEnabled()){

					$lang = JFactory::getLanguage()->getTag();
					$cacheId .= $lang;

				}

				$cache = JFactory::getCache('com_helloworld', 'callback');
				$results = $cache->get(array($this, '_getMapSearchResults'), array($mapbounds), md5($cacheId), false);
				return $results;

			}else{

				return $this->_getMapSearchResults($mapbounds);

			}

		}

		public function _getMapSearchResults($mapbounds){

			try{

				//OBTER O BANCO DE DADOS.
				$db = JFactory::getDbo();

				//INICIALIZAR A QUERY
				$query = $db->getQuery(true);

				//CONSTRUIR A SOLICITAÇÃO.
				$query->select('o.id, o.alias, o.texto, o.catid, o.latitude, o.longitude, o.access')->from($db->quoteName('#__olamundo', 'o'))->where('

						o.latitude > '. $mapbounds['minlat'] .'
						AND o.latitude < '. $mapbounds['maxlat'] .'
						AND o.longitude > '. $mapbounds['minlng'] .'
						AND o.longitude < ' . $mapbounds['maxlng'] . '

					');
				
				//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
				if(JLanguageMultilang::isEnabled()){

					//OBTER A TAG DO IDIOMA ATUAL.
					$lang = JFactory::getLanguage()->getTag();

					//FAZER A FILTRAGEM DE IDIOMA POR SQL.
					$query->where('o.language IN("*", "' . $lang . '")');

				}

				//EXIBIR A LISTA DE REGISTROS CUJO O USUÁRIO TÊM ACESSOE QE ESTEJA LOGADO.

				//OBTER O USUÁRIO ATUAL.
				$usuario = JFactory::getuser();

				//USUÁRIO LOGADO.
				$logado = $usuario->get('guest') != 1;

				if($logado && !$usuario->authorise('core.admin')){

					//OBTER OS ACESSOS DO USUÁRIOS ATUAL.
					$niveisAcessoUsuario = $usuario->getAuthorisedViewLevels();

					//FAZER A SELEÇÃO PELA QUERY.
					$query->where('o.access IN (' . implode(',', $niveisAcessoUsuario) . ')');
					$query->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = o.catid');
					$query->where('(c.access IN(' . implode(',', $niveisAcessoUsuario) . ') OR o.catid = 0)');

				}

				//SETAR A QUERY.
				$db->setQuery($query);

				//CARREGAR OS DADOS ENCONTRADOS EM FORMATO OBJECT CLASS;
				$resultado = $db->loadObjectList();

			}catch(Exception $e){

				$msg = $e->getMessage();
				JFactory::getApplication()->enqueueMessage($msg, 'error');
				$resultado = null;

			}

			//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
			//A VARIÁVEL '$query_lang' ARMAZENARÁ A TAG DA LINGUAGEM PARA SER USADA NA FUNÇÃO 'JRoute::_()'.
			if(JLanguageMultilang::isEnabled()){

				$query_lang = "&lang=".$lang;

			}else{

				$query_lang = "";

			}

			//CRIAR UMA LAÇO DE REPETIÇÃO PARA ARMAZENAR A URL.
			for($i = 0;$i < count($resultado);$i++){

				//ARMAZENAR A URL DE CADA MENSAGEM.
				$resultado[$i]->url = JRoute::_('index.php?option=com_helloworld&view=helloworld&id=' . $resultado[$i]->id . ":" . $resultado[$i]->alias . "&catid=" . $resultado[$i]->catid . $query_lang);
			}

			//RETORNAR OS ITEMS ENCONTRADOS.
			return $resultado;

		}

		//FUNÇÃO PARA OBTER OS FILHOS. (SUB-REGISTROS).
		public function getChildren($id){

			$tabela = $this->getTable();
			$filhos = $tabela->getTree($id);

			return $filhos;

		}

	}

	?>