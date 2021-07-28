<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//AQUI VAI O CONTROLADOR CHAMADO 'helloworld'.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerForm' - SIGNIFICA QUE USARÁ OS CONTROLES DE FORMULÁRIO.
//O COMANDOS EXTENDIDOS, PARA SALVAR, EDITAR, CANCELAR, ETC SERÃO UTILIZADOS AUTOMATICAMENTE QUANDO IMPLEMENTADOS.
class HelloWorldControllerHelloWorld extends JControllerForm{
	
	//IMPLEMENTAR PARA PERMITIR ADICIONAR OU NÃO.
	protected function allowAdd($data = array()){

		//PERMITIR PARA ADICIONAR.
		//NÃO USADO NO MOMENTO (MAS PODE VER COMO OS OUTROS COMPONENTES O USAM).
		//SSUBSTITUI: 'JControllerForm::allowAdd'
		return parent::allowAdd($data);
	}

	//IMPLEMENTAR PARA PERMITIR A EDIÇÃO OU NÃO.
	protected function allowEdit($data = array(), $key = 'id'){
		
		$id = isset($data[$key]) ? $data[$key] : 0;

		if(!empty($id)){

			return JFactory::getUser()->authorise("core.edit", "com_helloworld.helloworld." . $id);
		}
	}

	//MÉTODO QUE SUBSTITUIRÁ O MÉTODO 'batch', ISSO PARA DEFINIR O MODELO E O REDIRECIONAMENTO PARA A URL ATUAL ANTES DE FAZER O LOTE NORMAL.
	public function batch($model = null){

		//OBTER O MODELO 'helloworld'
		$model = $this->getModel('helloworld');

		//REDIRECIONAR DE VOLTAR PARA A URL ATUAL.
		$this->setRedirect((string) JUri::getInstance());

		return parent::batch($model);


	}
}

?>