<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

/*

	ARQUIVO AUXILIAR PARA CRIAÇÃO DE SUBMENU.

*/	

//CLASSE ABSTRATA PARA CRIAR O CONTEÚDO AUXILIAR.
//A NOMENCLATURA SEGUE '<nome_componente>Helper'.
//A CLASSE ESTÁ USANDO AS FUNÇÕES DA CLASSE 'JHelperContent'.
abstract class HelloWorldHelper extends JHelperContent{

	//UMA FUNÇÃO ESTÁTICA PARA CONFIGURAR UMA BARRA DE LINK. (LINK BAR).
	//O PARÂMETRO '$submenu' É O NOME DA VIEW QUE ESTÁ ATIVA NO MOMENTO.
	public static function addSubmenu($submenu){

		//CRIAR UMA SIDEBAR (BARRA LATERAL).
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		JHtmlSidebar::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_MESSAGES'), 'index.php?option=com_helloworld', $submenu == 'helloworlds');

		JHtmlSidebar::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_helloworld', $submenu == 'categories');

		//SETAR PROPRIEDADES DO DOCUMENTO.

		//OBTER O DOCUMENTO.
		$documento = JFactory::getDocument();

		//DEFINIR UMA DECLARAÇÃO DE ESTILO.
		$documento->addStyleDeclaration('.icon-48-helloworld'.
										'{background-image: url(../midia/com_helloworld/imagens/espadas-48-x-48.png);}');

		//SE A VIEW QUE ESTIVER ATIVA FOR A VIEW DE CATEGORIAS.
		if($submenu == 'categories'){

			//IRÁ SETAR O TÍTULO DO DOCUMENTO.
			//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			$documento->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
		}

		//VERIFICAR SE O COMPONENTE DE CAMPOS ESTÁ ATIVO.
		if(JComponentHelper::isEnabled('com_fields')){

			//CRIAR UMA SIDEBAR (BARRA LATERAL) PARA OS CAMPOS PERSONALIZÁVEIS.
			//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			JHtmlSidebar::addEntry(

				JText::_('JGLOBAL_FIELDS'),
				'index.php?option=com_fields&context=com_helloworld.helloworld',
				$submenu = 'fields.fields'

			);

			//CRIAR UMA SIDEBAR (BARRA LATERAL) PARA GRUPOS DE CAMPOS.
			//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			JHtmlSidebar::addEntry(

				JText::_('JGLOBAL_FIELD_GROUPS'),
				'index.php?option=com_fields&view=groups&context=com_helloworld.helloworld',
				$submenu = 'fields.groups'

			);

		}
	}

	public static function getContexts(){

		JFactory::getLanguage()->load('com_helloworld', JPATH_ADMINISTRATOR);

		$contexts = array(

			'com_helloworld.helloworld' => JText::_('COM_HELLOWORLD_ITEMS'),
			'com_helloworld.categories' => JText::_('JCATEGORY')

		);

		return $contexts;

	}

	public static function validateSection($section, $item){

		if(JFactory::getApplication()->isClient('site') && $section == 'form'){

			return 'helloworld';

		}

		if($section != 'helloworld' && $section != 'form'){

			return null;

		}

		return $section;

	} 
}

?>