<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não ode ser acessada diretamente.');

/*

	- ARQUIVO AUXILIAR DO COMPONENTE 'com_helloworld' PARA GERAR ROTAS DE URL.

*/

class HelloworldHelperRoute{

	public static function getAjaxUrl(){

		/*//OBTER O APLICATIVO
		$aplicativo = JFactory::getApplication();

		//OBTER A ESTRUTUTA DE MENU DO SITE.
		$menuSite = $aplicativo->getMenu();

		//OBTER O MENU ATUAL EM QUE O USUÁRIO SE ENCONTRA.
		$menuAtual = $menuSite->getActive();*/

		//A FUNÇÃO 'JLanguageMultilang::isEnabled()' IRÁ VERIFICAR SE O SITE ESTÁ CONFIGURADO COMO MULTILÍNGUE.
		if(!JLanguageMultilang::isEnabled()){

			return null;

		}

		//OBTER A TAG DO IDIOMA ATUAL ATIVO.
		$lang = JFactory::getLanguage()->getTag();

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();

		//OBTER O OBJETO DO MENU DO SITE.
		$siteMenu = $aplicativo->getMenu();

		//OBTER O ITEM DO MENU ATIVO ATUAL.
		$siteMenuItem = $siteMenu->getActive();

		//SE O USÁRIO ESTIVER NA TELA ATUAL, AO RETORNAR NULO, A URL IRÁ PARA A PÁGINA QUE ESTÁ ATIVA NO MOMENTO.
		/*if(!$menuAtual || $menuAtual->alias == "visualizar-mensagem"){
			return null;
		}*/

		//SE NÃO TEM NENHUM ITEM DE MENU ATIVO OU SE O USUÁRIO JÁ ESTÁ NELE, APENAS PERMANEÇA NELE.
		if(!$siteMenuItem || strpos($siteMenuItem->link, "view=category") !== false || $siteMenuItem->note == "Ajax"){

			return null;

		}

		//PROCURAR UM ITEM DE MENU COM O IDIOMA CORRETO E UM CAMPO DE NOTA "AJAX"
		$menuItem = $menuSite->getItems(array('language', 'note'), array($lang, "Ajax"));
		if($menuItem){

			$itemid = $menuItem[0]->id;
			$url = JRoute::_("index.php?Itemid=".$itemid."&view=helloworld&format=json");

			return $url;

		}else{

			return null;
		}


		//OBTER O MENU PRINCIPAL
		/*$itensMenuPrincipal = $menuSite->getItems('menutype', 'mainmenu');

		foreach($itensMenuPrincipal as $menuItem){

			if($menuItem->alias == "visualizar-mensagem"){

				//OBTER O ID DE CADA ITEM DE MENU.
				$itemid = $menuItem->id;

				//CONSTRUIR A URL DE CADA ITEM DE MENU.
				$url = JRoute::_("index.php?Itemid=$itemid&view=helloworld&format=json");

				//RETORNAR A URL CONSTRUÍDA.
				return $url;

			}

		}*/

	}

}

?>