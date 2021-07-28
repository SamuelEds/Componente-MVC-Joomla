<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CLASSE DO MODELO A SR UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelList' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPODE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorlds extends JModelList{

	//MÉTODO PARA CONFIGURAR OS CAMPOS QUE FARÃO OS FILTROS.
	//CASO QUEIRA FAZER FILTROS COM OUTROS CAMPOS, SÓ ADICIONAR NO ARRAY.
	public function __construct($config = array()){

		if(empty($config['filter_fields'])){
			$config['filter_fields'] = array(
				'id',
				'texto',
				'author',
				'created',
				'language',
				'lft',
				'ordering',
				'category_id',
				'association',
				'publicado'
			);
		}

		//SETAR AS CONFIGURAÇÕES.
		parent::__construct($config);
	}

	//MÉTODO PARA PREENCHER AUTOMATICAMENTE O ESTADO DO MODELO.
	//ESTE MÉTODO DEVE SER CHAMADO UMA VEZ POR INSTANCIAÇÃO E É PROJETADO A SER CHAMADO NA PRIMEIRA CHAMADA AO MÉTODO 'getState()', A MENOS QUE ESTEJA DEFINIDO O MODELO SINALIZADOR DE CONFIGURAÇÃO PARA IGNORAR A SOLICITAÇÃO.
	//OBS: CHAMAR 'getState()' NESTE MÉTODO RESULTARÁ EM RECURSÃO.
	protected function populateState($ordering = 'lft', $direction = 'ASC'){

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();

		//AJUSTE O CONTEXTO PARA SUPORTAR LAYOUTS MODAIS.
		if($layout = $aplicativo->input->get('layout')){

			$this->context .= '.' . $layout; 
		
		}

		//AJUSTE O CONTEXTO PARA SUPORTAR IDIOMAS FORÇADOS.
		$forcarIdioma = $aplicativo->input->get('forcedLanguage', '', 'CMD');
		if($forcarIdioma){
			$this->context .= '.' .$forcarIdioma;
		}

		parent::populateState($ordering, $direction);

		//SE HOUVER UMA LINGUAGEM FORÇADA, DEFINA ESSE FILTRO PARA A CÁUSULA 'where' DA CONSULTA.
		if(!empty($forcarIdioma)){
			$this->setState('filter.language', $forcarIdioma);
		}
	}

	//MÉTODO PARA CONSTRUIR UMA CONSULTA SQL PARA UMA LISTA DE DADOS.
	protected function getListQuery(){

		//INICIALIZAR AS VARIÁVEIS.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//CRIAR A CONSULTA.
		//NOTE A FUNÇÃO 'quoteName()', ELE IRÁ DEFINIR UM APELIDO USADO NA QUERY QUE NESSE CASO É A LETRA 'a'.
		$query->select('a.id AS id, a.texto AS texto, a.published AS published, 
			a.created AS criado, a.checked_out AS checked_out, 
			a.checked_out_time AS checked_out_time, 
			a.catid AS catid, a.lft AS lft, 
			a.rgt AS rgt, a.parent_id AS parent_id, 
			a.level AS level, a.path AS path, 
			a.imagem AS imagemInfo, a.latitude AS latitude, 
			a.longitude AS longitude, a.alias AS alias, 
			a.language AS language')->from($db->quoteName('#__olamundo', 'a'));
		//$db->setQuery((string) $query);


		//CRIAR UM JOIN COM A TABELA DE CATEGORIAS.
		$query->select($db->quoteName('c.title', 'category_title'))->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.catid');
		
		//CRIAR UM JOIN COM A TABELA DE USUÁRIOS PARA OBTER O NOME DO AUTHOR.
		$query->select($db->quoteName('u.username', 'author'))->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = a.created_by');

		//CRIAR UM JOIN COM A TABELA DE USUÁRIOS PARA OBTER A PESSOA QUE FEZ O CHECKOUT NO REGISTRO.
		$query->select($db->quoteName('u2.username', 'editor'))->join('LEFT' , $db->quoteName('#__users', 'u2') . ' ON u2.id = a.checked_out');

		//CRIAR UM JOIN COM A TABELA DE IDIOMAS PARA OBTER O TÍTULO DO IDIOMA E A IMAGEM A SER EXIBIDA.
		//OBSERVE COMO OS APELIDOS ESTÃO SENDO ESCRITOS 'l.title AS language_title' E 'l.image AS language_image'. OS APELIDOS 'language_title' E 'language_image' PRECISAM SER ESCRITOS DESTA FORMA PARA QUE A EXIBIÇÃO DA BANDEIRINHA DOS IDIOMAS POSSA FUNCIONAR.
		$query->select($db->quoteName('l.title', 'language_title') . ', ' . $db->quoteName('l.image', 'language_image'))->join('LEFT', $db->quoteName('#__languages', 'l') . ' ON l.lang_code = a.language');

		//VERIFICAR SE HÁ ALGUMA ASSOCIAÇÃO. SE TIVER...
		if(JLanguageAssociations::isEnabled()){

			//...CRIAR UM JOIN COM A TABELA DE ASSOCIAÇÕES DO JOOMLA.
			$query->select('COUNT(asso2.id) > 1 as association')
			->join('LEFT', '#__associations AS asso ON asso.id = a.id AND asso.context = ' . $db->quote('com_helloworld.item'))
			->join('LEFT', '#__associations AS asso2 ON asso2.key = asso.key')
			->group('a.id');		
		}



		//--------------------------------------------------\\

		/**
		 * 
		 * NESTA SEÇÃO ENCONTRA-SE AS CONFIGURAÇÕES DE FILTRO.
		 * 
		*/

		/**
		 * 
		 * 
		 * IMPORTANTE: É PRECISO QUE SEJA CRIADO UM ARQUIVO '.xml' NA PASTA 'forms' QUE SERÁ 
		 * A RESPONSÁVEL PELA ENTREGA DE RESULTADOS DO FILTRO. A NOMENCLATURA DO ARQUIVO 
		 * DEVE SER 'filter_<nome_do_modelo_de_onde_vem_os_filtros>.xml', QUE NESSE CASO, OS 
		 * FILTROS ESTÃO SENDO EXTRAÍDOS DO MODELO 'HelloWorlds'. NO ARQUIVO ENCONTRA-SE O 
		 * MODO DE CONFIGURAÇÃO DO MESMO.
		 * 
		 * 
		 * 
		 * 
		*/

		//OBTER O VALOR REPASSADO NO CAMPO 'search' DO FORMULÁRIO NO ARQUIVO 'filter_helloworlds.xml'.
		//IMPORTANTE: É OBRIGATÓRIO QUE O PARÂMETRO SEJA 'filter.search'.
		$pesquisa = $this->getState('filter.search');

		//FILTROS: LIKE/PESQUISAR
		if(!empty($pesquisa)){

			$like = $db->quote('%'.$pesquisa.'%');
			$query->where('texto LIKE '.$like);

		}

		//OBTER O VALOR REPASSADO NO CAMPO 'published' DO FORMULÁRIO NO ARQUIVO 'filter_helloworlds.xml'
		//IMPORTANTE: É OBRIGATÓRIO QUE O PARÂMETRO SEJA 'filter.published'.
		$publicado = $this->getState('filter.published');

		//FILTRAR POR ESTADO PUBLICADO.
		if(is_numeric($publicado)){

			$query->where('a.published = '.(int) $publicado);

		}elseif($publicado === ''){

			$query->where('(a.published IN (0, 1))');

		}

		//FILTRAR POR IDIOMA, SE O USUÁRIO TIVER DEFINIDO ISSO NO CAMPO DE FILTRO.
		$idioma = $this->getState('filter.language');
		if($idioma){

			$query->where('a.language = ' . $db->quote($idioma));

		}

		//FILTRAR POR CATEGORIA.
		$catid = $this->getState('filter.category_id');
		if($catid){
			
			$query->where('a.catid = ' . $db->quoteName($catid));
			
		}

		//EXCLUIR REGISTRO OLAMUNDO RAÍZ.
		$query->where('a.id > 1');

		//ADICIONAR CLÁUSULA DE ORDENAÇÃO DE LISTA.
		//PRECISA SER A MESMA VARIÁVEL OBTIDA NO ARQUIVO VIEW DESSE MODELO, QUE NESSE CASO É '$this->state'.

		//AQUI, O SEGUNDO PARÂMETRO É O CAMPO PADRÃO DE ORDENAÇÃO TODA VEZ QUE O COMPONENTE FOR CARREGADO. NESSE CASO SERÁ O CAMPO PADRÃO É O 'id'.
		//$ordenarCol = $this->state->get('list.ordering', 'id');

		//AQUI, O SEGUNDO PARÂMETRO É O CAMPO PADRÃO DE ORDENAÇÃO TODA VEZ QUE O COMPONENTE FOR CARREGADO. NESSE CASO SERÁ O CAMPO PADRÃO É O 'lft'.
		$ordenarCol = $this->state->get('list.ordering', 'lft');

		//AQUI, O SEGUNDO PARÂMETRO É O A "DIREÇÃO" PADRÃO QUE DEVE SER SEGUIDO INICIALMENTE, SÃO DOIS VALORES 'ASC' E 'DESC'.
		$ordenarDir = $this->state->get('list.direction', 'ASC');

		//FAZER A ORDENAÇÃO.
		$query->order($db->escape($ordenarCol).' '.$db->escape($ordenarDir)); 

		//RETORNAR O RESULTADO ESPERADO.
		return $query;
	}
}

?>