<?php  

//ARQUIVO RESPONSÁVEL PELO CONTROLE DE EXECUÇÕES

//IMPDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente');

//INSTANCIAR O CONTROLADOR GERAL.
//INFORMAR O NOME DO CONTROLADOR ENTRE PARÊNTESES.
$controle = JControllerLegacy::getInstance('HelloWorld');

//OBTER O INPUT
$input = JFactory::getApplication()->input;

//EXECUTAR SOLICITAÇÕES DE TAREFAS.
$controle->execute($input->getCmd('task'));

//CONTROLE DE REDIRECIONAMENTO.
//IRÁ REDIRECIONAR SE FOR SETADO PELO CONTROLADOR.
$controle->redirect();

?>