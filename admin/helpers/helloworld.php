<?php  

//IMPEDIRO O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');


/**
 * 
 * ARQUIVO AUXILIAR PARA A CRIAÇÃO DO SUBMENU.
 * 
 * */

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

		//DEFINIR CONFIGURAÇÕES GLOBAIS E CONFIGURAR O DOCUMENTO.
		$documento = JFactory::getDocument();

		//ADICIONAR UMA DECLARAÇÃO CSS AO DOCUMENTO.
		$documento->addStyleDeclaration('.icon-48-helloworld{background-image: url(..media/com_helloworld/images/joao-frango-48-x-48.png);}');

		//SE A VIEW QUE ESTIVER ATIVA FOR A VIEW DE CATEGORIAS.
		if($submenu == 'categories'){

			//IRÁ SETAR O TÍTULO DO DOCUMENTO.
			//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			$documento->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
		}

	}

} 

?>