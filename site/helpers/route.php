<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

/*

	- ARQUIVO AUXILIAR DO COMPONENTE 'com_helloworld' PARA GERAR ROTAS DE URL.

*/

class HelloWorldHelperRoute{

	public static function getAjaxURL(){

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();

		//OBTER A ESTRUTURA DO MENU DO SITE.
		$menuSite = $aplicativo->getMenu();

		//OBTER O MENU QUE ESTÁ ATIVO NO MOMENTO.
		$menuSiteAtual = $menuSite->getActive();

		if(!$menuSiteAtual || $menuSiteAtual->alias == "Mensagens"){

			return null;

		}

		//OBTER A ESTRUTURA DO MENU PRINCIPAL.
		$itensMenuPrincipal = $menuSite->getItems('menutype', 'mainmenu');

		//PROCURAR UM ITEM DE MENU COM O IDIOMA CORRETO E UM CAMPO DE NOTA "AJAX"
		foreach($itensMenuPrincipal as $menuitem){

			if($menuitem->alias == "Mensagens"){

				$itemid = $menuitem->id;
				$url = JRoute::_('index.php?Itemid=' . $itemid . '&view=helloworld&format=json');

				return $url;

			}
		}

		return null;

	}

}

?>