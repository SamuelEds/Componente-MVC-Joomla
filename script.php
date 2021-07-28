<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die("Essa página não pode ser acessada diretamente.");

/*

	- ARQUIVO DE SCRIPT DO COMPONENTE HELLOWORLD.
	
	- NOTE A NOMENCLATURA DA CLASSE, ELA DEVE SEGUIR O PADRÃO: 'com_<nome_componente>InstallerScript', NESTE CASO ESTÁ SENDO USADO 'com_helloWorldInstallerScript'.
	
	- SE ESSE ARQUIVO FOR ESPECIFICADO NO MANIFESTO (helloworld.xml), O INSTALADOR DO JOOMLA IRÁ CAHAMAR A CLASSE ESPECIFICADA.
	
	- ESSE TIPO DE CLASSE É USADO PARA AÇÕES DE AUTOMAÇÃO PERSONALIZADAS NO PROCESSO DE INSTALAÇÃO DO COMPONENTE.

	- PARA ESPECIFICAR ESSE ARQUIVO NO MANIFESTO É PRECISO USAR O COMANDO: '<script>script.php</script>'.

*/

class com_helloWorldInstallerScript{

	//ESTE MÉTODO É CHAMADO APÓS A INSTALAÇÃO DO COMPONENTE.
	// PARÂMETRO '$parent' - OBJETO PAI CHAMANDO ESTE MÉTODOS. 
	public function install($parent){

		//REDIRECIONAR PARA DEETERMINADA URL.
		$parent->getParent()->setRedirectURL('index.php?option=com_helloworld');
	
	}

	//ESTE MÉTODO É CHAMADO DEPOIS QUE UM COMPONENTE É DESINSTALADO.
	//PARÂMETRO '$parent' - OBJETO PAI CHAMANDO ESTE MÉTODO.
	public function uninstall($parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::_('COM_HELLOWORLD_UNINSTALL_TEXT') .' </p>';
	}

	//ESTE MÉTODO É CHAMADO APÓS A ATUALIZAÇÃO DE UM COMPONENTE.
	//PARÂMETRO '$parent' OBJETO DE CHAMADA DO OBJETO PAI.
	public function update($parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::sprintf('COM_HELLOWORLD_UPDATE_TEXT', $parent->get('manifest')->version) .' </p>';
	}

	//ESTE MÉTODO SERÁ EXECUTADO ANTES DE QUALQUER EXECUÇÃO DE INSTALAÇÃO DO COMPONENTE.
	//VERIFICAÇÕES E PRÉ-REQUISITOS DEVEM SER EXECUTADOS NESTA FUNÇÃO.
	//'$type' - TIPO DE AÇÃO PREFLIGHT, OS VALORES SÃO: - INSTALL, - UPDATE, - DISCOVER_INSTALL.
	//'$params' - OBJETO DE CHAMADA DO OBJETO PAI.
	public function preflight($type, $parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::_('COM_HELLOWORLD_PREFLIGHT_'.$type.'_TEXT') .' </p>';
	}

	//ESTE MÉTODO É EXECUTADO APÓS QUALQUER OUTRA EXECUÇÃO DE INSTALAÇÃO DO COMPONENTE.
	//'$type' - TIPO DE AÇÃO PREFLIGHT, OS VALORES SÃO: - INSTALL, - UPDATE, - DISCOVER_INSTALL.
	//'$parent' - OBJETO DE CHAMADA DO OBJETO PAI.
	public function postflight($type, $parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> ' .JText::_('COM_HELLOWORLD_POSTFLIGHT_'.$type.'_TEXT'). ' </p>';
	}
}

?>