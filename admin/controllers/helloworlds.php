<?php

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//AQUI VAI O CONTROLADOR CHAMADO 'helloworlds'.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerAdmin' - SIGNIFICA QUE USARÁ OS CONTROLES DE ADMINISTRAÇÃO.
class HelloWorldControllerHelloWorlds extends JControllerAdmin{

	//'$nome' - PEGAR O NOME DO MODELO.
	//'$prefixo' - PEGAR O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.

	//FUNÇÃO PARA OBTER O MODELO PARA GERENCIAR ESSE CONTROLADOR.
	public function getModel($nome = 'HelloWorld', $prefixo = 'HelloWorldModel', $config = array('ignore.request' => true)){

		//PASSAR O MODELO PARA UMA VARIÁVEL E AO MESMO TEMPO LANÇÁ-LA PARA O CONTROLADOR.
		$model = parent::getModel($nome, $prefixo, $config);

		//RETORNAR O MODELO.
		return $model;
	}

}

?>