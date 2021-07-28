<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//AQUI VAI O CONTROLADOR CHAMADO 'helloworld'.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerForm' - SIGNIFICA QUE USARÁ OS CONTROLES DE FORMULÁRIO.
//O COMANDOS EXTENDIDOS, PARA SALVAR, EDITAR, CANCELAR, ETC SERÃO UTILIZADOS AUTOMATICAMENTE QUANDO IMPLEMENTADOS.
class HelloWorldControllerHelloWorld extends JControllerForm{

	/**
	 * 
	 * IMPLEMENTAR PARA PERMITIR ADICIONAR OU NÃO.
	 * 
	 * */
	protected function allowAdd($data = array()){

		//PERMITIR PARA ADICIONAR.
		//NÃO USADO NO MOMENTO (MAS PODE VER COMO OS OUTROS COMPONENTES O USAM).
		//SUBSTITUI: 'JControllerForm::allowAdd'.
		return parent::allowAdd($data);

	}

	/**
	 * 
	 * IMPLEMENTAR PARA PERMITIR A EDIÇÃO OU NÃO.
	 * 
	 * */
	protected function allowEdit($data = array(), $key = 'id'){

		$id = isset($data[$key]) ? $data[$key] : 0;

		if(!empty($id)){

			return JFactory::getUser()->authorise('core.edit', 'com_helloworld.helloworld.' . $id);

		}

	}

}

?>