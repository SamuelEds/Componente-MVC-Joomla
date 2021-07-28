<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

/* ARQUIVO MODELO DA VIEW 'category' */

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelList' PARA A VIEW 'form', EXISTEM TAMBÉM OUTROS TIPOs DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'Category' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelCategory extends JModelList{

	public function __construct($config = array()){

		//CONFIGURAR QUAIS CAMPOS PODEM ATUAR COMO FILTROS
		if(empty($config['filter_fields'])){

			$config['filter_fields'] = array('id', 'texto', 'alias', 'lft');

		}

		//ENVIAR DADOS PARA O MODELO-PAI
		parent::__construct($config);

	}

	/*
		IMPORTANTE: É PRECISO QUE SEJA CRIADO UM ARQUIVO '.xml' NA PASTA 'forms' QUE SERÁ A RESPONSÁVEL PELA ENTREGA DE RESULTADOS DO FILTRO. A NOMENCLATURA DO ARQUIVO DEVE SER 'filter_<nome_do_modelo_de_onde_vem_os_filtros>.xml', QUE NESSE CASO, OS FILTROS ESTÃO SENDO EXTRAÍDOS DO MODELO 'Category'. NO ARQUIVO ENCONTRA-SE O MODO DE CONFIGURAÇÃO DO MESMO.
	*/

	//MÉTODO PARA PREENCHER AUTOMATICAMENTE O ESTADO DO MODELO.
	//ESTE MÉTODO DEVE SER CHAMADO UMA VEZ POR INSTANCIAÇÃO E É PROJETADO A SER CHAMADO NA PRIMEIRA CHAMADA AO MÉTODO 'getState()', A MENOS QUE ESTEJA DEFINIDO O MODELO SINALIZADOR DE CONFIGURAÇÃO PARA IGNORAR A SOLICITAÇÃO.
	//OBS: CHAMAR 'getState()' NESTE MÉTODO RESULTARÁ EM RECURSÃO.
		public function populateState($ordering = null, $direction = null){

			parent::populateState($ordering, $direction);

		//OBTER O APLICATIVO DO SITE
			$aplicativo = JFactory::getApplication('site');

		//OBTER O ID DO ITEM PARA USAR COMO ID DE CATEGORIA. ESSE 'id' É O VALUE ATRIBUTO 'name' NO ARQUIVO 'default.xml' DA VIEW 'category'.
			$catid = $aplicativo->input->getInt('id');

		//SETAR UM STATE PARA O ID DE CATEGORIA.
		//É COMO SE ESTIVESSE PEGANDO DIRETAMENTE UM CAMPO DO BANCO DE DADOS.
			$this->setState('category.id', $catid);

		}

	//MÉTODO PARA CONSTRUIR UMA CONSULTA SQL PARA UMA LISTA DE DADOS.
		public function getListQuery(){

		//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

		//INICIALIZAR O BANCO.
			$query = $db->getQuery(true);

		//OBTER O ESTADO. ISSO FOI SETADO NA FUNÇÃO 'populateState()'
			$catid = $this->getState('category.id');

		//CRIAR A QUERY.
			$query->select('id, texto, alias, catid, access, description, imagem')
			->from($db->quoteName('#__olamundo'))->where('catid = ' . $catid);

		//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
			if(JLanguageMultilang::isEnabled()){

			//OBTER A TAG DO IDIOMA ATUAL.
				$lang = JFactory::getLanguage()->getTag();

			//FAZER A FILTRAGEM DE IDIOMA POR SQL.
				$query->where('language IN("*", "' . $lang . '")');

			}

		//CRIAR UM SISTEMA PARA ORDENAR OS ITEMS BUSCADOS NO BANCO.

		//A ORDENAÇÃO PADRÃO É PELO TEXTO...
		//$ordenarColuna = $this->state->get('list.ordering', 'texto');

		//AGORA A ORDENAÇÃO PADRÃO É PELO CAMPO 'ordering' DO BANCO...
			$ordenarColuna = $this->state->get('list.ordering', 'lft');

		//...EM SENTIDO CRESCENTE.
			$ordenarDirecao = $this->state->get('list.direction', 'ASC');

		//FAZER A ORDENAÇÃO NA QUERY.
			$query->order($db->escape($ordenarColuna) . ' ' . $db->escape($ordenarDirecao));

		//RETORNAR A CONSULTA CONSTRUÍDA.
			return $query;
		}

	//FUNÇÃO PERSONALIZÁVEL.
		public function getNomeCategoria(){

		//OBTER O ID DACATEGORIA ESCOLHIDA.
		//ISTO FOI CONFIGURADO NO MÉTODO 'populateState()'.
			$catid = $this->getState('category.id');

		//CONFIGURAÇÃO DA API DE CATEGORIAS DO JOOMLA.
		//OBTER UMA INSTÂNCIA DO OBJETO DECATEGORIES DO COMPONENTE 'Helloworld'.
			$categorias = JCategories::getInstance('Helloworld', array('access' => false));

			$categoriaNode = $categorias->get($catid);
			return $categoriaNode->title;

		}

	//FUNÇÃO PERSONALIZÁVEL.
		public function getSubcategorias(){

		//OBTER O ID DACATEGORIA ESCOLHIDA.
		//ISTO FOI CONFIGURADO NO MÉTODO 'populateState()'.
			$catid = $this->getState('category.id');

		//CONFIGURAÇÃO DA API DE CATEGORIAS DO JOOMLA.
		//OBTER UMA INSTÂNCIA DO OBJETO DECATEGORIES DO COMPONENTE 'Helloworld'.
		//É PRECISO QUE EXISTA UM ARQUIVO NA PASTA 'helpers' COM O NOME 'Helloworld' COMO TÁ ESCRITO EM BAIXO.
			$categorias = JCategories::getInstance('Helloworld', array('access' => false));

		//AQUI IRÁ RETORNAR UM OBJETO 'CategoryNode' QUE SE RELACIONA COM UMA ÚNICA CATEGORIA.
			$categoriaNode = $categorias->get($catid);
			$subcategorias = $categoriaNode->getChildren();

			$lang = JFactory::getLanguage()->getTag();

		//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
			if(JLanguageMultilang::isEnabled() && $lang){

				$query_lang = "&lang=".$lang;

			}else{

				$query_lang = "";

			}

			foreach($subcategorias as $subcat){

				$subcat->url = JRoute::_("index.php?view=category&id=" . $subcat->id . $query_lang);

			}

			return $subcategorias;
		}

		public function getCategoryAccess(){

		//OBTER O CATID DO 'State'.
			$catid = $this->getState('category.id');

		//OBTER A INSTÂNCIA DO OBJETO DE CATEGORIAS.
			$categorias = JCategories::getInstance('Helloworld', array('access' => false));
			$categoryNode = $categorias->get($catid);
			return $categoryNode->access;

		}

		public function getItems(){

		//OBTER OS REGISTROS.
			$items = parent::getItems();

		//OOBTER O USUÁRIO ATUAL.
			$usuario = JFactory::getUser();

		//USUÁRIO LOGADO.
			$logado = $usuario->get('guest') != 1;

		//É O DMINISTRADOR
			if($usuario->authorise('core.admin')){

				return $items;

			}else{

			//OBTER AS AUTORIZÇÕES DOS NÍVEIS DE ACESSO DO USUÁRIO ATUAL.
				$niveisAcessoUsuario = $usuario->getAuthorisedViewLevels();

				$catAccess = $this->getCategoryAccess();

				if(!in_array($catAccess, $niveisAcessoUsuario)){

				//O USUÁRIO NÃO PODE ACESSAR A CATEGORIA.
					if($logado){

						return array();

					}else{

						foreach($items as $item){

							$item->canAccess = false;

						}

						return $items;

					}

				}

				foreach($items as $item){

					if(!in_array($item->access, $niveisAcessoUsuario)){

						if($logado){

							unset($item);

						}else{

							$item->canAccess = false;

						}

					}

				}

			}

			return $items;

		}

		//OBTER AS CATEGORIAS HELLOWORLD.
		public function getCategory(){

			$categories = JCategories::getInstance('Helloworld', array());
			$category = $categories->get($this->getState('category.id', 'root'));
			return $category;

		}
	}

?>