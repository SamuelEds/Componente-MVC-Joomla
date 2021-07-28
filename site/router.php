<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pdoe ser acessada diretamente.');

//ARQUIVO DE ROTEAMENTO DO COMPONENTE HELLOWORLD.

//CLASSE DE ROTEAMENTO DO COMPONENTE.
//OBSERVE A NOMENCLATURA DA CLASSE. SEGUE O PADRÃO '<nome_do_componente>Router'.
//ESTÁ IMPLEMENTADO A INTERFACE 'JComponentRouterInterface' PARA FAZER A MANIPULAÇÃO DO ROTEAMENTO DE COMPONENTE PADRÃO DO JOOMLA.
class HelloworldRouter implements JComponentRouterInterface{

	public function build(&$query){

		$segmentos = array();

		//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
		if(!JLanguageMultilang::isEnabled() || !isset($query['view'])){

			return $segmentos;
		}

		//OBTER O IDIOMA ATUAL DA APLICAÇÃO.
		$lang = JFactory::getLanguage()->getTag();

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();

		//OBTER O ITEM DE MENU AO QUAL ESTA CHAMADA PARA 'build()' ESTÁ RELACIONADA.
		if(!isset($query['Itemid'])){

			return $segmentos;

		}

		//OBTER O OBJETO DE MENU.
		$siteMenu = $aplicativo->getMenu();

		//OBTER O ITEM DE ACORDO COM O ID DA URL.
		$esteMenuItem = $siteMenu->getItem($query['Itemid']);

		if($esteMenuItem->language != $lang){

			return $segmentos;

		}

		if($esteMenuItem->note == "Ajax"){

			//ESTAMOS NO ITEM DE MENU/MENSAGEM
			//VERIFIQUE SE TÊM OS PARÂMETROS CORRETOS E DEFINA 'url segment = id: alias'.
			if($query['view'] == "helloworld" && isset($query['id'])){

				//APOIAREMOS O ID PASSADO NO FORMATO ID: ALIAS.
				$segmentos[] = $query['id'];

				unset($query['id']);
				unset($query['catid']);

			}
		}else{

			//ASSUME QUE ESTAMOS ITEM DE MENU/MENSAGENS
			if(($query['view'] == "category") && isset($query['id'])){

				//DEFINIR AS PARTES DA URL PARA ESTAR NO FORMATO: 'subcat1/subcat2/...'.
				$pathSegmentos = $this->getCategorySegments($query['id']);

				if($pathSegmentos){
					$segmentos = $pathSegmentos;
					unset($query['id']);
				}

			}else if($query['view'] == "helloworld" && isset($query['catid']) && isset($query['id'])){

				//DEFINIR AS PARTES DA URL PARA ESTAR NO FORMATO: 'subcat1/subcat2/.../mensagem-helloworld'.
				$pathSegmentos = $this->getCategorySegments($query['catid']);

				if($pathSegmentos){

					$segmentos = $pathSegmentos;

				}

				$segmentos[] = $query['id'];

				unset($query['id']);
				unset($query['catid']);

			}

		}

		unset($query['view']);

		return $segmentos;

		//VERIFICAR SE NO PARÂMETRO ID PASSADO PELA URL EXISTE ALGUM VALOR.
		/*if(isset($query['id'])){

			//OBTER O BANCO DE DADOS
			$db = JFactory::getDbo();

			//INICIALIAZAR A QUERY.
			$consulta = $db->getQuery(true);

			//CRIAR A QUERY.
			$consulta->select('alias')->from('#__olamundo')->where('id = ' . $db->quote($query['id']));

			//SETAR A QUERY.
			$db->setQuery($consulta);

			//OBTER OS RESULTADOS DO BANCO EM FORMA DE ARRAY.
			$alias = $db->loadResult();

			//ARMAZENAR CADA ITEM NO ARRAY.
			$segmentos[] = $alias;

			//ESVAZIAR O VALUE DO ID.
			unset($query['id']);
		}

		//ESVAZIAR O VALUE DA VIEW.
		unset($query['view']);

		//RETORNAR OS DADOS OBTIDOS.
		return $segmentos;*/
	}

	/*
	*	ESTA FUNÇÃO PEGA O ID DA CATEGORIA E PROCURA O CAMINHO DESSA CATEGORIA PARA A RAIZ
	*	DA ÁRVORE DE CATEGORIAS.
	*	
	*	O CAMINHO RETORNADO DE 'getPath()' É UMA MATRIZ ASSOCIATIVA DE 'key = category id,
	*	value = id: alias'.
	*
	*	SE NENHUMA CATEGORIA VÁLIDA FOR ENCONTRADA NO ID DE CATEGORIA PASSADO, SERÁ RETORNADO 
	*	NULO.
	*	
	*/

	private function getCategorySegments($catid){

		$categories = JCategories::getInstance('Helloworld', array());
		$categoryNode = $categories->get($catid);

		if($categoryNode){

			// O 'getPath()' RETORNA O CAMINHO DO 'CategoryNode' PARA NÓ DA CATEGORIA RAIZ. O CAMINHO É UMA MATRIZ ASSOCIATIVA COM CADA ELEMENTO TENDO 'key = category id' E 'value = id: categoryAlias', E O PRIMEIRO ELEMENTO DA MATRIZ SENDO A CATEGORIA MAIS PRÓXIMA DA RAIZ.
			$path = $categoryNode->getPath();
			return $path;

		}else{

			return null;

		}

	}

	public function parse(&$segmentos){

		$vars = array();
		$nSegmentos = count($segmentos);

		$aplicativo = JFactory::getApplication();
		$siteMenu = $aplicativo->getMenu();
		$menuItemAtivo = $siteMenu->getActive();

		if(!$menuItemAtivo){

			return $vars;

		}

		if($menuItemAtivo->note == "Ajax"){

			//ESPERA 1 SEGMENTO DO FORMULÁRIO ID: ALIAS PARA O REGISTRO HELLOWORLD.
			if($nSegmentos == 1){

				$vars['id'] = $segmentos[0];
				$vars['view'] = 'helloworld';

			}

		}else{

			//TENTAR COMBINAR AS CATEGORIAS NOS SEGMENTOS, COMEÇANDO PELA RAIZ.
			$categorias = JCategories::getInstance('Helloworld', array());
			$matchingCategory = $categorias->get('root');
			
			//VÁ ATÉ A ÁRVORE DE CATEGORIAS, TENTE OBTER UMA CORRESPONDÊNCIA ENTRE CADA SEGMENTO E O 'id: alias' DE UM DOS FILHOS.
			//O ÚLTIMA SEGMENTO PODE SER UM ID DE CATEGORIA: ALIAS OU UM ID DE REGISTRO HELLOWORLD: ALIAS.
			for($i = 0; $i < $nSegmentos; $i++){

				$children = $matchingCategory->getChildren();
				$matchingCategory = $this->match($children, $segmentos[$i]);

				if($matchingCategory){

					$catid = $matchingCategory->id;

					//TERMINAR, TODOS OS SEGMENTOS SÃO CATEGORIAS.
					if($i == $nSegmentos - 1){

						$vars['view'] = 'category';
						$vars['id'] = $catid;

					}

				}else{

					//TODOS, EXCETO O ÚLTIMO SEGMENTO, SÃO CATEGORIAS.
					if($i == $nSegmentos - 1){  

						$vars['id'] = $segmentos[$i];
						$vars['view'] = 'helloworld';

					}else{ //DEU RUIM, NÃO OBTEVE A CORRESPONDÊNCIA NESTE NÍVEL

						break;

					}

				}

			}

		}


		return $vars;

		/*//OBTER O BANCO DE DADOS
		$db = JFactory::getDbo();

		//INICIALIAZAR A QUERY.
		$query = $db->getQuery(true);

		//CRIAR A QUERY.
		$query->select('id')->from('#__olamundo')->where('alias=' . $db->quote($segmentos[0]));

		//SETAR A QUERY.
		$db->setQuery($query);

		//OBTER OS RESULTADOS DO BANCO EM FORMA DE ARRAY.
		$id = $db->loadResult();

		//SE ALGUM ID FOR ENCONTRADO.
		if(!empty($id)){

			$vars['id'] = $id;
			$vars['view'] = 'helloworld';

		}*/

	}

	/*
	* ESTA FUNÇÃO USA UM ARRAY DE ELEMENTOS 'categoryNode' E UM SEGMENTO DE URL.
	*
	* ELE PERCORRE OS 'categoryNodes' PROCURANDO AQUELE CUJO O 'id: alias' CORRESPONDE AO
	* SEGMENTO PASSADO.
	*
	* E RETORNA O 'categoryNode' CORRESPONDENTE, OU NULL SE NÃO FOR ENCONTRADO.
	*
	*/

	private function match($categoryNodes, $segment){

		foreach($categoryNodes as $categoriaNode){

			if($segment == $categoriaNode->id . ':' . $categoriaNode->alias){
				return $categoriaNode;
			}

		}

		return null;

	} 

	//FUNÇÃO QUE SERÁ CAHAMADA PRIMEIRO.
	public function preprocess($query){

		//PEGAR A URL (QUERY - 'id, view, itemid, etc').
		return $query;

	}
}

?>