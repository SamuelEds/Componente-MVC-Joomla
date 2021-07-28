<!--ARQUIVO RESPONSÁVEL PELO CONTROLE DE EXECUÇÕES-->

<?php  

//IMPDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente');

//INSTANCIAR O CONTROLADOR GERAL.
//INFORMAR O NOME DO CONTROLADOR ENTRE PARÊNTESES.
$controle = JControllerLegacy::getInstance('HelloWorld');

//EXECUTAR SOLICITAÇÕES DE TAREFAS.
$controle->execute(JFactory::getApplication()->input->getCmd('task'));

//CONTROLE DE REDIRECIONAMENTO.
//IRÁ REDIRECIONAR SE FOR SETADO PELO CONTROLADOR.
$controle->redirect();

?>