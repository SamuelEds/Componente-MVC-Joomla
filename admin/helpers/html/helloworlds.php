<?php  
/**
 * 
 * ARQUIVO AUXILIAR PARA GERAR O HTML ASSOCIADO À FUNCIONALIDADE DO ADMINISTRADOR HELLOWORLD. 
 * 
 * */

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página nào pode ser acessada diretamente.');

//CARREGAR O MÉTODO 'HelloWorldHelper' DO ARQUIVO 'JPATH_ADMINISTRATOR /components/com_helloworld/helpers/html/helloworlds.php'.
/**
 * A CONSTANTE 'JPATH_ADMINISTRATOR' É UMA CONSTANTE QUE RETORNARÁ O CAMINHO RELATIVO ATÉ A 
 * PASTA 'administrator'.
 * 
 * MAIS CONSTANTES JOOMLA ESTÃO DISPONÍVEIS EM: https://docs.joomla.org/Constants. 
 * 
 * */
JLoader::register('HelloWorldHelper', JPATH_ADMINISTRATOR . '/components/com_helloworld/helpers/helloworld.php');

class JHtmlHelloworlds{

	/**
	 * 
	 * RENDERIZAR A LISTA DE ITENS ASSOCIADOS.
	 * 
	 * @param INTEGER '$id' É O ID DO REGISTRO HELLOWORLD.
	 * 
	 * @return STRING - RETORNA O IDIOMA HTML.
	 * 
	 * @throws EXCEPTION - LANÇAR UMA EXCEÇÃO.   
	 * 
	 * */

	public static function association($id){

		//PADRÕES
		$html = '';

		//OBTER AS ASSOCIAÇÕES.
		if($associations = JLanguageAssociations::getAssociations('com_helloworld', '#__olamundo', 'com_helloworld.item', (int) $id)){

			foreach($associations as $tag => $associado){

				$associations[$tag] = (int) $associado->id;

			}

			//OBTER OS TÍTULOS E OS IDIOMAS DAS CATEGORIAS RELEVANTES, PARA A DICA.

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR O BANCO.
			$query = $db->getQuery(true);

			//CONSTRUIR A CONSULTA.
			$query->select('o.*')
			->select('l.sef AS lang_sef')
			->select('l.lang_code')
			->from('#__olamundo AS o')->select('cat.title AS category_title')
			->join('LEFT', '#__categories AS cat ON cat.id = o.catid')
			->where('o.id IN(' . implode(', ', array_values($associations)) . ')')
			->join('LEFT', '#__languages AS l ON o.language = l.lang_code')
			->select('l.image')
			->select('l.title AS language_title');

			$db->setQuery($query);

			try{

				//CARREGAR OS RESULTADOS COMO OBJETOS.
				$items = $db->loadObjectList('id');

			}catch(RuntimeException $e){

				//LANÇAR UMA EXCEÇÃO.
				throw new Exception($e->getMessage(), 500, $e);

			}

			if($items){

				foreach($items as &$item){

					//CRIAR TODAS AS CONFIGURAÇÕES NECESSÁRIAS.

					$texto = $item->lang_sef ? strtoupper($item->lang_sef) : 'XX';
					
					$url = JRoute::_('index.php?option=com_helloworld&task=helloworld.edit&id=' . (int) $item->id);
					
					$tooltip = htmlspecialchars($item->texto, ENT_QUOTES, 'UTF-8') . '<br />' . JText::sprintf('JCATEGORY_SPRINTF', $item->category_title);
					
					$classes = 'hasPopover label label-association label-' . $item->lang_sef;

					$item->link = '<a href="'. $url .'" title="'. $item->language_title .'" class="'. $classes .'" data-content="'. $tooltip .'" data-placement="top">'. $texto .'</a>'; 

				}

			}

			//IMPORTAR AS DEPENDÊNCIAS NECESSÁRIAS.
			JHtml::_('bootstrap.popover');

			$html = JLayoutHelper::render('joomla.content.associations', $items);

		}

		//RETORNAR TODA A ESTRUTURA CONSTRUÍDA.
		return $html;

	}

}

?>