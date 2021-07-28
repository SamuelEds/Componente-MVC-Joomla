<?php  

//ARQUIVO QUE SERÁ O CONTROLADOR GERAL.

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE QUE HERDARÁ AS FUNÇÕES NECESSÁRIAS PARA O CONTROLLADOR.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DA INSTÂNCIA NO ARQUIVO PRINCIPAL (site/helloworld.php).
class HelloWorldController extends JControllerLegacy{

	//ABAIXO ESTÁ A SEÇÃO DE FAZER UMA SOLICITAÇÃO AJAX.

	public function mapsearch(){

		//CHECAR SE A SESSÃO DO USUÁRIO É VÁLIDA
		if(!JSession::checkToken('get')){
		
			echo new JResponseJson(null, JText::_('JINVALID_TOKEN'), true);
		
		}else{

			parent::display();
		
		}
	}
}

?>