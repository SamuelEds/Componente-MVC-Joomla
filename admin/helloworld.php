<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//OBTER O DOCUMENTO.
$documento = JFactory::getDocument();

//ADICIONAR UMA DELCARAÇÃO AO DOCUMENTO.
$documento->addStyleDeclaration('.icon-helloworld{background-image: url(../media/com_helloworld/images/joao-frango-16-x-16.png);}');

//INSTANCIAR O CONTROLADOR GERAL.
//INFORMAR O NOME DO CONTROLADOR ENTRE PARÊNTESES.
$controle = JControllerLegacy::getInstance('HelloWorld');

//EXECUTAR SOLICITAÇÕES DE TAREFAS.
$controle->execute(JFactory::getApplication()->input->get('task'));

//CONTROLE DE REDIRECIONAMENTO.
//IRÁ REDIRECIONAR SE FOR SETADO PELO CONTROLADOR.
$controle->redirect();

?>