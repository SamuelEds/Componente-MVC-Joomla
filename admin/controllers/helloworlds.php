<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//AQUI VAI O CONTROLADOR CHAMADO 'helloworlds'.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerAdmin' - SIGNIFICA QUE USARÁ OS CONTROLES DE ADMINISTRAÇÃO.
class HelloWorldControllerHelloWorlds extends JControllerAdmin{

	//'$nome' - PEGAR O NOME DO MODELO.
	//'$prefixo' - PEGAR O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.

	//FUNÇÃO PARA OBTER O MODELO PARA GERENCIAR ESSE CONTROLADOR.
	public function getModel($name = 'HelloWorld', $prefix = 'HelloWorldModel', $config = array('ignore_request' => true)){

		//PASSAR O MODELO PARA UMA VARIÁVEL E AO MESMO TEMPO LANÇÁ-LA PARA O CONTROLADOR.
		$model = parent::getModel($name, $prefix, $config);

		//RETORNAR O MODELO.
		return $model;

	}

}

?>