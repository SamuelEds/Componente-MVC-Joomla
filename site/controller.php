<?php  

//ARQUIVO QUE SERÁ O CONTROLADOR GERAL.

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE QUE HERDARÁ AS FUNÇÕES NECESSÁRIAS PARA O CONTROLLADOR. (ELA É VAZIA)
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DA INSTÂNCIA NO ARQUIVO PRINCIPAL (site/helloworld.php).
class HelloWorldController extends JControllerLegacy{

	public function display($cachable = false, $urlparams = array()){

		//OBTER O NOME DA VIEW DO FRONT END ATUAL.
		$nomeView = $this->input->get('view', '');
		$cachable = true;

		if($nomeView == 'form' || JFactory::getUser()->get('id')){

			$cachable = false;

		}

		$safeUrlParams = array(

			'id' 			=> 'INT',
			'catid' 		=> 'ARRAY',
			'list' 			=> 'ARRAY',
			'limitstart' 	=> 'UNINT',
			'Itemid'		=> 'INT',
			'view'			=> 'CMD',
			'lang'			=> 'CMD'

		);

		parent::display($cachable, $safeUrlParams);

	}

	//ABAIXO ESTÁ A SEÇÃO DE FAZER UMA SOLICITAÇÃO AJAX.

	public function mapsearch(){

		//CHECAR SE A SESSÃO DO USUÁRIO É VÁLIDA
		/*if(!JSession::checkToken('get')){
		
			echo new JResponseJson(null, JText::_('JINVALID_TOKEN'), true);
		
		}else{*/

			parent::display();
		
		//}
	}
}

?>