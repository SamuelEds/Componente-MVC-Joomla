<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CLASSE CONTROLADORA GERAL.
class HelloWorldController extends JControllerLegacy{

	//DEFINIR A VIEW PADRÃO DO ADMINISTRADOR.
	//ELE DEVE ESTÁ DECLARADO NA CLÁUSULA 'protected'.
	protected $default_view = 'helloworlds';
}

?>